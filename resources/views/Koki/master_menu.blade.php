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
                            <form method="post" class="form-horizontal" action="{{url('/Koki/store_menu')}}" id="menu_form">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        ID Menu</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="{{$autonya_menu}}" readonly="" name="id_menu" id="id_menu"
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
                                        <button type="submit" onclick="konfirmasi()" class="btn btn-success btn-sm pull-right"><i
                                                class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Simpan
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
</script>
@endsection