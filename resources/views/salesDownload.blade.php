<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PDF Penjualan</title>
    <style>
        /* Agar teks panjang bisa ter-wrap dan tidak keluar kolom */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 15px;
        }

        td,
        th {
            font-size: 10px;
            padding: 4px;

        }

        /* Supaya padding tetap enak dibaca walau font kecil */
        th,
        td {
            padding: 4px 6px;
        }

        /* Untuk judul group (h3) supaya selalu mulai di halaman baru kecuali yang pertama */
        h2 {
            font-size: 14px
        }

        /* Jika footer mau selalu di bawah */
        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        /* Kalau kamu ingin header dan footer tetap muncul di tiap halaman */
        header,
        footer {
            background: #fff;
        }

        /* Border tabel agar jelas tapi tidak terlalu tebal */
        table,
        th,
        td {
            border: 1px solid #bbb;
        }
    </style>
</head>

<body>
    <header>
        <h1>Data Transaksi Penjualan PT. PHP</h1>
        @if ($start && $end)
            <p>
                Periode:
                @if ($start == $end)
                    {{ $start }}
                @else
                    {{ $start }} s/d {{ $end }}
                @endif
            </p>
        @endif
    </header>

    <footer>
        Halaman <span class="page"></span> dari <span class="topage"></span>
    </footer>

    <main>
        @php
            $grandTotal = 0;
            $grandqty = 0;
        @endphp
        @foreach ($groupedTransactions as $residenceName => $transactions)
            <h3>{{ $residenceName }}</h3>
            <table>
                <tbody>
                    @php
                        $subTotal = 0;
                        $subqty = 0;
                    @endphp
                    @foreach ($transactions as $transaction)
                        @php
                            $subqty += $transaction->jumlah_ayam;
                            $grandqty += $transaction->jumlah_ayam;
                            $subTotal += $transaction->total_harga;
                            $grandTotal += $transaction->total_harga;
                        @endphp
                        <tr>
                            <td style="width: 15%;">{{ $transaction->customers->nama_pelanggan }}</td>
                            <td style="width: 30%;">{{ $transaction->customers->alamat_pelanggan }}</td>
                            <td style="width: 15%;">{{ $transaction->jumlah_ayam }} Ekor</td>
                            <td style="width: 25%;">{{ $transaction->description }}</td>
                            <td style="width: 15%;">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style=" font-weight: bold;">Subtotal {{ $residenceName }}
                        </td>
                        <td colspan="2" style=" font-weight: bold;">{{ $subqty }} Ekor</td>
                        <td style="font-weight: bold;">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
            <table>
                <tr>
                    <td style="width: 45%; font-weight: bold;">GrandTotal {{ $residenceName }}
                    </td>
                    <td style="width: 40%; font-weight: bold;">{{ $grandqty }} Ekor</td>
                    <td style="width: 15%; font-weight: bold;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>

            </table>
    </main>
</body>

</html>
