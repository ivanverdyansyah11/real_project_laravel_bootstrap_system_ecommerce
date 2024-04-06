<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Kasir pada Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonDeleteCashier" method="POST" class="d-inline-block w-100">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menghapus kasir pada produk ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Hapus</button>
                    <button type="submit" class="btn btn-primary">Hapus Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
