<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PackageController extends Controller
{
    public function __construct(
        protected readonly PackageRepositories $package,
        protected readonly ProductRepositories $product,
    ) {}

    public function index() : View {
        return view('package.index', [
            'title' => 'Halaman Paket',
            'packages' => $this->package->findAllPaginate(),
            'products' => $this->product->findAll(),
        ]);
    }

    public function show(Package $package) : JsonResponse {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->package->findById($package->id),
                'products' => $this->product->findAll(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari paket dengan ID ' . $package->id,
            ], 500);
        }
    }

    public function store(StorePackageRequest $request) : RedirectResponse {
        try {
            $this->package->store($request->validated());
            return redirect(route('package.index'))->with('success', 'Berhasil menambahkan paket baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('package.index'))->with('failed', 'Gagal menambahkan paket baru!');
        }
    }

    public function update(UpdatePackageRequest $request, Package $package) : RedirectResponse {
        try {
            $this->package->update($request->validated(), $package);
            return redirect(route('package.index'))->with('success', 'Berhasil edit paket!');
        } catch (\Exception $e) {
            return redirect(route('package.index'))->with('failed', 'Gagal edit paket!');
        }
    }

    public function destroy(Package $package) : RedirectResponse {
        try {
            $this->package->delete($package);
            return redirect(route('package.index'))->with('success', 'Berhasil hapus paket!');
        } catch (\Exception $e) {
            return redirect(route('package.index'))->with('failed', 'Gagal hapus paket!');
        }
    }
}
