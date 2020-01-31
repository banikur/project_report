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
                        <?php
                            $testing_po = null;
                            foreach ($purchasing_order as $item) {
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
                            foreach ($purchasing_order as $item) {
                                $testing = $item->no_purchasing_order;
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
                                $autonya = "$no/REQPO/$bulan/$tahun";
                            } else if ($rest < 9) {
                                $no = $rest + 1;

                                $autonya = "000$no/REQPO/$bulan/$tahun";

                            } else if ($rest < 99) {
                                $no = $rest + 1;

                                $autonya = "00$no/REQPO/$bulan/$tahun";

                            } else if ($rest < 999) {
                                $no = $rest + 1;

                                $autonya = "0$no/REQPO/$bulan/$tahun";

                            } else if ($rest < 9999) {
                                $no = $rest + 1;

                                $autonya = "$no/REQPO/$bulan/$tahun";

                            } else {
                                $autonya = "$no/REQPO/$bulan/$tahun";
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <form method="post" class="form-horizontal" action="{{url('/Purchasing/store_koki')}}"
                        id="dynamic_form">
                        {{csrf_field()}}

                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="col-sm-7">
                                    <input class="form-control" value="{{$autonya_po}}" readonly="" type="hidden"
                                        name="id_po" id="id_po" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No. Surat Purchasing Order</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" value="{{$autonya}}" type="text"
                                        name="no_purchasing" id="no_purchasing" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No. Permintaan Pembelian</label>
                                <div class="col-sm-7">
                                    <input class="form-control" readonly="" type="hidden" name="id_pp" id="id_pp"
                                        autocomplete="off">
                                    <input class="form-control" value="" readonly="" type="text" name="no_pp" id="no_pp"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Tanggal PO</label>
                                <div class="col-sm-7">
                                    <input class="form-control" value="" readonly="" type="text" name="tgl_po"
                                        id="tgl_po" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Periode</label>
                                <div class="col-sm-7">
                                    <input class="form-control" value="" readonly="" type="text" name="periode"
                                        id="periode" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Estimasi Arrival (eta)</label>
                                <div class="col-sm-7">
                                    <input class="form-control" value="" readonly="" type="text" name="tgl_eta"
                                        id="tgl_eta" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    No. Supplier</label>
                                <div class="col-sm-7">
                                    <select id="supplier_edit" class="form-control" name="supplier_edit">
                                        <option value="0" selected="" disabled="">-- PILIH --</option>
                                        @foreach($supplier as $sup)
                                        <option value="{{$sup->id_supp}}">{{$sup->nama_supp}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-6">
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
                                    Qty </label>
                                <div class="col-sm-7">
                                    <input class="form-control" value="" readonly="" type="text" name="qty" id="qty"
                                        autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Harga</label>
                                <label class="col-sm-1 control-label">Rp. </label>
                                <div class="col-sm-6">
                                    <input style="text-align:right;" class="form-control" value="" readonly=""
                                        type="text" name="harga" id="harga" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    Subtotal</label>
                                <label class="col-sm-1 control-label">Rp. </label>
                                <div class="col-sm-6">
                                    <input style="text-align:right;" class="form-control" value="" readonly=""
                                        type="text" name="sub_total" id="sub_total" autocomplete="off">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i
                                            class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Simpan</div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br />
                <hr />
                <div class="row">
                <?php $no = 1;?>

                    <div class="col-lg-12 ">
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
                                    <th>
                                        <center>Aksi</center>
                                    </th>

                                </tr>
                            </thead>
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
                                    <td>
                                        <center>
                                            @if($item->status == 1)
                                            <p>Sudah Disetujui</p>
                                            @else
                                            <button data-item="{{$item->id_pp}}" type="button" onclick="get_data(this)"
                                                class="btn btn-success btn-sm pull-right"><i class="fa fa-check"
                                                    title="Verifikasi"></i>
                                            </button>
                                            @endif
                                        </center>
                                    </td>
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

    $("#dt_basic_1").dataTable();
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
    $.get('{{URL::to("Purchasing/get_pp/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        for (let i = 0; i < json.length; i++) {

            $('#no_pp').val(json[i].no_permintaan_pembelian);
            flatpickr("#tgl_po", {
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
                allowInput: false,
                clickOpens: false,
                defaultDate: json[i].tanggal_pp,
            });
            flatpickr("#tgl_eta", {
                altInput: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
                allowInput: false,
                clickOpens: false,
                defaultDate: json[i].estimasi_arrival,
            });
            $('#periode').val(json[i].periode);
            $('#nama_barang').val(json[i].nama_barang);
            $('#qty ').val(json[i].qty_pp);
            $('#id_barang').val(json[i].id_barang);
            $('#id_pp').val(json[i].id_pp);
            $('#harga').val(numberFormat(json[i].harga, 2, ',', '.'));
            var total = json[i].qty_pp * json[i].harga;
            $('#sub_total').val(numberFormat(total, 2, ',', '.'));
        }
    });

}
</script>
@endsection