@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('success'))
                <div class="alert alert-success w-100 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger w-100 mb-4" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <div class="row mb-4">
                <div class="col-12">
                    <div class="dashboard-menu d-flex justify-content-between p-3">
                        <div class="wrapper w-100 ">
                            <p class="menu-title mb-2">Total Poin Reseller ({{ $total_poin }} poin)</p>
                            <progress id="file" value="{{ $total_poin }}" max="1000"></progress>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
                @foreach ($rewards as $reward)
                    <div class="col">
                        <div class="card card-reward mb-3" data-bs-toggle="modal" data-bs-target="#rewardModal"
                            data-id="{{ $reward->id }}">
                            <img src="{{ file_exists('assets/images/reward/' . $reward->image) && $reward->image ? asset('assets/images/reward/' . $reward->image) : asset('assets/images/other/img-not-found.jpg') }}"
                                class="card-img-top" height="200" style="object-fit: cover;">
                            <div class="card-body card-body-reward rounded">
                                <h5 class="card-body-title mb-2">{{ $reward->name }}</h5>
                                <p class="card-body-text mb-3">{!! $reward->description !!}</p>
                                <button type="button" class="badge-primary">{{ $reward->points_required }} Poin
                                    dibutuhkan</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('partials.reward-reseller')
    @push('js')
        <script>
            $(document).on('click', '[data-bs-target="#rewardModal"]', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/reward/' + id,
                    success: function(reward) {
                        if (reward.status == 'success') {
                            $('[data-value="rewards_id"]').val(reward.data.id);
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
