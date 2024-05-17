<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Modal Edit Managemen Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonEditManagementProduct" method="POST" class="d-inline-block w-100">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input required type="hidden" class="form-control" id="products_id" name="products_id"
                        data-value="products_id">
                    <div class=" mb-3">
                        <label for="quantity" class="form-label">Kuantitas</label>
                        <input required type="number" class="form-control @error('quantity') is-invalid @enderror"
                            id="quantity" name="quantity" value="{{ old('quantity') }}" data-value="quantity">
                        @error('quantity')
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
                <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Managemen Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonDeleteManagementProduct" method="POST" class="d-inline-block w-100">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menghapus managemen produk ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Hapus</button>
                    <button type="submit" class="btn btn-primary">Hapus Managemen Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
