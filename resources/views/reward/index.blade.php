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
            <button type="button" class="d-none d-md-inline-block button-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">Buat Penghargaan</button>
            <div class="wrapper-table">
                <table id="table_reward" class="table display responsive nowrap table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Penghargaan</th>
                            <th>Deskripsi</th>
                            <th>Poin Dibutuhkan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rewards->count() == 0)
                            <tr>
                                <td>Data penghargaan tidak ditemukan!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($rewards as $i => $reward)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ Str::limit($reward->description, 50) }}</td>
                                    <td>{{ $reward->points_required }}</td>
                                    <td class="wrapper d-flex gap-2">
                                        <button type="button" class="button-detail d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $reward->id }}">
                                            <img src="{{ asset('assets/images/icons/detail.png') }}" alt="Detail Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-edit d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $reward->id }}">
                                            <img src="{{ asset('assets/images/icons/edit.png') }}" alt="Edit Icon" class="img-fluid" width="16">
                                        </a>
                                        <button type="button" class="button-delete d-none d-md-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $reward->id }}">
                                            <img src="{{ asset('assets/images/icons/delete.png') }}" alt="Delete Icon" class="img-fluid" width="16">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.reward')
    @push('js')
        <script>
            $('#table_reward').DataTable( {
                responsive: true
            } );

            const tagImage = document.querySelector('.img-preview');
            const inputImage = document.querySelector('.input-file');
            const tagImageEdit = document.querySelector('.img-preview-edit');
            const inputImageEdit = document.querySelector('.input-file-edit');

            inputImage.addEventListener('change', function() {
                tagImage.src = URL.createObjectURL(inputImage.files[0]);
            });

            inputImageEdit.addEventListener('change', function() {
                tagImageEdit.src = URL.createObjectURL(inputImageEdit.files[0]);
            });

            $(document).on('click', '[data-bs-target="#detailModal"]', function() {
                let id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/reward/' + id,
                    success: function(reward) {
                        if (reward.status == 'success') {
                            $('[data-value="image"]').attr('src', reward.data.image ? window.location.origin + '/assets/images/reward/' + reward.data.image : window.location.origin + '/assets/images/other/img-not-found.jpg');
                            $('[data-value="name"]').val(reward.data.name);
                            $('[data-value="points_required"]').val(reward.data.points_required);
                            $('[data-value="description"]').html(reward.data.description);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#editModal"]', function() {
                let id = $(this).data('id');
                $('#buttonEditReward').attr('action', '/reward/' + id);
                $.ajax({
                    type: 'get',
                    url: '/reward/' + id,
                    success: function(reward) {
                        if (reward.status == 'success') {
                            $('[data-value="image"]').attr('src', reward.data.image ? window.location.origin + '/assets/images/reward/' + reward.data.image : window.location.origin + '/assets/images/other/img-not-found.jpg');
                            $('[data-value="name"]').val(reward.data.name);
                            $('[data-value="points_required"]').val(reward.data.points_required);
                            $('[data-value="description"]').html(reward.data.description);
                        }
                    }
                });
            });

            $(document).on('click', '[data-bs-target="#deleteModal"]', function() {
                let id = $(this).data('id');
                $('#buttonDeleteReward').attr('action', '/reward/' + id);
            });
        </script>
    @endpush
@endsection
