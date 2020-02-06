@extends('template.backend.main')
@section('css')
<style>
textarea {
    resize: none;
}
</style>
@endsection
@section('title')
Dashboard E-Report
@endsection
@section('ribbon')
<ol class="breadcrumb">
    <!-- <li>Dashboard</li> -->
    <li class="pull-right"></li>
    <a target="_blank" href="{{url('Manager/print_rekap/')}}" class="btn btn-primary"><i class="fa fa-lg fa-fw fa-print"></i> Print Rekap</a>
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
                                    <th>
                                        No.
                                    </th>
                                    <th>
                                        Tanggal Transaksi
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Status
                                    </th>

                                </tr>
                            </thead>
                            <?php $no = 1;?>
                            <tbody id="isiTableedit">
                                @foreach($employee as $item)
                                <tr>
                                    <td>{{$item->id_trans}}</td>
                                    <td>{{$item->tanggal}}</td>
                                    <td>Rp. {{number_format($item->total,2,',','.')}}</td>
                                    @if(empty($item->id_meja))
                                    <td>Take Away</td>
                                    @else
                                    <td>Meja {{$item->id_meja}}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br/>
                <hr/>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <?php $nos = 1;?>
                        <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
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
    
})

function modal_employee(button) {
    $('#modal_employee').modal('show');
    var id = $(button).data('item');
    //alert(id_supp);
    $.get('{{URL::to("/Manager/get_data_emp/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        $('#id_emp_edit').val(json[0].id_empl);
        $('#nama_emp_edit').val(json[0].nama_empl);
        $('#gender_edit').val(json[0].gender);
        $('#telp_edit').val(json[0].telp);
        $('#alamat_edit').val(json[0].alamat);
        $('#email_edit').val(json[0].email);
        $('#pass_edit').val(json[0].pass);
        $('#position_edit').val(json[0].position).change();
    });
}

function konfirmasi() {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form

    Swal.fire({
        title: 'Apakah Data yang di Masukan Sudah Benar ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            form.submit();
        } else {
            Swal.fire({
                title: "Batal memverifikasi",
                type: "error",
                allowOutsideClick: false,
            })
        }
    })
}

function konfirmasi2() {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form

    Swal.fire({
        title: 'Apakah Data yang di Masukan Sudah Benar ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            form.submit();
        } else {
            Swal.fire({
                title: "Batal memverifikasi",
                type: "error",
                allowOutsideClick: false,
            })
        }
    })

}
</script>
@endsection