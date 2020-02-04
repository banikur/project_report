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
                        <?php $no = 1;?>
                        <table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
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