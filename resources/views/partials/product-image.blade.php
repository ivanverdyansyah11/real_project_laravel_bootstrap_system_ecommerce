<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Modal Tanbah Gambar Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('thumbnail-image.create') }}" method="POST" class="d-inline-block w-100"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="products_id" value="{{ $product_images[0]->products_id }}">
                    <input type="hidden" name="status" value="0">
                    <div class="col mb-3 d-flex flex-column">
                        <label for="image" class="form-label">Foto Produk</label>
                        <img src="{{ asset('assets/images/other/img-not-found.jpg') }}" alt="Image Not Found"
                            class="rounded mb-2 img-preview" width="100" height="100" style="object-fit: cover;">
                        <input required type="file"
                            class="form-control input-file @error('image') is-invalid @enderror" name="image"
                            id="image">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Tambah</button>
                    <button type="submit" class="btn btn-primary">Tambah Gambar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="thumbnailModal" tabindex="-1" aria-labelledby="thumbnailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="thumbnailModalLabel">Modal Ubah Thumbnail Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonEditProductImage" method="POST" class="d-inline-block w-100">
                @csrf
                <div class="modal-body">
                    <p>Apakah kamu yakin mengganti thumbnail gambar pada produk ini?</p>
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
                <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Gambar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonDeleteImage" method="POST" class="d-inline-block w-100">
                @csrf
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menghapus gambar ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Hapus</button>
                    <button type="submit" class="btn btn-primary">Hapus Gambar</button>
                </div>
            </form>
        </div>
    </div>
</div>
