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
                        @if(!empty($tanggal_start))
                        <center>
                            <h2>Rekap {{tgl_indo(date('Y-m-d',strtotime($tanggal_start)))}} S/d
                                {{tgl_indo(date('Y-m-d',strtotime($tanggal_end)))}}</h2>
                        </center>
                        @else
                        <center>
                            <h2>Rekap {{date('F Y')}}</h2>
                        </center>
                        @endif
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
    <div class="invoice">
        <!-- SECTION A -->
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="4" align="right"> Rekap Per Tanggal {{date('j F, Y')}}</td>
                </tr>
            </tbody>
        </table>
        <!-- SECTION B -->
        <table width="100%">
            <tbody>
                <tr>
                    <th>No Purchasing Order</th>
                    <th>Nama Supplier</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Sub Total</th>
                </tr>
                @foreach($purchasing_order as $item)
                <tr>
                    <td>{{$item->no_purchasing_order}}</td>
                    <td>{{$item->nama_supp}}</td>
                    <td>{{$item->nama_barang}}</td>
                    <td>{{number_format($item->harga_po,2,',','.')}}</td>
                    <td>{{number_format($item->sub_total,2,',','.')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 40%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
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
        <table width="100%">
            <tbody>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                @foreach($transaksi as $items)
                <tr>
                    <td>{{$items->id_trans}}</td>
                    <td>{{$items->tanggal}}</td>
                    <td>Rp. {{number_format($items->total,2,',','.')}}</td>
                    @if(empty($items->id_meja))
                    <td>Take Away</td>
                    @else
                    <td>Meja {{$items->id_meja}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 40%; height: 2%;">&nbsp;</td>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
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
        <table width="100%">
            <tbody>
                <?php $hasil =$totalpo -  $total_transaksi?>
                <tr>
                    <td align="left" colspan="2" style="width: 30%; height: 2%;">Jumlah Pengeluaran:
                        {{number_format($totalpo,2,',','.')}} - {{number_format($total_transaksi,2,',','.')}} = Rp.
                        {{number_format($hasil,2,',','.')}}</td>
                    <td align="left" style="width: 30%; height: 2%;">&nbsp;</td>
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
                        <p>Purchasing Departement <br />{{date('j F, Y')}}</p>
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