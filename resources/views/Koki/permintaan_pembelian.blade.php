@extends('template.backend.main')
@section('css')
<style>
textarea {
    resize: none;
}
</style>
@endsection
@section('title')
Dashboard Purchasing
@endsection
@section('ribbon')
<ol class="breadcrumb">
    <!-- <li>Dashboard</li> -->
    <li class="pull-right"><?php echo $date = date('j F, Y'); ?></li>
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
                        <?php 
                             $testing_pp = null;
                             foreach ($permintaan_pembelian as $item) {
                                 $testing_pp = $item->id_pp;
                             }
                             $iduser = Auth::user()->id;
                             $rest_pp = (int) substr($testing_pp, 0,4);
                             
                             $no_pp = 0;
                             $uniq = uniqid();
                             if ($rest_pp == 0) {
                                 $no_pp = "0001";
                                 $autonya_pp = "$no_pp";
                             } else if ($rest_pp < 9) {
                                 $no_pp = $rest_pp + 1;
                         
                                 $autonya_pp = "000$no_pp";
                         
                             } else if ($rest_pp < 99) {
                                 $no_pp = $rest_pp + 1;
                         
                                 $autonya_pp = "00$no_pp";
                         
                             } else if ($rest_pp < 999) {
                                 $no_pp = $rest_pp + 1;
                         
                                 $autonya_pp = "0$no_pp";
                         
                             } else if ($rest_pp < 9999) {
                                 $no_pp = $rest_pp + 1;
                         
                                 $autonya_pp = "$no_pp";
                         
                             } else {
                                $autonya_pp = "$no_pp";
                            }
                        ?>
                        <?php 
                             $testing = null;
                             foreach ($permintaan_pembelian as $item) {
                                 $testing = $item->no_permintaan_pembelian;
                             }
                             $iduser = Auth::user()->id;
                             $rest = (int) substr($testing, 0,4);
                             $tanggalskr = date('Y-m-d H:i:s');
                             $date = date_format(date_create($tanggalskr), 'Y/m/d');
                             $bulan = date('m');
                             $tahun = date('Y');
                             $no = 0;
                             $uniq = uniqid();
                             if ($rest == 0) {
                                 $no = "0001";
                                 $autonya = "$no/REQKK/$bulan/$tahun";
                             } else if ($rest < 9) {
                                 $no = $rest + 1;
                         
                                 $autonya = "000$no/REQKK/$bulan/$tahun";
                         
                             } else if ($rest < 99) {
                                 $no = $rest + 1;
                         
                                 $autonya = "00$no/REQKK/$bulan/$tahun";
                         
                             } else if ($rest < 999) {
                                 $no = $rest + 1;
                         
                                 $autonya = "0$no/REQKK/$bulan/$tahun";
                         
                             } else if ($rest < 9999) {
                                 $no = $rest + 1;
                         
                                 $autonya = "$no/REQKK/$bulan/$tahun";
                         
                             } else {
                                $autonya = "$no/REQKK/$bulan/$tahun";
                            }
                        ?>
                        <form method="POST" action="{{url('/Koki/insert_pembelian')}}" class="form-horizontal" id="PermintaanPembelian_form">
                        {{csrf_field()}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <!-- <label class="col-sm-4 control-label">
                                        ID Permintaan Pembelian</label> -->
                                    <div class="col-sm-7">
                                        <input class="form-control" value="{{$autonya_pp}}" readonly="" type="hidden"
                                            name="id_pp" id="id_pp" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        No. Surat Permintaan Pembelian</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" readonly="" value="{{$autonya}}" type="text"
                                            name="no_pp" id="no_pp" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Tanggal PP</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="tgl_pp" name="tgl_pp">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Periode</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="periode" id="periode">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Estimasi Arrival (eta)</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="tgl_eta" name="tgl_eta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Barang</label>
                                    <div class="col-sm-7">
                                        <select class="form-control js-example-basic-single" id="id_barang" name="id_barang" onchange="get_detail_barang()" name="menu" id="menu" required>
                                            <option value="" style="display: none;"></option>
                                            @foreach($master_barang as $val)
                                            <option value="{{$val->id_barang}}" )>{{$val->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Ket. Barang</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" id="ket_barang" name="ket_barang"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Qty. PP</label>
                                    <div class="col-sm-7">
                                        <input class="form-control satu_angka" type="text" name="jumlah_pp" id="jumlah_pp"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="addmore" class="btn btn-primary btn-sm pull-right"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Tambah
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <br /><br /><br /><br />
                <div class="row">
                    <div class="col-lg-12">
                        <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>No. Surat PP</center>
                                    </th>
                                    
                                    <th>
                                        <center>Tangal PP</center>
                                    </th>
                                    <th>
                                        <center>Periode</center>
                                    </th>
                                    <th>
                                        <center>Eta</center>
                                    </th>
                                    <th>
                                        <center>Nama Barang</center>
                                    </th>
                                    <th>
                                        <center>Qty. PP</center>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <?php $no = 1; ?>
                            <tbody id="isiTableedit">
                            @foreach($permintaan_pembelian as $item)
                            @if(substr($item->no_permintaan_pembelian, 5, 5) == 'REQKK')

                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->no_permintaan_pembelian}}</td>
                                    <td>{{date("j, F Y", strtotime($item->tanggal_pp))}}</td>
                                    <td>{{$item->periode}}</td>
                                    <td>{{date("j, F Y", strtotime($item->estimasi_arrival))}}</td>
                                    <td>{{$item->nama_barang}}</td>
                                    <td>{{$item->qty_pp}}</td>
                                    
                                </tr>
                                @endif
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
    flatpickr("#periode", {
        altInput: true,
        altFormat: "Y",
        dateFormat: "Y",
    });
    flatpickr("#tgl_pp", {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        minDate: "today",
    });
    flatpickr("#tgl_eta", {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        minDate: "today",
    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    $('#dt_basic_1').dataTable();
})

function get_detail_barang() {
    var id_barang = $("#id_barang").val();
    var json = null;
    $.get('{{URL::to("Koki/get_detail_barang/")}}/' + id_barang, function(data) {
        json = JSON.parse(data);
        console.log(json);
        
        for (let i = 0; i < json.length; i++) {
            var x = json[i].nama_supp;
            var y = json[i].alamat;
            var z = json[i].no_telp;
            var html ="Nama Supplier :" + x + "\n"+"No. Telp Supplier :" +  z;
            $('#ket_barang').val(html);
        }
    });
    
}
</script>
@endsection