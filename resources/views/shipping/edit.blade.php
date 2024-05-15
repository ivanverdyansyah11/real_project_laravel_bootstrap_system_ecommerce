@extends('layouts.main')

@section('content-dashboard')
    <div class="row me-lg-4 pb-4 d-none d-md-inline-block" style="margin-top: 32px;">
        <div class="col-12 pe-lg-0">
            @if (session()->has('failed'))
                <div class="alert alert-danger w-100 mb-3" role="alert">
                    {{ session('failed') }}
                </div>
            @endif
            <form class="row row-cols-1" action="{{ route('shipping.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mb-3">
                    <label for="shipping_price" class="form-label">Harga Pengiriman</label>
                    <input required type="number" class="form-control @error('shipping_price') is-invalid @enderror"
                        id="shipping_price" name="shipping_price" value="{{ $shipping->shipping_price }}">
                    @error('shipping_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
                <div class="col-12 mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input required type="text" class="form-control @error('address') is-invalid @enderror"
                        id="address" name="address" value="{{ $shipping->address }}" readonly required>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col d-flex gap-2 mt-2">
                    <button type="submit" class="button-primary">Simpan Perubahan</button>
                    <a href="{{ route('shipping.index') }}" class="button-dark">Batal Edit</a>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            function getAddressFromLatLng(latitude, longitude) {
                let url =
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyADJk8ffwFqsJC3hlxAgv-p2uaEeY47HAc`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'OK') {
                            let address = data.results[0].formatted_address;
                            $('#address').val(address);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            let map = L.map('map').setView([-8.630072702457348, 115.20958478281852], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            function onMapClick(e) {
                getAddressFromLatLng(e.latlng.lat, e.latlng.lng)
            }
            map.on('click', onMapClick);
        </script>
    @endpush
@endsection
