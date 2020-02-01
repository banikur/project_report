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
    $testing_supp = null;
    foreach ($supplier as $item) {
        $testing_supp = $item->id_supp;
    }
    $iduser = Auth::user()->id;
    $id_sup = (int) substr($testing_supp, -4);
    $no_sup = 0;
    if ($id_sup == 0) {
        $no_sup = "SP-0001";
        $autonya_supp = $no_sup;
    } else if ($id_sup < 9) {
        $no_sup = $id_sup + 1;

        $autonya_supp = "SP-000$no_sup";

    } else if ($id_sup < 99) {
        $no_sup = $id_sup + 1;

        $autonya_supp = "SP-00$no_sup";

    } else if ($id_sup < 999) {
        $no_sup = $id_sup + 1;

        $autonya_supp = "SP-0$no_sup";

    } else if ($id_sup < 9999) {
        $no_sup = $id_sup + 1;

        $autonya_supp = "SP-$no_sup";

    } else {
        $autonya_supp = "SP-0001";
    }
?>
                        <div class="col-lg-5">
                            <form method="POST" class="form-horizontal" action="{{url('/Purchasing/store_supp')}}"
                                id="supplier_form">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        ID Supplier</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" readonly="" value="{{$autonya_supp}}" type="text"
                                            name="id_supp" id="id_supp" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Suplier</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="nama_supp" id="nama_supp"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        No Telp</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="no_telp" id="no_telp"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea id="alamat" name="alamat_supp" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br />
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
                                            <center>ID Supplier</center>
                                        </th>
                                        <th>
                                            <center>Nama Supplier</center>
                                        </th>
                                        <th>
                                            <center>Alamat</center>
                                        </th>
                                        <th>
                                            <center>No. Telp</center>
                                        </th>
                                        <th>
                                            <center>&nbsp;</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="isiTableedit">
                                    @foreach($supplier as $item)
                                    <tr>
                                        <td>
                                            {{$item->id_supp}}
                                        </td>
                                        <td>
                                            {{$item->nama_supp}}
                                        </td>
                                        <td>
                                            {{$item->alamat}}
                                        </td>
                                        <td>
                                            {{$item->no_telp}}
                                        </td>
                                        <td>
                                            <button type="button" data-item="{{$item->id_supp}}" id="edit_supp" onclick="modal_supp(this)"
                                                class="btn btn-primary btn-sm pull-right"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                            </button>
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
<div class="modal fade bs-example-modal-lg" id="modal_invoice" tabindex="-1" role="dialog" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #1aa3ff">
                <h2 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Tambah Supplier</h2>
            </div>
            <form id="verif_invoice" action="{{url('/Purchasing/update_supp')}}" class="form-horizontal" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ID Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" readonly=""
                                style="text-align:center;" autocomplete="false" name="id_supp_edit" id="id_supp_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" style="text-align:center;" autocomplete="false"
                                name="nama_supp_edit" id="nama_supp_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">No. Telp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" style="text-align:center;" autocomplete="false"
                                name="no_telp_edit" id="no_telp_edit">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea id="alamat_edit" name="alamat_edit" class="form-control"></textarea>
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
})

function modal_supp(button) {
    $('#modal_invoice').modal('show');
    var id_supp = $(button).data('item');
    //alert(id_supp);
    $.get('{{URL::to("/Purchasing/get_supp/")}}/' + id_supp, function(data) {
        json = JSON.parse(data);
        console.log(json);
        $('#id_supp_edit').val(json[0].id_supp);
        $('#nama_supp_edit').val(json[0].nama_supp);
        $('#no_telp_edit').val(json[0].no_telp);
        $('#alamat_edit').val(json[0].alamat);

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