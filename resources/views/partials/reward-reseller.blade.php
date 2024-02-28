<div class="modal fade" id="rewardModal" tabindex="-1" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rewardModalLabel">Modal Tukar Penghargaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('report-reward.store') }}" method="POST" class="d-inline-block w-100">
                @csrf
                <input type="hidden" name="resellers_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="rewards_id" data-value="rewards_id">
                <div class="modal-body">
                    <p>Apakah kamu yakin untuk tukar dengan penghargaan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal Tukar</button>
                    <button type="submit" class="btn btn-primary">Tukar Penghargaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
