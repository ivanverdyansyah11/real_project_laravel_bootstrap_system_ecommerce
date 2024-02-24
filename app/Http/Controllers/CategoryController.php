<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() : View {
        return view('category.index', [
            'title' => 'Halaman Kategori',
        ]);
    }

    public function create() : View {
        return view('category.add', [
            'title' => 'Halaman Tambah Kategori',
        ]);
    }

    public function store(StoreCategoryRequest $request) {
        dd($request->all());
    }

    public function edit() : View {
        return view('reseller.edit', [
            'title' => 'Halaman Edit Kategori',
        ]);
    }

    public function update(UpdateCategoryRequest $request) {
        dd($request->all());
    }

    public function destroy($id) {
        dd($id);
    }
}
