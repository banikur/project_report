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
                                foreach ($employee as $item) {
                                    $testing = $item->id_empl;
                                }
                                $rest = (int) substr($testing, -4);
                                $no = 0;
                                if ($rest == 0) {
                                    $no = "EMP-0001";
                                    $autonya = $no;
                                } else if ($rest < 9) {
                                    $no = $rest + 1;

                                    $autonya = "EMP-000$no";

                                } else if ($rest < 99) {
                                    $no = $rest + 1;

                                    $autonya = "EMP-00$no";

                                } else if ($rest < 999) {
                                    $no = $rest + 1;

                                    $autonya = "EMP-0$no";

                                } else if ($rest < 9999) {
                                    $no = $rest + 1;

                                    $autonya = "EMP-$no";

                                } else {
                                    $autonya = "EMP-0001";
                                }

                                
                            ?>
                        <form method="post" class="form-horizontal" action="{{url('/Manager/store_employee')}}"
                            id="employee_form">
                            <div class="col-lg-6">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                                <input class="form-control" readonly="" value="{{$autonya}}" type="hidden"
                                    name="id_empl" id="id_empl" autocomplete="off">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Employee</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" required="" type="text" name="nama_empl" id="nama_empl"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Gender</label>
                                    <div class="col-sm-7">
                                        <div class="radio">
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="Laki-Laki"
                                                    checked>Laki-Laki</label>
                                            <label class="radio-inline"><input type="radio" name="gender"
                                                    value="Perempuan">Perempuan</label>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        No. Telepon</label>
                                    <div class="col-sm-7">
                                        <input class="form-control xxx" required="" type="text" name="telp" id="telp"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Alamat</label>
                                    <div class="col-sm-7">
                                        <textarea name="alamat" required="" class="form-control">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Email</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" required="" type="email" name="email" id="email"
                                            autocomplete="off" placeholder="example@hotmail.com">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Password</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" required="" type="password" name="pass" id="pass"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Position</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" required="" name="position">
                                            <option> -- PILIH -- </option>
                                            <option value="4"> -- MANAGER -- </option>
                                            <option value="2"> -- PURCHASING -- </option>
                                            <option value="3"> -- KOKI -- </option>
                                            <option value="1"> -- CASHIER -- </option>
                                        </select>
                                    </div>
                                </div>

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
                                        Nama Employee
                                    </th>
                                    <th>
                                        Gender
                                    </th>
                                    <th>
                                        No Telepon
                                    </th>
                                    <th>
                                        Alamat
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Position
                                    </th>
                                    <th>
                                        AKSI
                                    </th>
                                </tr>
                            </thead>
                            <?php $no = 1;?>
                            <tbody id="isiTableedit">
                                @foreach($employee as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->nama_empl}}</td>
                                    <td>{{$item->gender}}</td>
                                    <td>{{$item->telp}}</td>
                                    <td>{{$item->alamat}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>
                                    @if($item->position == 1)
                                    CASHIER
                                    @elseif($item->position == 2)
                                    PURCHASING
                                    @elseif($item->position == 3)
                                    KOKI
                                    @else
                                    MANAGER
                                    @endif
                                    </td>
                                    <td>
                                    <center>
                                            <button type="button" data-item="{{$item->id_empl}}" id="edit_barang"
                                                onclick="modal_employee(this)" class="btn btn-primary btn-sm"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Ubah
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

<div class="modal fade bs-example-modal-lg" id="modal_employee" tabindex="-1" role="dialog" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #1aa3ff">
                <h2 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Ubah Barang</h2>
            </div>
            <form id="verif_invoice" class="form-horizontal"  method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Employee ID</label>
                        <div class="col-sm-7">
                            <input class="form-control" readonly="" type="text" name="id_emp_edit" id="id_emp_edit"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Nama Employee</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="nama_emp_edit" id="nama_emp_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Gender</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="gender_edit" id="gender_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            No Telepon</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="telp_edit" id="telp_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Alamat</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="alamat_edit" id="alamat_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Email</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="email_edit" id="email_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Password</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="pass_edit" id="pass_edit" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Position</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="position_edit" id="position_edit"
                                autocomplete="off">
                        </div>
                    </div>


                </div>
                <div class="modal-footer" id="modal_footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
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
        $('#position_edit').val(json[0].position);
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
</script>
@endsection