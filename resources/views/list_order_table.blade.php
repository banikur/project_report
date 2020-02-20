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
                    @if(!empty($item->id_meja) && $item->status != 2 )
                    <form method="post" class="form-horizontal" action="{{url('/Cashier/finishing')}}" id="menu_form">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                        <div class="col-lg-3">
                            <div class="well">
                                <p>ID TRANSAKSI : {{$item->id_trans}}</p>
                                <input type="hidden" name="id_transaksi" value="{{$item->id_trans}}" />
                                <ul>
                                    <li>Nomor Meja : {{$item->id_meja}}</li>

                                    @foreach($transaksi_detail as $detail)
                                    @if($item->id_trans == $detail->id_trans)
                                    <li>{{$detail->nama_menu}} ({{$detail->qty}})</li>
                                    @endif
                                    @endforeach
                                    
                                </ul>
                                <hr />
                                    <div class="form-group">
                                        <label for="petugas_survei" class="col-sm-4">
                                            Total</label>
                                            <div class="col-sm-7">Rp. {{number_format($item->total,2,',','.')}}</div>
                                        <input type="hidden" class="form-control total" readonly="" name="total"
                                            value="{{number_format($item->total,2,',','.')}}" />
                                    </div>
                                    @if($item->status == 1)
                                    @else
                                    <div class="form-group">
                                        <label for="petugas_survei" class="col-sm-4">
                                            Cash </label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control cashier" name="cash" />
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-sm-12">
                                            Kembalian  Rp. <label id="label_kembali"></label>
                                            <input class="form-control" readonly="" type="hidden" name="kembalian"
                                                id="kembalian">
                                        </label>
                                    </div>
                                    @endif
                                <hr />
                                <center>
                                    @if($item->status == 1)
                                    <button type="button" onclick="checkout(this)" data-item="{{$item->id_trans}}"
                                        class="btn btn-primary">
                                        <i class="fa fa-check"></i> &nbsp;&nbsp; Check-Out
                                    </button>
                                    @else
                                    <button type="button" onclick="konfirmasi(this)" data-item="{{$item->id_trans}}"
                                        class="btn btn-primary">
                                        <i class="fa fa-print"></i> &nbsp;&nbsp;Print
                                    </button>
                                    &nbsp;&nbsp;&nbsp;

                                    @endif
                                </center>
                            </div>
                        </div>
                    </form>
                    @endif
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
function konfirmasi(button) {
    var x = $(".total").val();
    var c = x.split('.').join("");
    var total = c.split(',').join(".");

    var a = $(".cashier").val();
    var b = a.split('.').join("");
    var bayar = b.split(',').join(".");

    var due = bayar - total;
    $("#label_kembali").html(numberFormat(due, 2, ',', '.'));
    $('#kembalian').val(numberFormat(due, 2, ',', '.'));
    // alert(due);
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    Swal.fire({
        title: 'Cetak transaksi ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-print"></i>&nbsp;&nbsp;Ya',
        cancelButtonText: '<i class="fa fa-times"></i>&nbsp;&nbsp;Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            form.submit();
        } else {
            Swal.fire({
                title: "Batal Mencetak",
                type: "error",
                allowOutsideClick: false,
            })
        }
    })
}

function checkout() {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    Swal.fire({
        title: 'Check-Out transaksi',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-check"></i>&nbsp;&nbsp;Ya',
        cancelButtonText: '<i class="fa fa-times"></i>&nbsp;&nbsp;Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            form.submit();

        } else {
            Swal.fire({
                title: "Batal Mencetak",
                type: "error",
                allowOutsideClick: false,
            })
        }
    })

}

function konfirmasis(button) {
    var id = $(button).data('item');
    Swal.fire({
        title: 'Cetak Transaksi ' + id + ' ?',
        input: 'text',
        type: 'warning',
        inputPlaceholder: 'Cash :',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-times"></i>&nbsp;&nbsp; Tolak',
        confirmButtonColor: '#d33',
    }).then((result) => {
        if (result === false) return false;
        if (result.value) {
            $.post(
                "{{ url('Cashier/print/order').'/'}}" + id, {
                    _token: '{{ csrf_token() }}',
                    alasan: result.value
                },
                function(res) {
                    Swal.fire(
                        'Transaksi ditolak',
                        '',
                        'success'
                    );
                    $('#modal_detail').modal('hide');
                    table.ajax.reload();
                }
            );
        }
    });
}
</script>
@endsection