<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\AdminRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\ProfileRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function __construct(
        protected readonly AdminRepositories $admin,
        protected readonly ResellerRepositories $reseller,
        protected readonly CustomerRepositories $customer,
        protected readonly ProfileRepositories $profile,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view('profile.index', [
                'title' => 'Halaman Profil',
                'profile' => $this->admin->findById(auth()->user()->admin->id),
                'transaction_pendings' => $this->transaction->findAllWherePending(),
                'transaction_payments' => $this->transaction->findAllWherePayment(),
            ]);
        } else {
            return view('profile.index', [
                'title' => 'Halaman Profil',
                'profile' => $this->reseller->findByUserId(auth()->user()->id),
                'transaction_pendings' => $this->transaction->findAllWherePending(),
                'transaction_payments' => $this->transaction->findAllWherePayment(),
            ]);
        }
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        try {
            if ($request->password !== $request->confirmation_password) {
                return redirect(route('profile.index'))->with('failed-password', "Password tidak sesuai!");
            }
            $this->profile->update($request->validated());
            if (auth()->user()->role == 'customer') {
                return redirect(route('profile'))->with('success', "Berhasil edit profil anda!");
            } else {
                return redirect(route('profile.index'))->with('success', "Berhasil edit profil anda!");
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('profile.index'))->with('failed', "Gagal edit profil anda!");
        }
    }
}
