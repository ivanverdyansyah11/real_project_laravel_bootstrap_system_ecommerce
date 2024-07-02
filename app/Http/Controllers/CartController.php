<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Cart;
use App\Models\ManagementProduct;
use App\Models\ReportProduct;
use App\Models\Transaction;
use App\Repositories\CartRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\PackageRepositories;
use App\Repositories\PaymentRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\ShippingRepositories;
use App\Repositories\TransactionRepositories;
use App\Utils\UploadFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function __construct(
        protected readonly CartRepositories $cart,
        protected readonly ShippingRepositories $shipping,
        protected readonly TransactionRepositories $transaction,
        protected readonly CustomerRepositories $customer,
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly ResellerRepositories $reseller,
        protected readonly PaymentRepositories $payment,
        protected readonly UploadFile $uploadFile,
        protected readonly ManagementProduct $managementProduct,
    ) {
    }

    public function index(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.cart', [
            'title' => 'Halaman Keranjang',
            'carts' => $this->cart->findAllByUserId(auth()->user()->id),
            'transactions' => $transactions,
        ]);
    }

    public function createSession(Request $request)
    {
        if ($request->cart_id == null) {
            $this->cart->storeTransaction($request);
            $cartIdSelect = $this->cart->findLatest()->id;
        } else {
            foreach ($request->cart_id as $cart_id) {
                $cart = $this->cart->findById($cart_id);
                if ($cart->product->stock < $cart->quantity) {
                    return redirect(route('cart.index'))->with('failed', 'Stock produk telah habis!');
                }
                $cart->update(['status' => 2]);
            }
            $cartIdSelect = implode('+', $request->cart_id);
        }
        return redirect(route('cart.edit', $cartIdSelect));
    }

    public function store(StoreCartRequest $request): RedirectResponse
    {
        try {
            $this->cart->store($request->validated());
            return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan produk di keranjang!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan produk di keranjang!');
        }
    }

    public function storeTransaction(StoreCartRequest $request): RedirectResponse
    {
        try {
            $this->cart->storeTransaction($request->validated());
            return redirect(route('cart.edit', $this->cart->findLatest()->id))->with('success', 'Berhasil menambahkan produk di keranjang!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('product.show', $request['products_id']))->with('failed', 'Gagal beli produk!');
        }
    }

    public function edit($id)
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        $cartIdSelect = explode('+', $id);
        $view = 'homepage.cart-transaction';
        if (count($cartIdSelect) == 1) {
            $cart = $this->cart->findById($id);
            if ($cart->product->stock == 0) {
                $this->cart->delete($cart);
                return redirect(route('cart.index'))->with('failed', 'Stok pada produk ini telah habis!');
            }
            $packages = $this->package->findWhereProduct($cart->quantity, $cart->products_id);
        } else {
            $cart = [];
            foreach ($cartIdSelect as $cartId) {
                $cartSelect = $this->cart->findById($cartId);
                if ($cartSelect->product->stock == 0) {
                    $this->cart->delete($cartSelect);
                    return redirect(route('cart.index'))->with('failed', 'Stok pada produk ' . $cartSelect->product->name . ' telah habis!');
                } else {
                    $cart[] = $cartSelect;
                    $view = 'homepage.cart-transaction-multiple';
                }
            }
            $packages = [];
            foreach ($cart as $item) {
                $packages[] = $this->package->findWhereProduct($item->quantity, $item->products_id);
            }
            $packages = array_filter($packages);
        }

        if (auth()->user()->role == 'reseller') {
            return view($view, [
                'title' => 'Halaman Transaksi Keranjang',
                'cart' => $cart,
                'carts' => $this->cart->findAll(),
                'reseller' => $this->reseller->findByUserId(auth()->user()->id),
                'package' => $packages,
                'transactions' => $transactions,
            ]);
        } elseif (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view($view, [
                'title' => 'Halaman Transaksi Keranjang',
                'cart' => $cart,
                'carts' => $this->cart->findAll(),
                'resellers' => $this->reseller->findAll(),
                'package' => $packages,
                'transactions' => $transactions,
            ]);
        }
    }

    public function storeProduct(StoreTransactionRequest $request, $cart_id)
    {
        try {
            if (str_contains($cart_id, '+') && $request->total == null) {
                $cartIdSelect = explode('+', $cart_id);
                $requestTemporary = [];
                $requestTemporary['invois'] = $request->invois;
                $requestTemporary['shipping'] = $request->shipping;
                $requestTemporary['shipping_price'] = $request->shipping_price;
                $requestTemporary['address'] = ($request->address != null) ? $request->address : null;
                for ($i = 0; $i < count($cartIdSelect); $i++) {
                    $requestTemporary['status'] = 2;
                    $requestTemporary['products_id'] = $request['products_id'][$i];
                    $requestTemporary['customers_id'] = $request['customers_id'];
                    $requestTemporary['resellers_id'] = $request['resellers_id'];
                    $requestTemporary['quantity'] = $request['quantity'][$i];
                    $requestTemporary['price_per_product'] = $request['price_per_product'][$i];
                    $this->cart->storeProduct($requestTemporary, $cartIdSelect[$i]);
                }
                return redirect(route('cart-transaction', $cart_id));
            } elseif (str_contains($cart_id, '+') && $request->total != null) {
                $cartIdSelect = explode('+', $cart_id);
                $request['total'] = str_replace('Rp. ', '', $request['total']);
                $request['total'] = (int) str_replace('.', '', $request['total']);
                if (!empty($request->proof_of_payment)) {
                    $image = $request->file('proof_of_payment');
                    $imageName = date("Ymdhis") . "_" . $image->getClientOriginalName();
                    $image->move(public_path('assets/images/transaction/'), $imageName);
                    $request['proof_of_payment_new'] = $imageName;
                }
                foreach ($cartIdSelect as $id => $cartId) {
                    $cartSelected = $this->cart->findById($cartId);
                    $cartSelectedArray[] = $cartSelected;
                    $product = $this->product->findById($cartSelected->products_id);
                    $this->managementProduct->create([
                        'products_id' => $product->id,
                        'type' => 'purchased',
                        'quantity' => $cartSelected->quantity,
                    ]);
                    $request['stock'] = $product->stock - $cartSelected->quantity;
                    $transactions = $this->transaction->findByInvois($cartSelected->invois);
                    if (auth()->user()->role == 'reseller') {
                        $request['status'] = 0;
                    } else {
                        $request['status'] = 1;
                    }
                    foreach ($transactions as $i => $transaction) {
                        $transaction->update([
                            'payments_id' => $request['payments_id'],
                            'proof_of_payment' => $request['proof_of_payment_new'],
                            'total' => $request['total'],
                            'total_per_product' => $transaction->quantity * $transaction->price_per_product,
                            'total_payment' => $request['total_payment'],
                            'status' => $request['status'],
                        ]);
                    }
                    if ($transactions[$id]->resellers_id != null) {
                        $reseller = $this->reseller->findById($transactions[$id]->resellers_id);
                        $request['poin'] = $reseller->poin + $cartSelected->quantity;
                        $reseller->update(Arr::only($request->all(), 'poin'));
                    }
                    $cartSelected->delete();
                    $product->update(Arr::only($request->all(), 'stock'));
                }
                return redirect(route('order-completed'));
            }

            $cart = $this->cart->findById($cart_id);
            if ($cart->invois == null) {
                $this->cart->storeProduct($request->validated(), $cart_id);
                return redirect(route('cart-transaction', $cart_id));
            } else {
                $this->cart->storeProduct($request->validated(), $cart_id);
                return redirect(route('order-completed'));
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan transaksi baru!');
        }
    }

    public function cartTransaction($cart_id)
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactionNotification = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactionNotification = [];
        }

        $transactions = $this->transaction->findByInvois($cart_id);
        if (count($transactions) > 1) {
            $cart_id = $this->cart->findAllByIdAndInvois($cart_id);
            $cartTemp = [];
            foreach ($cart_id as $cart) {
                $cartTemp[] = $cart->id;
            }
            $cart_id = implode('+', $cartTemp);
        }

        if (str_contains($cart_id, '+')) {
            $view = 'homepage.cart-transaction-multiple-payment';
            $cartIdSelect = explode('+', $cart_id);
            $cart = [];
            $package = [];
            $transaction = [];
            foreach ($cartIdSelect as $i => $carts) {
                $cart[] = $this->cart->findById($carts);
                $package[] = $this->package->findWhereProduct($cart[$i]->quantity, $cart[$i]->products_id);
                $transaction = $this->transaction->findByInvois($cart[$i]->invois);
            }
        } else {
            $view = 'homepage.cart-transaction-payment';
            $cart = $this->cart->findByIdAndInvois($cart_id);
            $transaction = $this->transaction->findByInvois($cart->invois);
            $package = $this->package->findWhereProduct($cart->quantity, $cart->products_id);
        }
        if ($transaction[0]->shipping == 'ekspedisi') {
            $shipping_price = (int)str_replace('.', '', number_format($this->calculateDistance($transaction[0]->address, $this->shipping->findFirst()->address), 1)) * $this->shipping->findFirst()->shipping_price / 10;
            foreach ($transaction as $transac) {
                $transac->update(['shipping_price' => $shipping_price]);
            }
        }
        return view($view, [
            'title' => 'Halaman Transaksi Pembayaran Keranjang',
            'cart' => $cart,
            'carts' => $this->cart->findAll(),
            'shipping' => $this->shipping->findFirst(),
            'transaction' => $transaction,
            'package' => $package,
            'payments' => $this->payment->findAll(),
            'transactions' => $transactionNotification,
        ]);
    }

    function calculateDistance($originAddress, $destinationAddress)
    {
        $originGeocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($originAddress) . "&key=AIzaSyADJk8ffwFqsJC3hlxAgv-p2uaEeY47HAc";
        $originResponse = file_get_contents($originGeocodeUrl);
        $originData = json_decode($originResponse, true);

        if ($originData['status'] != 'OK') {
            return "Failed to geocode origin address. Status: {$originData['status']}";
        }

        $originLat = $originData['results'][0]['geometry']['location']['lat'];
        $originLng = $originData['results'][0]['geometry']['location']['lng'];

        $destinationGeocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($destinationAddress) . "&key=AIzaSyADJk8ffwFqsJC3hlxAgv-p2uaEeY47HAc";
        $destinationResponse = file_get_contents($destinationGeocodeUrl);
        $destinationData = json_decode($destinationResponse, true);

        if ($destinationData['status'] != 'OK') {
            return "Failed to geocode destination address. Status: {$destinationData['status']}";
        }

        $destinationLat = $destinationData['results'][0]['geometry']['location']['lat'];
        $destinationLng = $destinationData['results'][0]['geometry']['location']['lng'];

        $directionsUrl = "https://maps.googleapis.com/maps/api/directions/json?origin=$originLat,$originLng&destination=$destinationLat,$destinationLng&key=AIzaSyADJk8ffwFqsJC3hlxAgv-p2uaEeY47HAc";
        $directionsResponse = file_get_contents($directionsUrl);
        $directionsData = json_decode($directionsResponse, true);

        if ($directionsData['status'] != 'OK') {
            return "Failed to get directions. Status: {$directionsData['status']}";
        }

        $distance = $directionsData['routes'][0]['legs'][0]['distance']['value'];
        return $distance / 1000;
    }

    public function getPayment(int $payment_id): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->payment->findById($payment_id),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari pembayaran dengan ID ' . $payment_id,
            ], 500);
        }
    }

    public function update(StoreTransactionRequest $request, int $cart_id): RedirectResponse
    {
        try {
            $this->cart->update($request->validated(), $cart_id);
            return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan transaksi baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan transaksi baru!');
        }
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        try {
            $this->cart->delete($cart);
            return redirect(route('cart.index'))->with('success', 'Berhasil hapus produk dari keranjang!');
        } catch (\Exception $e) {
            return redirect(route('cart.index'))->with('failed', 'Gagal hapus produk dari keranjang!');
        }
    }
}
