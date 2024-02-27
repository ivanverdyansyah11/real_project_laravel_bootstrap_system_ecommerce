<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Modal Tambah Penghargaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reward.store') }}" method="POST" class="d-inline-block w-100">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="points_required" class="form-label">Poin Dibutuhkan</label>
                        <input required type="number" class="form-control @error('points_required') is-invalid @enderror" id="points_required" name="points_required" value="{{ old('points_required') }}">
                        @error('points_required')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea required rows="4" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Tambah</button>
                    <button type="submit" class="btn btn-primary">Tambah Penghargaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Modal Detail Penghargaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="d-inline-block w-100">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input readonly type="text" class="form-control" id="name" data-value="name">
                    </div>
                    <div class="mb-3">
                        <label for="points_required" class="form-label">Poin Dibutuhkan</label>
                        <input readonly type="number" class="form-control" id="points_required" data-value="points_required">
                    </div>
                    <div class="mb-0">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea readonly rows="4" class="form-control" id="description" data-value="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup Modal Penghargaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Modal Edit Penghargaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonEditReward" method="POST" class="d-inline-block w-100">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" data-value="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="points_required" class="form-label">Poin Dibutuhkan</label>
                        <input required type="number" class="form-control @error('points_required') is-invalid @enderror" id="points_required" name="points_required" data-value="points_required">
                        @error('points_required')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea required rows="4" class="form-control @error('description') is-invalid @enderror" id="description" name="description" data-value="description"></textarea>
                        @error('description')
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
                <h1 class="modal-title fs-5" id="deleteModalLabel">Modal Hapus Penghargaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buttonDeleteReward" method="POST" class="d-inline-block w-100">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk menghapus penghargaan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Hapus</button>
                    <button type="submit" class="btn btn-primary">Hapus Penghargaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
