<div class="modal fade" id="searchingModal" tabindex="-1" aria-labelledby="searchingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('products') }}" class="w-100">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="searchingModalLabel">Modal Cari Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="search" class="form-label">Nama Produk</label>
                        <input required type="text" class="form-control" id="search" name="search"
                            placeholder="Cari produk sekarang..">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Cari</button>
                    <button type="submit" class="btn btn-primary">Cari Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
