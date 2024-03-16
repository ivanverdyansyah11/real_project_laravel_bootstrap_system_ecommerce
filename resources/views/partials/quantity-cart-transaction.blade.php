<div class="modal fade" id="quantityTransactionModal" tabindex="-1" aria-labelledby="quantityTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="quantityTransactionModalLabel">Kuntitas Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Kuantitas</label>
                    <input required type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" max="{{ $product->stock }}">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Beli</button>
                <button type="submit" class="btn btn-primary">Beli Sekarang</button>
            </div>
        </div>
    </div>
</div>
