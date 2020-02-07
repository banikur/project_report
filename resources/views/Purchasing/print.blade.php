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
        function tgl_indo($tanggal){
            $bulan = array (
                1 =>   'Januari',
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
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);
            
            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun
         
            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
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
                            <h2>Payment Voucher</h2>
                        </center>
                    </td>
                    <td align="left" style="width: 20%;">
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="3"
                        style="width: inherit; border-bottom:1px solid #000; border-top:1px solid #000;">
                        <center>

                        </center>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    @foreach($paymentvoucher as $item)
    <div class="invoice">
        <!-- SECTION A -->
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="4" align="right"> No. Payment Voucher : {{$item->no_payment_voucher}}</td>
                </tr>
            </tbody>
        </table>
        <!-- SECTION B -->
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="4">
                        <h4>Spesifikasi Barang</h4>
                    </td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td>:</td>
                    <th>{{$item->nama_barang}}</th>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>:</td>
                    <th>{{$item->nama_supp}}</th>
                </tr>
                <tr>
                    <td>harga PO</td>
                    <td>:</td>
                    <th>{{number_format($item->harga_po,2,',','.')}} {{$item->satuan}}</th>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <th>{{number_format($item->qty,2,',','.')}} {{$item->satuan}}</th>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>:</td>
                    <th>Rp. {{number_format($item->sub_total_pv,2,',','.')}}</th>
                </tr>
                <tr>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                    <td style="height: 5%;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p>
                            Sertifikat ini hanya merupakan pernyataan tanda serah terima pembelian barang yang tersebut
                            diatas.
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- SECTION C -->
        <table width="100%">
            <tbody>
                <tr>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 40%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" style="width: 30%;">
                    </td>
                    <td align="left" style="width: 40%;"></td>
                    <td align="left" style="width: 30%;">
                        <p>Purchasing Departement <br />{{tgl_indo(date('Y-m-d',strtotime($item->tanggal_pv)))}}</p>
                    </td>
                </tr>



                <tr>
                    <td align="left" style="width: 30%;">
                    </td>
                    <td align="left" style="width: 30%;">
                        <center>
                           
                            <h2 style="color:rgba(77,142,192,0.5);">ORIGINAL</h2>
                           
                        </center>
                    </td>
                    <td align="left" style="width: 30%;">Petugas</td>
                </tr>
                <tr>
                    <td align="left" style="width: 10%;"></td>
                    <td align="left" style="width: 60%;"></td>

                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
    <div class="information" style="position: absolute; bottom: 30;">
        <table width="100%">
            <tr>
                <td align="Center" colspan="3">
                    Purchasing Departement &copy; {{ date('Y') }} - All rights reserved.
                </td>
            </tr>
        </table>
    </div>
</body>

</html>