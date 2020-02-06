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
                </div>
                <div class="row">
                    <?php
                            $testing_po = null;
                            foreach ($suratterimabarang as $item) {
                                $testing_po = $item->id_po;
                            }
                            $iduser = Auth::user()->id;
                            $rest_po = (int) substr($testing_po, 0, 4);

                            $no_po = 0;
                            $uniq = uniqid();
                            if ($rest_po == 0) {
                                $no_po = "0001";
                                $autonya_po = "$no_po";
                            } else if ($rest_po < 9) {
                                $no_po = $rest_po + 1;

                                $autonya_po = "000$no_po";

                            } else if ($rest_po < 99) {
                                $no_po = $rest_po + 1;

                                $autonya_po = "00$no_po";

                            } else if ($rest_po < 999) {
                                $no_po = $rest_po + 1;

                                $autonya_po = "0$no_po";

                            } else if ($rest_po < 9999) {
                                $no_po = $rest_po + 1;

                                $autonya_po = "$no_po";

                            } else {
                                $autonya_po = "$no_po";
                            }
                            ?>
                    <?php
                            $testing = null;
                            foreach ($suratterimabarang as $item) {
                                $testing = $item->no_stb;
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
                                $autonya = "$no/STB/$bulan/$tahun";
                            } else if ($rest < 9) {
                                $no = $rest + 1;

                                $autonya = "000$no/STB/$bulan/$tahun";

                            } else if ($rest < 99) {
                                $no = $rest + 1;

                                $autonya = "00$no/STB/$bulan/$tahun";

                            } else if ($rest < 999) {
                                $no = $rest + 1;

                                $autonya = "0$no/STB/$bulan/$tahun";

                            } else if ($rest < 9999) {
                                $no = $rest + 1;

                                $autonya = "$no/STB/$bulan/$tahun";

                            } else {
                                $autonya = "$no/STB/$bulan/$tahun";
                            }
                        ?>
                    <form method="post" class="form-horizontal" id="dynamic_form"
                        action="{{url('/Purchasing/store_stb')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                        <div class="col-lg-6">

                            <input class="form-control" type="hidden" name="id_stb" id="id_stb" autocomplete="off"
                                value="{{$autonya_po}}">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No. Surat Terima barang</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" value="{{$autonya}}"
                                        name="no_stb" id="no_stb" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No Purchasing Order</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="no_po" id="no_po">
                                    <input class="form-control" readonly="" type="hidden" name="id_po" id="id_po">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Tanggal STB</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="tgl_stb" name="tgl_stb" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Periode</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="periode_po"
                                        id="periode_po">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Nama Barang</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="hidden" name="id_barang"
                                        id="id_barang">
                                    <input class="form-control" readonly="" type="hidden" name="harga"
                                        id="harga">
                                    <input class="form-control" readonly="" type="text" name="nama_barang"
                                        id="nama_barang">
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
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Qty Purchasing Order</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="qty_po" id="qty_po">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Qty STB</label>
                                <div class="col-sm-7">
                                    <input class="form-control satu_angka" onchange="kalkulasi()" type="text" name="qty_stb" id="qty_stb">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Sub Total</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="text" name="sub_total" id="sub_total">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Bukti STB</label>
                                <div class="col-sm-7">
                                    <input type="file" accept=".pdf" class="form-control" id="bukti_bayar"
                                        name="bukti_bayar">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                </label>
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right"><i
                                            class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br />
                <hr /><br />
                <div class="row">
                    <div class="col-lg-12">
                        <?php $no = 1;?>
                        <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>No. Purchasing Order</th>
                                    <th>Tanggal Order</th>
                                    <th>Periode</th>
                                    <th>Estimasi Arrival</th>
                                    <th>Nama Supplier</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga (satuan)</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="isiTableedit">
                            @foreach($purchasing_order as $item)
                                <tr>
                                    
                                    <td>{{$item->no_purchasing_order}}</td>
                                    <td>{{date("j, F Y", strtotime($item->tanggal_po))}}</td>
                                    <td>{{$item->periode_po}}</td>
                                    <td>{{date("j, F Y", strtotime($item->estimasi_arrival_po))}}</td>
                                    <td>{{$item->nama_supp}}</td>
                                    <td>{{$item->nama_barang}}</td>
                                    <td>{{$item->qty_po}}</td>
                                    <td>{{number_format($item->harga_po,2,',','.')}}</td>
                                    <td>{{number_format($item->sub_total,2,',','.')}}</td>
                                    <td>
                                        <center>
                                            @if($item->status_po == 1)
                                            <p>Sudah Disetujui</p>
                                            @else
                                            <button data-item="{{$item->id_po}}" type="button" onclick="get_data(this)"
                                                class="btn btn-success btn-sm pull-right"><i class="fa fa-check"
                                                    title="Verifikasi"></i>
                                            </button>
                                            @endif
                                        </center>
                                    </td>
                                    
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
    
    flatpickr("#tgl_stb", {
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
    var json = null;
    $.get('{{URL::to("Purchasing/get_po/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        for (let i = 0; i < json.length; i++) {
            $('#no_po').val(json[i].no_purchasing_order);
            $('#id_po').val(json[i].id_po);
            //$('#tgl_stb').val(json[i].tanggal_po);
            $('#periode_po').val(json[i].periode_po);
            $('#id_supp').val(json[i].no_supplier);
            $('#id_barang').val(json[i].id_barang);
            $('#nama_barang').val(json[i].nama_barang);
            $('#nama_supp').val(json[i].nama_supp);
            $('#harga').val(json[i].harga);
            $('#qty_po').val(json[i].qty_po);
            $('#sub_total').val(numberFormat(json[i].sub_total, 2, ',', '.'));

        }
    });
}
function kalkulasi() {
    var qty_stb = $('#qty_stb').val();
    
    var harga =  $('#harga').val();

    var total = harga * qty_stb;
    $('#sub_total').val(numberFormat(total, 2, ',', '.'));
    return qty_stb;
}
</script>
@endsection