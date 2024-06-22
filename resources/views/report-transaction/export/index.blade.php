<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Transaksi Berhasil</title>
    <style>
        p,
        td {
            margin: 0;
            padding: 0;
            font-size: 0.875rem;
        }

        .border-table {
            border-collapse: collapse;
        }

        .border-table,
        .border-table td {
            border: 1px solid black;
        }

        .border-table td {
            padding: 4px;
        }
    </style>
</head>

<body>
    <table style="width: 500px;">
        <tr>
            <td><img src="{{ url('assets/images/brand/brand-logo.png') }}" alt="Brand Logo PNG" width="70">
            </td>
            <td style="padding-left: 16px;">
                <p>Jalan. Ahmad Yani Utara Gg Sriti No. 9 Peguyangan, Kec. Denpasar Utara,
                    Kota Denpasar, Bali 80115</p>
                <p style="margin-top: 6px;">Telp. 0877-8948-8173</p>
            </td>
        </tr>
    </table>

    <table class="border-table" style="position: absolute; top: 0; right: 0; width: 300px;">
        <tr>
            <td style="text-align: center; background-color: lightgray;" colspan="2">PT. ADIGOEROE SIWA AMBARA</td>
        </tr>
        <tr>
            <td>No. Invoice</td>
            <td>{{ $transactions[0]->invois }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>{{ $transactions[0]->created_at }}</td>
        </tr>
    </table>

    <p style="text-transform: uppercase; margin-top: 42px;">Nama:
        {{ $transactions[0]->buyers_name ? $transactions[0]->buyers_name : '-' }}</p>

    <table class="border-table" style="width: 100%; margin-top: 6px;">
        <tr>
            <td style="text-transform: uppercase; text-align: center; background-color: lightgray;">Nama Paket</td>
            <td style="text-transform: uppercase; text-align: center; background-color: lightgray;">Nama Produk</td>
            <td style="text-transform: uppercase; text-align: center; background-color: lightgray;">Jumlah</td>
            <td style="text-transform: uppercase; text-align: center; background-color: lightgray;">Satuan</td>
            <td style="text-transform: uppercase; text-align: center; background-color: lightgray;">Total</td>
        </tr>
        @foreach ($transactions as $transaction)
            <tr>
                @php
                    $packageName = '-';
                    $packages = array_filter($packages);
                    if (count($packages) != 0 && count($transactions) != 1) {
                        foreach ($packages as $package) {
                            if ($package->products_id == $transaction->product->id) {
                                $packageName = $package->name;
                            }
                        }
                    } elseif (count($packages) != 0) {
                        if ($packages[0] != null) {
                            $packageName = $packages[0]->name;
                        }
                    }
                    $packagePrice = $transaction->product->selling_price;
                    if (count($packages) != 0 && count($transactions) != 1) {
                        foreach ($packages as $package) {
                            if ($package->products_id == $transaction->product->id) {
                                $packagePrice = $package->selling_price;
                            }
                        }
                    } elseif (count($packages) != 0) {
                        if ($packages[0] != null) {
                            $packagePrice = $packages[0]->selling_price;
                        }
                    }
                @endphp
                <td style="text-transform: uppercase;">{{ $packageName != '' ? $packageName : '-' }}</td>
                <td>{{ $transaction->product->name }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>Rp. {{ number_format($packagePrice, 2, ',', '.') }}</td>
                <td>Rp.
                    {{ $transaction->total_per_product == null ? number_format($transaction->total_payment, 2, ',', '.') : number_format($transaction->total_per_product, 2, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
            <td>
                <p style="opacity: 0;">hidden</p>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-transform: uppercase !important;">Total Seluruh Produk :</td>
            <td style="background-color: yellow;">Rp. {{ number_format($transaction->total, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top: 12px !important; padding-bottom: 12px !important;">
                <p style="text-transform: uppercase;">Ongkir :
                    {{ $transaction->shipping == 'ekspedisi' ? 'Rp. ' . number_format($transaction->shipping_price, 2, ',', '.') : 'Rp. 0' }}
                </p>
                <p style="text-transform: uppercase; margin-top: 6px">Lain - Lain :</p>
                <table style="width: 100%; border: none !important; margin-top: 32px;">
                    <tr>
                        <td style="text-transform: uppercase !important; border: none !important; padding: 0;">
                            Keterangan : </td>
                        <td style="border: none !important; padding: 0;">Pembayaran Transfer :
                            {{ $transaction->payment ? $transaction->payment->bank_name : '-' }}</td>
                        <td style="border: none !important; padding: 0;">
                            <p style="opacity: 0;">hidden</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 0; padding-top: 16px;">
                            <p style="text-align: center !important;">Dibuat Oleh :</p>
                        </td>
                        <td style="border: none !important; padding: 0; padding-top: 16px;">
                            <p style="text-align: center !important;">Diketahui Oleh :</p>
                        </td>
                        <td style="border: none !important; padding: 0; padding-top: 16px;">
                            <p style="text-align: center !important;">Diterima Oleh :</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none !important; padding: 0; padding-top: 82px;">
                            <p style="text-align: center !important;">( Admin )</p>
                        </td>
                        <td style="border: none !important; padding: 0; padding-top: 82px;">
                            <p style="text-align: center !important;">( .................. )</p>
                        </td>
                        <td style="border: none !important; padding: 0; padding-top: 82px;">
                            <p style="text-align: center !important;">( .................. )</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="padding-top: 24px; padding-bottom: 24px; background-color: lightyellow; width: 180px;">
                <p style="text-transform: uppercase; text-align: center !important;">Barang yang sudah di beli tidak
                    dapat
                    dikembalikan!</p>
            </td>
        </tr>
    </table>
</body>

</html>
