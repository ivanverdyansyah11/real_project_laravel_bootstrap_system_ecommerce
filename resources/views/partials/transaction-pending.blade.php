<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="approveModalLabel">Modal Setujui Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonApprovedTransaction" method="POST" class="d-inline-block w-100">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menyetujui transaksi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Setujui</button>
                    <button type="submit" class="btn btn-primary">Setujui Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
