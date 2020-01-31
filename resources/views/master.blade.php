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
                        <div class="col-lg-5">
                            <form method="post" class="form-horizontal" id="dynamic_form">
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Id Menu</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="id_menu" id="id_menu"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Kategori </label>
                                    <div class="col-sm-7">
                                        <select id="category" onchange="selectmenu()" name="category"
                                            class="form-control" required maxlength="200">
                                            <option selected="" disabled="">-- PILIH --</option>
                                            @foreach($kategori as $z)
                                            <option value="{{$z->id_catMenu}}">{{$z->category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Menu</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="menu" id="menu"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Harga</label>
                                    <div class="col-sm-7">
                                        <input class="form-control money" type="text" name="harga" id="harga">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Qty.</label>
                                    <div class="col-sm-7">
                                        <input class="form-control angka" onkeyup="dikali()" type="text" name="qty"
                                            id="qty" autocomplete="off">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Status</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <div class="col-sm-7">
                                        <label class="checkbox-inline"><input type="checkbox"
                                                name="status">Tersedia</label>
                                        <p style="color:red; font-size: x-small;">*) Harap Checklist Bila Tersedia</p>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- <button type="button" id="addmore" class="btn btn-primary btn-sm pull-right"><i
                                            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Tambah
                                    </button> -->

                                </div>
                            </form>

                        </div>
                        <div class="col-lg-7">
                            <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Nama Menu</center>
                                        </th>
                                        <th>
                                            <center>Harga Menu</center>
                                        </th>
                                        <th>
                                            <center>Status menu</center>
                                        </th>
                                        <th>
                                            <center>Kategori Menu</center>
                                        </th>
                                        <th>
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <?php $no = 1;?>
                                <tbody id="isiTableedit">
                                    @foreach($menu as $z)
                                    <tr>
                                        <td>{{$z->nama_menu}}</td>
                                        <td>{{number_format($z->price,2,',','.')}}</td>
                                        @if($z->status_menu == 1)
                                        <td>Tersedia</td>
                                        @else
                                        <td>Tidak Tersedia</td>
                                        @endif
                                        <td>{{$z->category}}</td>
                                        <td><button data-item="{{$z->id_menu}}" type="button" id="addmore"
                                                class="btn btn-primary btn-sm"><i class="fa fa-pencil"
                                                    aria-hidden="true"></i>&nbsp;&nbsp;Ubah
                                            </button></td>
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
</div>


@endsection
@section('js')
<script>
$(document).ready(function() {
    setMask();
    $('#dt_basic_1').dataTable();
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
    var menu = $('#menu').val();
    var status = $('#status :selected').val();
    var harga = $('#harga').val();
    var id_menu = $('#menu :selected').val();
    var total = $('#total').val();
    if (menu == 'undefined' || harga == 'undefined' || status == 'undefined' || total == 'undefined') {
        menu = '';
        harga = '';
        total = '';
        status = '';
    }
    $('#nodetail').val(no + 1);
    $('#halu').css("display", "none");

    html += '<tr id="isiContentTable' + $('#nodetail').val() + '">';
    html += '<td><center><input type="text" style="display:none;" name="uud_insert[]" value="' +
        id_menu + '">' + menu + '</center></td>';
    html += '<td><center><input type="text" style="display:none;" name="pasal_insert[]" value="' +
        status + '">' + status + '</td>';
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