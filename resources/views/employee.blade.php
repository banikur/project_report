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

                        <form method="post" class="form-horizontal" id="dynamic_form">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        ID Employee</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="id_transaksi" id="id_transaksi"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Employee</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="qty" id="qty" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Gender</label>
                                    <div class="col-sm-7">
                                        <select id="menu" class="form-control" onchange="getdetail()" name="menu">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Telephone</label>
                                    <div class="col-sm-7">
                                        <input class="form-control money" disabled="" type="text" name="harga"
                                            id="harga">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Alamat</label>
                                    <div class="col-sm-7">
                                        <input class="form-control angka" onkeyup="dikali()" type="text" name="qty"
                                            id="qty" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Email</label>
                                    <div class="col-sm-7">
                                        <input class="form-control uang" disabled="" type="text" name="total"
                                            id="total">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Password</label>
                                    <div class="col-sm-7">
                                        <input class="form-control uang" disabled="" type="text" name="total"
                                            id="total">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        ID Akun</label>
                                    <div class="col-sm-7">
                                        <input class="form-control uang" disabled="" type="text" name="total"
                                            id="total">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Position</label>
                                    <div class="col-sm-7">
                                        <input class="form-control angka" onkeyup="dikali()" type="text" name="qty"
                                            id="qty" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="addmore" class="btn btn-primary btn-sm pull-right"><i
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
                                        <center>ID Permintaan Pembelian</center>
                                    </th>
                                    <th>
                                        <center>No. Surat PP</center>
                                    </th>
                                    <th>
                                        <center>Harga Menu</center>
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
                                        <center>ID Barang</center>
                                    </th>
                                    <th>
                                        <center>Qty. PP</center>
                                    </th>
                                    <th>
                                        <center>&nbsp;</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="isiTableedit">
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

function selectmenu() {
    var category = $("#category").val();
    var json = null;
    $.get('{{URL::to("cashier/cek_menu/")}}/' + category, function(data) {
        json = JSON.parse(data);
        console.log(json);
        test =
            "<option class='mst_perusahaan' disabled='' selected='' value='0'>-PILIH-</option>";
        for (let i = 0; i < json.length; i++) {
            test += "<option class='mst_perusahaan' value='" + json[i].id_menu +
                "'>" + json[i].nama_menu + "</option>";
        }
        $('#menu').html(test);
        // $('#menu').val(json.no_meja);
        // for (let index = 0; index < json.length; index++) {
        //     console.log(json);

        // }
    });
    clear();
}

function getdetail() {
    var menu = $("#menu").val();
    var json = null;
    $.get('{{URL::to("cashier/get_detail_menu/")}}/' + menu, function(data) {
        json = JSON.parse(data);
        console.log(json);

        for (let i = 0; i < json.length; i++) {
            var x = json[i].price;
            $('#harga').val(x);
        }
    });
    clear();
}

function clear() {
    $('#qty').val('');
    $('#total').val('');
    $('#harga').val('');

}


function dikali() {
    var harga = parseInt($('#harga').val());
    var qty = parseInt($('#qty').val());
    var total_bayar = harga * qty;
    $('#total').val(total_bayar);
}
$('#addmore').on('click', function() {
    var html = '';
    var no = 0;
    var menu = $('#menu :selected').text();
    var qty = $('#qty').val();
    var harga = $('#harga').val();
    var id_menu = $('#menu :selected').val();
    var total = $('#total').val();
    if (menu == 'undefined' || harga == 'undefined' || qty == 'undefined' || total == 'undefined') {
        menu = '';
        harga = '';
        total = '';
        qty = '';
    }
    $('#nodetail').val(no + 1);
    $('#halu').css("display", "none");

    html += '<tr id="isiContentTable' + $('#nodetail').val() + '">';
    html += '<td><center><input type="text" style="display:none;" name="uud_insert[]" value="' +
        id_menu + '">' + menu + '</center></td>';
    html += '<td><center><input type="text" style="display:none;" name="pasal_insert[]" value="' +
        qty + '">' + qty + '</td>';
    html += '<td><center><input type="text" style="display:none;" name="ayat_insert[]" value="' +
        harga + '">' + harga + '</center></td>';
    html += '<td><center><input type="text" style="display:none;" name="ayat_insert[]" value="' +
        total + '">' + total + '</center></td>';
    html += '<td><center><button type="button" onclick="delete_detail(' + $('#nodetail').val() +
        ')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></center></td>';

    html += '</tr>';
    $('#isiTableedit').append(html);
    clear();
});

function delete_detail(no) {
    var cek = parseInt($('#nodetail').val());
    if (cek != 0) {
        $('#nodetail').val(cek - 1);
    }
    $('#isiContentTable' + no).remove();
    clear();
}
</script>
@endsection