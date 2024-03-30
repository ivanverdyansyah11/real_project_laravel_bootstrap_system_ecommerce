<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="approveModalLabel">Modal Konfirmasi Total Pengiriman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonApprovedShipping" method="POST" class="d-inline-block w-100">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="shipping_price" class="form-label">Total Pengiriman</label>
                        <input required type="number"
                            class="form-control @error('shipping_price') is-invalid @enderror" id="shipping_price"
                            name="shipping_price" value="{{ old('shipping_price') }}">
                        @error('shipping_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Setujui</button>
                    <button type="submit" class="btn btn-primary">Setujui Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>
