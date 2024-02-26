<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepositories;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected readonly CustomerRepositories $customer,
    ) {}

    public function index() : View {
        return view('customer.index', [
            'title' => 'Halaman Pelanggan',
            'customers' => $this->customer->findAll(),
        ]);
    }

    public function show(Customer $customer) : View {
        return view('customer.detail', [
            'title' => 'Halaman Detail Pelanggan',
            'customer' => $this->customer->findById($customer->id),
        ]);
    }

    public function create() : View {
        return view('customer.add', [
            'title' => 'Halaman Tambah Pelanggan',
        ]);
    }

    public function store(StoreCustomerRequest $request) {
        try {
            $this->customer->store($request->validated());
            return redirect()->route('customer.index')->with('success', 'Berhasil membuat pelanggan baru');
        } catch (\Exception $e) {
            return redirect()->route('customer.create')->with('error', 'Gagal membuat pelanggan baru');
        }
    }

    public function edit(Customer $customer) : View {
        return view('customer.edit', [
            'title' => 'Halaman Edit Pelanggan',
            'customer' => $this->customer->findById($customer->id),
        ]);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) {
        try {
            $this->customer->update($request->validated(), $customer);
            return redirect()->route('customer.index')->with('success', 'Berhasil edit pelanggan');
        } catch (\Exception $e) {
            return redirect()->route('customer.edit')->with('error', 'Gagal edit pelanggan');
        }
    }

    public function destroy(Customer $customer) {
        try {
            $this->customer->delete($customer);
            return redirect(route('customer.index'))->with('success', 'Berhasil hapus pelanggan!');
        } catch (\Exception $e) {
            return redirect(route('customer.index'))->with('failed', 'Gagal hapus pelanggan!');
        }
    }
}
