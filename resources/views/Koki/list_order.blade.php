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

                    </div>
                </div>
                <div class="row">
                    @foreach($transaksi as $item)
                    <form method="post" class="form-horizontal" action="{{url('/Koki/update_status')}}" id="menu_form">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                        <div class="col-lg-3">
                            <div class="well">
                                <p>ID TRANSAKSI : {{$item->id_trans}}</p>
                                @if(!empty($item->id_meja))
                                No Meja : {{$item->id_meja}}
                                @else
                                Take Away
                                @endif
                                <hr/>
                                <input type="hidden" name="id_transaksi" value="{{$item->id_trans}}" />
                                <ul>
                                    @foreach($transaksi_detail as $detail)
                                    @if($item->id_trans == $detail->id_trans)
                                    <li>{{$detail->nama_menu}} ({{$detail->qty}})</li>
                                    @endif
                                    @endforeach
                                </ul>
                                <button type="button" onclick="konfirmasi()" data-item="{{$item->id_trans}}"
                                    class="btn btn-primary btn-lg btn-block">
                                    Selesai
                                </button>

                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
                <hr class="simple">
                <div class="row">

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