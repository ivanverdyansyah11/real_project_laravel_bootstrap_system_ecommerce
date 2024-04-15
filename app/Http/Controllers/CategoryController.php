<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function __construct(
        protected readonly CategoryRepositories $category,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
        return view('category.index', [
            'title' => 'Halaman Kategori',
            'categories' => $this->category->findAllPaginate(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->category->findById($category->id),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari kategori dengan ID ' . $category->id,
            ], 500);
        }
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            $this->category->store($request->validated());
            return redirect(route('category.index'))->with('success', 'Berhasil menambahkan kategori baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('category.index'))->with('failed', 'Gagal menambahkan kategori baru!');
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $this->category->update($request->validated(), $category);
            return redirect(route('category.index'))->with('success', 'Berhasil edit kategori!');
        } catch (\Exception $e) {
            return redirect(route('category.index'))->with('failed', 'Gagal edit kategori!');
        }
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $this->category->delete($category);
            return redirect(route('category.index'))->with('success', 'Berhasil hapus kategori!');
        } catch (\Exception $e) {
            return redirect(route('category.index'))->with('failed', 'Gagal hapus kategori!');
        }
    }
}
