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
            font-size: 16px;
            padding: 4px;

        }

        th,
        td {
            padding: 4px 6px;
        }

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




    </style>
</head>

<body>
    <header>
        <h1>Data Ayam untuk Penjualan PT. PHP</h1>
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
        @endphp
        @foreach ($ChckenType as $chick)
        @php
            $grandTotal += $chick->total_qty;
        @endphp
            <table>
                <tbody>
                    <tr>
                        <td style="width: 30%;">{{ $chick->size }}:</td>
                        <td style="width: 30%;">{{ $chick->total_qty}} Ekor</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
        <table>
            <tr>
                <td style="width: 30%;">Total Chicken :</td>
                <td style="width: 30%;">{{ $grandTotal}} Ekor</td>
            </tr>

        </table>
    </main>
</body>

</html>
