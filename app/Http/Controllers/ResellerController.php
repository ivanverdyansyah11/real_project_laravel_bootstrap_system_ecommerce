<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResellerRequest;
use App\Http\Requests\UpdateResellerRequest;
use App\Models\Reseller;
use App\Repositories\ResellerRepositories;
use Illuminate\Contracts\View\View;

class ResellerController extends Controller
{
    public function __construct(
        protected readonly ResellerRepositories $reseller,
    ) {}

    public function index() {
        return view('reseller.index', [
            'title' => 'Halaman Karyawan',
            'resellers' => $this->reseller->findAll(),
        ]);
    }

    public function show(Reseller $reseller) : View {
        return view('reseller.detail', [
            'title' => 'Halaman Detail Karyawan',
            'reseller' => $this->reseller->findById($reseller->id),
        ]);
    }

    public function approved(int $id) {
        try {
            $this->reseller->approved($id);
            return redirect()->route('reseller.index')->with('success', 'Berhasil menyetujui karyawan');
        } catch (\Exception $e) {
            return redirect()->route('reseller.create')->with('error', 'Gagal menyetujui karyawan');
        }
    }

    public function create() : View {
        return view('reseller.add', [
            'title' => 'Halaman Tambah Karyawan',
        ]);
    }

    public function store(StoreResellerRequest $request) {
        try {
            $this->reseller->store($request->validated());
            return redirect()->route('reseller.index')->with('success', 'Berhasil membuat karyawan baru');
        } catch (\Exception $e) {
            return redirect()->route('reseller.create')->with('error', 'Gagal membuat karyawan baru');
        }
    }

    public function edit(Reseller $reseller) : View {
        return view('reseller.edit', [
            'title' => 'Halaman Edit Karyawan',
            'reseller' => $this->reseller->findById($reseller->id),
        ]);
    }

    public function update(UpdateResellerRequest $request, Reseller $reseller) {
        try {
            $this->reseller->update($request->validated(), $reseller);
            return redirect()->route('reseller.index')->with('success', 'Berhasil edit karyawan');
        } catch (\Exception $e) {
            return redirect()->route('reseller.edit')->with('error', 'Gagal edit karyawan');
        }
    }

    public function destroy(Reseller $reseller) {
        try {
            $this->reseller->delete($reseller);
            return redirect(route('reseller.index'))->with('success', 'Berhasil hapus karyawan!');
        } catch (\Exception $e) {
            return redirect(route('reseller.index'))->with('failed', 'Gagal hapus karyawan!');
        }
    }
}
