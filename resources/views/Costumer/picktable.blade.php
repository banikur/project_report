@extends('template.backend.main2')
@section('title')
BIG POP
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
                    <center><h1> Jumlah meja tersedia : <?php echo count($meja); ?></h1></center>
                    <hr/>
                    @foreach($meja as $item)
                    <form method="post" class="form-horizontal" action="{{url('/Costumer/store_table')}}" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="col-lg-3">
                            <div class="well">
                                <p>Meja No : {{$item->no_meja}}</p>
                                <input type="hidden" value="{{$item->id_meja}}" name="id_meja">
                                @if($item->status == 't')
                                <button type="button" onclick="konfirmasi()" data-item="{{$item->id_meja}}"
                                    class="btn btn-primary btn-lg btn-block">
                                    Pilih
                                </button>
                                @else
                                <button type="button" disabled="" onclick="konfirmasi()" data-item="{{$item->id_meja}}"
                                    class="btn btn-primary btn-lg btn-block">
                                    Pilih
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    @endforeach
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


function selectmenu() {
    var category = $("#category").val();
    var json = null;
    $.get('{{URL::to("/Costumer/cek_menu/")}}/' + category, function(data) {
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

function refresh() {
        setTimeout(function() {
            location.reload()
        }, 100);
    }
function konfirmasi() {

    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form

    Swal.fire({
        title: 'Yakin Pilih Meja Ini ?',
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

function getdetail() {
    var menu = $("#menu").val();
    var json = null;
    $.get('{{URL::to("/Costumer/get_detail_menu/")}}/' + menu, function(data) {
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
    html += '<td><center><input type="text" style="display:none;" name="nama_menu[]" value="' +
        id_menu + '">' + menu + '</center></td>';
    html += '<td><center><input type="text" style="display:none;" name="qty[]" value="' +
        qty + '">' + qty + '</td>';
    html += '<td><center><input type="text" style="display:none;" name="hargasat[]" value="' +
        harga + '">' + numberFormat(harga, 2, ',', '.') + '</center></td>';
    html +=
        '<td><center><input type="text" style="display:none;"id="totalharga" class="totalharga" name="totalharga[]" value="' +
        total + '">' + numberFormat(total, 2, ',', '.') + '</center></td>';
    html += '<td><center><button type="button" onclick="delete_detail(' + $('#nodetail').val() +
        ')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></center></td>';

    html += '</tr>';
    $('#isiTableedit').append(html);
    clear();
    haha();
});

function delete_detail(no) {
    var cek = parseInt($('#nodetail').val());
    if (cek != 0) {
        $('#nodetail').val(cek - 1);
    }
    $('#isiContentTable' + no).remove();
    clear();
    haha();
}
</script>
@endsection