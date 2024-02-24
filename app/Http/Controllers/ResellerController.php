<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResellerRequest;
use App\Http\Requests\UpdateResellerRequest;
use App\Models\Reseller;
use App\Repositories\ResellerRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function create() : View {
        return view('reseller.add', [
            'title' => 'Halaman Tambah Karyawan',
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());
        try {
            $this->reseller->store($request->validated());
            return redirect()->route('reseller.index')->with('success', 'Successfully create new reseller');
        } catch (\Exception $e) {            
            return redirect()->route('reseller.index')->with('error', 'Failed create new reseller');
        }
    }

    public function edit(Reseller $reseller) : View {
        return view('reseller.edit', [
            'title' => 'Halaman Edit Karyawan',
            'reseller' => $this->reseller->findById($reseller->id),
        ]);
    }

    public function update(UpdateResellerRequest $request) {
        dd($request->all());
    }

    public function destroy($id) {
        dd($id);
    }
}
