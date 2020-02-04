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
                                
                                @if(substr($item->no_permintaan_pembelian, 5, 5) == 'REQPP')
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