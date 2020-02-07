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
    $menu_awal = null;
    foreach ($menu as $item) {
        $menu_awal = $item->id_menu;
    }
    $id_menu = (int) substr($menu_awal, -4);
    $no_menu = 0;
    if ($id_menu == 0) {
        $no_menu = "MN-0001";
        $autonya_menu = $no_menu;
    } else if ($id_menu < 9) {
        $no_menu = $id_menu + 1;

        $autonya_menu = "MN-000$no_menu";

    } else if ($id_menu < 99) {
        $no_menu = $id_menu + 1;

        $autonya_menu = "MN-00$no_menu";

    } else if ($id_menu < 999) {
        $no_menu = $id_menu + 1;

        $autonya_menu = "MN-0$no_menu";

    } else if ($id_menu < 9999) {
        $no_menu = $id_menu + 1;

        $autonya_menu = "MN-$no_menu";

    } else {
        $autonya_menu = "MN-0001";
    }
?>
                        <div class="col-lg-5">
                            <form method="post" class="form-horizontal" action="{{url('/Koki/store_menu')}}"
                                id="menu_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        ID Menu</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="{{$autonya_menu}}" readonly=""
                                            name="id_menu" id="id_menu" autocomplete="off">
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
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Gambar</label>
                                    <div class="col-sm-7">
                                        <input type="file" accept=".jpg" class="form-control" id="gambar" name="gambar">
                                    </div>
                                </div>
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
                                    <label class="col-sm-4 control-label"></label>
                                    <div class="col-sm-7">
                                        <button type="submit" onclick="konfirmasi()"
                                            class="btn btn-success btn-sm pull-right"><i class="fa fa-check"
                                                aria-hidden="true"></i>&nbsp;&nbsp;Simpan
                                        </button>
                                    </div>
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
                                            AKSI
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
                                        <td>
                                            <center>
                                                <button type="button" data-item="{{$z->id_menu}}" id="edit_menu"
                                                    onclick="modal_menu(this)" class="btn btn-primary btn-sm"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>&nbsp;
                                                </button>
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
</div>

<div class="modal fade bs-example-modal-lg" id="modal_menu" tabindex="-1" role="dialog" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #1aa3ff">
                <h2 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Ubah Status Menu</h2>
            </div>
            <form id="verif_invoice" enctype="multipart/form-data" class="form-horizontal" action="{{url('/Koki/update_menu')}}" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Menu</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" readonly="" autocomplete="false"
                                name="nama_menu_edit" id="nama_menu_edit">
                            <input type="hidden" class="form-control" required="" autocomplete="false"
                                name="id_menu_edit" id="id_menu_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-9">
                            <input class="form-control cashier" type="text" name="harga_edit" autocomplete="false"
                                id="harga_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-7">
                            <label class="checkbox-inline"><input type="checkbox" name="status_edit">Tersedia</label>
                            <p style="color:red; font-size: x-small;">*) Harap Checklist Bila Tersedia</p>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Gambar</label>
                        <div class="col-sm-4">
                            <input type="file" accept=".jpg" class="form-control" id="gambar_edit" name="gambar_edit">
                        </div>
                        <div class="col-sm-5">
                        <img id="gambar_database" style='max-width: 100%;' />
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal_footer">
                    <button type="button" onclick="return konfirmasi2()" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                </div>
            </form>
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

function modal_menu(button) {
    $('#modal_menu').modal('show');
    var id = $(button).data('item');
    //alert(id_supp);
    $.get('{{URL::to("/Koki/get_detail_menu/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        $('#id_menu_edit').val(json[0].id_menu);
        $('#nama_menu_edit').val(json[0].nama_menu);
        $('#harga_edit').val(json[0].price);
        $('#status_edit').val(json[0].status_menu);
        $('#gambar_database').attr("src","../image_menu/"+json[0].url_pict)
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