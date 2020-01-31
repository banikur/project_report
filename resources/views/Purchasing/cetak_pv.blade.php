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

                    <div class="col-lg-12">
                        <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>No Purchasing Voucher</center>
                                    </th>
                                    <th>
                                        <center>Total Qty</center>
                                    </th>
                                    <th>
                                        <center>Periode</center>
                                    </th>
                                    <th>
                                        <center>Nama Barang</center>
                                    </th>
                                    <th>
                                        <center>Nama Suplier</center>
                                    </th>
                                    <th>
                                        <center>Jenis Pembayaran</center>
                                    </th>
                                    <th>
                                        <center>Sub total</center>
                                    </th>
                                    <th>
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <?php $no = 1; ?>
                            <tbody id="isiTableedit">
                                @foreach($paymentvoucher as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->no_payment_voucher}}</td>
                                    <td>{{number_format($item->qty,2,',','.')}}</td>
                                    <td>{{$item->periode_pv}}</td>
                                    <td>{{$item->nama_barang}}</td>
                                    <td>{{$item->nama_supp}}</td>
                                    <td>{{$item->jenis_pembayaran}}</td>
                                    <td>Rp. {{number_format($item->sub_total_pv,2,',','.')}}</td>
                                    <td>
                                        <center>
                                            @if(!empty($item->no_purchasing_order))
                                            <a target="_blank" href="print_pv/{{$item->id_pv}}"
                                                class="btn btn-success btn-sm pull-right"><i class="fa fa-print"
                                                    title="Cetak"></i>
                                            </a>
                                            @else
                                           
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
    var json = null;
    $.get('{{URL::to("Purchasing/get_stb/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        
    });

}
</script>
@endsection