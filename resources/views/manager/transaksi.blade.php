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
                                    <td>{{$item->total}}</td>
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="modal_employee" tabindex="-1" role="dialog" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #1aa3ff">
                <h2 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Ubah Employee</h2>
            </div>
            <form id="verif_invoice" class="form-horizontal" action="{{url('/Manager/update_employee')}}" method="POST">
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

                            <select class="form-control" required="" id="gender_edit" name="gender_edit">
                                <option> -- PILIH -- </option>
                                <option value="Laki-Laki"> Laki-Laki </option>
                                <option value="Perempuan"> Perempuan </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            No Telepon</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" name="telp_edit" id="telp_edit" autocomplete="off">
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
                            <input class="form-control" readonly="" type="text" name="email_edit" id="email_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Password</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="password" name="pass_edit" id="pass_edit"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Position</label>
                        <div class="col-sm-7">

                            <select class="form-control" required="" id="position_edit" name="position_edit">
                                <option> -- PILIH -- </option>
                                <option value="4"> MANAGER </option>
                                <option value="2"> PURCHASING </option>
                                <option value="3"> KOKI </option>
                                <option value="1"> CASHIER </option>
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