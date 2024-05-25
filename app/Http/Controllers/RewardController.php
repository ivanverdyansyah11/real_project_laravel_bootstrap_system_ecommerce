<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Reward;
use App\Repositories\ResellerRepositories;
use App\Repositories\RewardRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RewardController extends Controller
{
    public function __construct(
        protected readonly RewardRepositories $reward,
        protected readonly ResellerRepositories $reseller,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view('reward.index', [
                'title' => 'Halaman Penghargaan',
                'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
                'rewards' => $this->reward->findAllPaginate(),
                'transaction_pendings' => $this->transaction->findAllWherePending(),
                'transaction_payments' => $this->transaction->findAllWherePayment(),
            ]);
        } elseif (auth()->user()->role == 'reseller') {
            return view('reward.index-reseller', [
                'title' => 'Halaman Penghargaan',
                'rewards' => $this->reward->findAllPaginate(),
                'total_poin' => $this->reseller->findByUserId(auth()->user()->id)->poin,
                'transaction_pendings' => $this->transaction->findAllWherePending(),
                'transaction_payments' => $this->transaction->findAllWherePayment(),
            ]);
        }
    }

    public function show(Reward $reward): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->reward->findById($reward->id),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari penghargaan dengan ID ' . $reward->id,
            ], 500);
        }
    }

    public function store(StoreRewardRequest $request): RedirectResponse
    {
        try {
            $this->reward->store($request->validated());
            return redirect(route('reward.index'))->with('success', 'Berhasil menambahkan penghargaan baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('reward.index'))->with('failed', 'Gagal menambahkan penghargaan baru!');
        }
    }

    public function update(UpdateRewardRequest $request, Reward $reward): RedirectResponse
    {
        try {
            $this->reward->update($request->validated(), $reward);
            return redirect(route('reward.index'))->with('success', 'Berhasil edit penghargaan!');
        } catch (\Exception $e) {
            return redirect(route('reward.index'))->with('failed', 'Gagal edit penghargaan!');
        }
    }

    public function destroy(Reward $reward): RedirectResponse
    {
        try {
            $this->reward->delete($reward);
            return redirect(route('reward.index'))->with('success', 'Berhasil hapus penghargaan!');
        } catch (\Exception $e) {
            return redirect(route('reward.index'))->with('failed', 'Gagal hapus penghargaan!');
        }
    }
}
