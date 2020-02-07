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
                                $testing = null;
                                foreach ($master_barang as $item) {
                                    $testing = $item->id_barang;
                                }
                                $iduser = Auth::user()->id;
                                $rest = (int) substr($testing, -4);
                                $tanggalskr = date('Y-m-d H:i:s');
                                $date = date_format(date_create($tanggalskr), 'Y/m/d');
                                $no = 0;
                                if ($rest == 0) {
                                    $no = "BR-0001";
                                    $autonya = $no;
                                } else if ($rest < 9) {
                                    $no = $rest + 1;

                                    $autonya = "BR-000$no";

                                } else if ($rest < 99) {
                                    $no = $rest + 1;

                                    $autonya = "BR-00$no";

                                } else if ($rest < 999) {
                                    $no = $rest + 1;

                                    $autonya = "BR-0$no";

                                } else if ($rest < 9999) {
                                    $no = $rest + 1;

                                    $autonya = "BR-$no";

                                } else {
                                    $autonya = "BR-0001";
                                }

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
                        <form method="post" class="form-horizontal" action="{{url('/Purchasing/store_barang')}}"
                            id="barang_form">
                            <div class="col-lg-6">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        ID Barang</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" readonly="" value="{{$autonya}}" type="text"
                                            name="id_barang" id="id_barang" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Barang</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" name="nama_barang" id="nama_barang"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Stok</label>
                                    <div class="col-sm-4">
                                        <input class="form-control numeric" type="text" name="stok" id="stok">
                                    </div>
                                    <div class="col-sm-3">
                                        <select id="satuan" class="form-control" name="satuan">
                                            <option value="0" selected="" disabled="">-- PILIH --</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Lt">Lt</option>
                                            <option value="pcs">Pcs</option>
                                            <option value="buah">Buah</option>
                                        </select>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Supplier</label>
                                    <div class="col-sm-7">
                                        <select id="supplier" class="form-control" name="supplier">
                                            <option value="0" selected="" disabled="">-- PILIH --</option>

                                            @foreach($supplier as $sup)
                                            <option value="{{$sup->id_supp}}">{{$sup->nama_supp}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                    </label>
                                    <div class="col-sm-7">
                                        <button type="submit" onclick="konfirmasi()"
                                            class="btn btn-success btn-sm pull-right"><i class="fa fa-check"
                                                aria-hidden="true"></i>&nbsp;&nbsp;Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-6">
                            <!-- <button type="button" id="add_supp" onclick="modal_supp()"
                                class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"
                                    aria-hidden="true"></i>&nbsp;&nbsp;Tambah Supplier
                            </button> -->
                        </div>
                    </div>
                </div>
                <hr />
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <?php $no = 1;?>
                        <table id="dt_basic_1" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        No.
                                    </th>
                                    <th>
                                        Nama Barang
                                    </th>
                                    
                                    <th>
                                        Stok / Satuan
                                    </th>
                                    <th>
                                        AKSI
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="isiTableedit">
                                @foreach($master_barang as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->nama_barang}}</td>
                                    <td>{{$item->stok}} / {{$item->satuan}}</td>
                                    <td>
                                        <center>
                                            <button type="button" data-item="{{$item->id_barang}}" id="edit_barang"
                                                onclick="modal_barang(this)" class="btn btn-primary btn-sm"><i
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

<div class="modal fade bs-example-modal-lg" id="modal_barang" tabindex="-1" role="dialog" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #1aa3ff">
                <h2 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Ubah Barang</h2>
            </div>
            <form id="verif_invoice" class="form-horizontal" action="{{url('/Purchasing/update_barang')}}" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}

                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            ID Barang</label>
                        <div class="col-sm-7">
                            <input class="form-control" readonly="" type="text" name="id_barang_edit"
                                id="id_barang_edit" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Nama Barang</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="nama_barang_edit" id="nama_barang_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Stok</label>
                        <div class="col-sm-4">
                            <input class="form-control numeric" readonly="" type="text" name="stok_edit" id="stok_edit">
                        </div>
                        <div class="col-sm-3">
                            <select id="satuan_edit" readonly="" class="form-control" name="satuan_edit">
                                <option value="0" selected="" disabled="">-- PILIH --</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Lt">Lt</option>
                                            <option value="pcs">Pcs</option>
                                            <option value="buah">Buah</option>
                            </select>
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

function modal_barang(button) {
    $('#modal_barang').modal('show');
    var id = $(button).data('item');
    //alert(id_supp);
    $.get('{{URL::to("/Purchasing/get_detail_barang/")}}/' + id, function(data) {
        json = JSON.parse(data);
        console.log(json);
        $('#id_barang_edit').val(json[0].id_barang);
        $('#nama_barang_edit').val(json[0].nama_barang);
        $("#satuan_edit").val(json[0].satuan).change();
        $('#stok_edit').val(numberFormat(json[0].stok,2,',','.'));
        //$('#alamat_edit').val(json[0].nama_supp);
        $("#supplier_edit").val(json[0].id_supp).change();

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