<html>

<head>
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
    @page {
        margin: 20px;
    }

    body {
        margin: 0px;

    }

    table.background {}

    * {
        font-family: Verdana, Arial, sans-serif;
    }

    a {
        color: #fff;
        text-decoration: none;
    }

    table {
        font-size: x-small;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: x-small;
    }

    body img {
        vertical-align: middle;
        /* opacity: 0.5; */
    }

    .invoice table {
        margin: 15px;
    }

    .invoice h3 {
        margin-left: 15px;
    }

    .information {
        background-color: #fff;
        color: #2875c6;
    }

    .information .logo {}

    .information table {
        padding: 0px;
    }

    #watermark {
        position: fixed;
        top: 45%;
        width: 100%;
        text-align: center;
        opacity: .6;
        z-index: -1000;
        font-size: 5em;

    }
    </style>
    <?php
function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
?>
</head>


<body>
    <div class="information">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="width: 20%;">
                    </td>
                    <td align="center" style="width: inherit;">
                        <center>
                            <h2>Transaksi </h2>
                        </center>
                    </td>
                    <td align="left" style="width: 20%;">
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="3"
                        style="width: inherit; border-bottom:1px solid #000; border-top:1px solid #000;">
                        <center>
                            <?php echo date('Y-m-d H:i:s'); ?>
                        </center>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    @foreach($transaksi as $item)
    <div class="invoice">
        <!-- SECTION A -->
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="4" align="right"> Kode Transaksi : {{$item->id_trans}}</td>
                </tr>
            </tbody>
        </table>

        <!-- SECTION B -->


        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="4">
                        <h4>Nama Barang</h4>
                    </td>
                </tr>
                <tr>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                </tr>
                @foreach($transaksi_detail as $detail)
                @if($item->id_trans == $detail->id_trans)
                <tr>
                    <th>
                        {{$detail->nama_menu}}
                    </th>
                    <th>{{$detail->qty}}</th>
                    <th>{{number_format($detail->subtotal,2,',','.')}}</th>

                </tr>
                @endif
                @endforeach

                <tr>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="height: 5%;">Total</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">{{number_format($item->total,2,',','.')}}</td>
                </tr>
                @endforeach

                <tr>
                    <td style="height: 5%;">Jumlah Bayar</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">{{$bayar}}</td>
                </tr>
                <tr>
                    <td style="height: 5%;">Kembalian</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">{{$kembalian}}</td>
                </tr>
            </tbody>
        </table>

        <!-- SECTION C -->
    </div>
    <div class="information" style="position: absolute; bottom: 30;">
        <table width="100%">
            <tr>
                <td align="Center" colspan="3">
                    -- Terimakasih --
                </td>
            </tr>
        </table>
    </div>
</body>

</html>