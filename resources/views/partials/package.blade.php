<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Modal Tambah Paket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('package.store') }}" method="POST" class="d-inline-block w-100">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="products_id" class="form-label">Nama Product</label>
                        <select required class="form-control @error('products_id') is-invalid @enderror" id="products_id" name="products_id">
                            <option value="">Pilih produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('products_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Kuantitas</label>
                        <input required type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Per Botol</label>
                        <input required type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price') }}">
                        @error('selling_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Tambah</button>
                    <button type="submit" class="btn btn-primary">Tambah Paket</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Modal Detail Paket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="d-inline-block w-100">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="products_id" class="form-label">Nama Product</label>
                        <input readonly type="text" class="form-control" id="products_id" data-value="products_id">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket</label>
                        <input readonly type="text" class="form-control" id="name" data-value="name">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Kuantitas</label>
                        <input readonly type="number" class="form-control" id="quantity" name="quantity" data-value="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Per Botol</label>
                        <input readonly type="text" class="form-control" id="selling_price" name="selling_price" data-value="selling_price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup Modal Paket</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Modal Edit Paket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonEditPackage" method="POST" class="d-inline-block w-100">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="products_id" class="form-label">Nama Produk</label>
                        <select required class="form-control @error('products_id') is-invalid @enderror" id="products_id" name="products_id" data-element="row-edit-select">
                        </select>
                        @error('products_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" data-value="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Kuantitas</label>
                        <input required type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" data-value="quantity">
                        @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Harga Per Botol</label>
                        <input required type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" data-value="selling_price">
                        @error('selling_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Edit</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Paket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonDeletePackage" method="POST" class="d-inline-block w-100">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menghapus paket ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Hapus</button>
                    <button type="submit" class="btn btn-primary">Hapus Paket</button>
                </div>
            </form>
        </div>
    </div>
</div>
