@extends('template.backend.main')
@section('title')
Dashboard E-Report
@endsection
@section('ribbon')
<ol class="breadcrumb">
    <!-- <li>Dashboard</li> -->
    <li class="pull-right"><?php echo date('j F, Y'); ?></li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        @if($errors->any())
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-warning fade in">
                                    <button class="close" data-dismiss="alert">
                                        ×
                                    </button>
                                    <i class="fa-fw fa fa-warning"></i>
                                    <strong>Peringatan</strong> {{$errors->first()}}
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(session()->has('message'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                        ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Sukses</strong> {{session()->get('message')}}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <?php
                            $testing = null;
                            foreach ($paymentvoucher as $item) {
                                $testing = $item->no_payment_voucher;
                            }
                            $iduser = Auth::user()->id;
                            $rest = (int) substr($testing, 0, 4);
                            $tanggalskr = date('Y-m-d H:i:s');
                            $date = date_format(date_create($tanggalskr), 'Y/m/d');
                            $bulan = date('m');
                            $tahun = date('Y');
                            $no = 0;
                            $uniq = uniqid();
                            if ($rest == 0) {
                                $no = "0001";
                                $autonya = "$no/PV/$bulan/$tahun";
                            } else if ($rest < 9) {
                                $no = $rest + 1;

                                $autonya = "000$no/PV/$bulan/$tahun";

                            } else if ($rest < 99) {
                                $no = $rest + 1;

                                $autonya = "00$no/PV/$bulan/$tahun";

                            } else if ($rest < 999) {
                                $no = $rest + 1;

                                $autonya = "0$no/PV/$bulan/$tahun";

                            } else if ($rest < 9999) {
                                $no = $rest + 1;

                                $autonya = "$no/PV/$bulan/$tahun";

                            } else {
                                $autonya = "$no/PV/$bulan/$tahun";
                            }

                            $testing_pv = null;
                             foreach ($paymentvoucher as $item) {
                                 $testing_pv = $item->id_pv;
                             }
                             $iduser = Auth::user()->id;
                             $rest_pv = (int) substr($testing_pv, 0,4);
                             
                             $no_pp = 0;
                             $uniq = uniqid();
                             if ($rest_pv == 0) {
                                 $no_pp = "0001";
                                 $autonya_pv = "$no_pp";
                             } else if ($rest_pv < 9) {
                                 $no_pp = $rest_pv + 1;
                         
                                 $autonya_pv = "000$no_pp";
                         
                             } else if ($rest_pv < 99) {
                                 $no_pp = $rest_pv + 1;
                         
                                 $autonya_pv = "00$no_pp";
                         
                             } else if ($rest_pv < 999) {
                                 $no_pp = $rest_pv + 1;
                         
                                 $autonya_pv = "0$no_pp";
                         
                             } else if ($rest_pv < 9999) {
                                 $no_pp = $rest_pv + 1;
                         
                                 $autonya_pv = "$no_pp";
                         
                             } else {
                                $autonya_pv = "$no_pp";
                            }
                        ?>
                    <form method="post" action="{{url('/Purchasing/store_pv')}}" class="form-horizontal" id="dynamic_form">
                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <input class="form-control" type="hidden" value="{{$autonya_pv}}" name="id_pv" id="id_pv"
                                autocomplete="off">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No. Surat Payment Voucher</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" value="{{$autonya}}"
                                        name="no_pv" id="no_pv" autocomplete="off">
                                        <input class="form-control" type="hidden" name="no_po" id="no_po"
                                autocomplete="off">

                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Tanggal PV</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="tgl_pv" name="tgl_pv">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Periode</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="periode" id="periode">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Nama Barang</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="hidden" name="id_barang"
                                        id="id_barang" autocomplete="off">
                                    <input class="form-control" value="" readonly="" type="text" name="nama_barang"
                                        id="nama_barang" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Qty</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="qty_stb" id="qty_stb">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Sub Total</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="sub_total" id="sub_total">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Nama Supplier</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="hidden" name="id_supp" id="id_supp">
                                    <input class="form-control" readonly="" type="text" name="nama_supp" id="nama_supp">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Jenis Pembayaran</label>
                                <div class="col-sm-7">
                                    <div class="radio">
                                        <label class="radio-inline">
                                            <input type="radio" name="jenis_pembayaran" value="Cash" checked>Cash</label>
                                        <label class="radio-inline"><input type="radio" name="jenis_pembayaran"
                                                value="Giro">Giro</label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i
                                            class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="col-lg-12">
                        <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <!-- <th>
                                        <center>No Surat Terima Barang</center>
                                    </th> -->
                                    <th>
                                        <center>Qty STB</center>
                                    </th>
                                    <th>
                                        <center>Sub total</center>
                                    </th>
                                    <th>
                                        <center>Qty Purchasing Order</center>
                                    </th>
                                    
                                    <th>
                                        <center>No Purchasing Order</center>
                                    </th>
                                    <th>
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <?php $no = 1; ?>
                            <tbody id="isiTableedit">
                                @foreach($stb as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    
                                    <td>{{number_format($item->qty,2,',','.')}}</td>
                                    <td>Rp. {{number_format($item->sub_total,2,',','.')}}</td>
                                    @foreach($purchasing_order as $po)
                                    @if ($item->id_purchasing == $po->id_po)
                                    <td>{{number_format($po->qty_po,2,',','.')}}</td>
                                    <td>{{$po->no_purchasing_order}}</td>
                                    <td>
                                        <center>
                                            @if($item->status_stb == 1)
                                            <p>Sudah Disetujui</p>
                                            @else
                                            <button data-item="{{base64_encode($po->no_purchasing_order)}}" data-subtotal="{{$item->sub_total}}" data-qty="{{$item->qty}}" type="button" onclick="get_data(this)"
                                                class="btn btn-success btn-sm pull-right"><i class="fa fa-check"
                                                    title="Verifikasi"></i>
                                            </button>
                                            @endif
                                        </center>
                                    </td>
                                    @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>
$(document).ready(function() {
    setMask();
    $('#dt_basic_1').dataTable();
    flatpickr("#tgl_pv", {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        minDate: "today",
    });
})
const numberFormat = (value, decimals, decPoint, thousandsSep) => {
    decPoint = decPoint || '.';
    decimals = decimals !== undefined ? decimals : 2;
    thousandsSep = thousandsSep || ' ';

    if (typeof value === 'string') {
        value = parseFloat(value);
    }

    let result = value.toLocaleString('en-US', {
        maximumFractionDigits: decimals,
        minimumFractionDigits: decimals
    });

    let pieces = result.split('.');
    pieces[0] = pieces[0].split(',').join(thousandsSep);

    return pieces.join(decPoint);
};

function get_data(button) {
    var id = $(button).data('item');
    var qty = $(button).data('qty');
    var  subtotal = $(button).data('subtotal');

    var json = null;
    $.get('{{URL::to("Purchasing/get_stb/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        for (let i = 0; i < json.length; i++) {

            $('#no_po').val(json[i].no_purchasing_order);
            $('#periode').val(json[i].periode_stb);
            $('#nama_barang').val(json[i].nama_barang);
            $('#qty_stb ').val(qty);
            $('#id_barang').val(json[i].id_barang);
            $('#id_po').val(json[i].id_po);
            $('#id_stb').val(json[i].id_stb);
            $('#id_supp').val(json[i].no_supplier);
            $('#nama_supp').val(json[i].nama_supp);
            $('#sub_total').val(numberFormat(subtotal, 2, ',', '.'));
        }
    });

}
</script>
@endsection