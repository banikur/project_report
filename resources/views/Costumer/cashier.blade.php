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
                                foreach ($transaksi as $item) {
                                    $testing = $item->id_trans;
                                }
                                $rest = (int) substr($testing, 0, 4);
                                $tanggalskr = date('Y-m-d H:i:s');
                                $date = date_format(date_create($tanggalskr), 'Y/m/d');
                                $bulan = date('m');
                                $tahun = date('Y');
                                $no = 0;
                                if ($rest == 0) {
                                    $no = "0001";
                                    $autonya = "$no/TRX/$bulan/$tahun";
                                } else if ($rest < 9) {
                                    $no = $rest + 1;
    
                                    $autonya = "000$no/TRX/$bulan/$tahun";
    
                                } else if ($rest < 99) {
                                    $no = $rest + 1;
    
                                    $autonya = "00$no/TRX/$bulan/$tahun";
    
                                } else if ($rest < 999) {
                                    $no = $rest + 1;
    
                                    $autonya = "0$no/TRX/$bulan/$tahun";
    
                                } else if ($rest < 9999) {
                                    $no = $rest + 1;
    
                                    $autonya = "$no/TRX/$bulan/$tahun";
    
                                } else {
                                    $autonya = "$no/TRX/$bulan/$tahun";
                                }
                            ?>
                        <form method="post" action="{{url('/Costumer/store_trans')}}" class="form-horizontal"
                            id="dynamic_form">
                            {{csrf_field()}}
                            <div class="col-lg-6">
                                <input class="form-control" readonly="" type="hidden" value="{{$autonya}}"
                                    name="id_transaksi" id="id_transaksi" autocomplete="off">
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
                                        Harga</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" readonly="" type="hidden" name="nama_menu"
                                            id="nama_menu">
                                        <input class="form-control" readonly="" type="hidden" name="id_menu"
                                            id="id_menu">
                                        <input class="form-control" name="id_meja" readonly="" type="hidden" value="{{$no_meja}}" name="id_meja"
                                            id="id_meja">
                                        <input class="form-control money" readonly="" type="text" name="harga"
                                            id="harga">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Qty.</label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-number"
                                                    disabled="disabled" data-type="minus" data-field="qty[1]">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" id="qty" name="qty[1]" readonly=""
                                                class="form-control input-number" value="1" min="1" max="99">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-number"
                                                    data-type="plus" data-field="qty[1]">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        <!-- <input class="form-control angka" onkeyup="dikali()" type="text" name="qty"
                                            id="qty" autocomplete="off"> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label">
                                        Sub Total</label>
                                    <div class="col-sm-7">
                                        <input class="form-control uang" disabled="" type="text" name="total"
                                            id="total">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="petugas_survei" class="col-sm-4 control-label"></label>
                                    <div class="col-sm-7">
                                        <button type="button" id="addmore" class="btn btn-primary btn-sm"><i
                                                class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Tambah
                                        </button>
                                        <div class="pull-right">
                                            <button type="submit" onclick="konfirmasi()" class="btn btn-danger"><i
                                                    class="fa fa-tasks"></i>&nbsp;&nbsp;Buat Pesanan
                                            </button>
                                            <!-- <a class="btn btn-success" onclick="refresh()"><i
                                                    class="fa fa-check"></i>&nbsp;&nbsp;SIMPAN
                                            </a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <table id="dt_basic_1" class="table table-striped table-bordered table-hover"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Nama Menu</center>
                                            </th>
                                            <th>
                                                <center>Qty</center>
                                            </th>
                                            <th>
                                                <center>Harga Menu</center>
                                            </th>
                                            <th>
                                                <center>Total Harga</center>
                                            </th>
                                            <th>
                                                <center>&nbsp;</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="isiTableedit">
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-6 col-lg-offset-6">
                                    <div class="form-group">
                                        <label class="col-sm-4">
                                            Total : Rp. <label id="labelnya"></label>
                                        </label>
                                        <div class="col-sm-7">
                                            <input class="form-control" readonly="" type="hidden" name="totals"
                                                id="totals">
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <div class="col-lg-12" id="menu">
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
})
$('.btn-number').click(function(e) {
    e.preventDefault();
    fieldName = $(this).attr('data-field');
    type = $(this).attr('data-type');
    var input = $("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {
            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }
        } else if (type == 'plus') {
            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }
        }
    } else {
        input.val(0);
    }

});
$('.input-number').focusin(function() {
    $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    minValue = parseInt($(this).attr('min'));
    maxValue = parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    name = $(this).attr('name');
    if (valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    dikali();
});


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

function haha() {
    var sum = 0;
    //alert("masul");
    var x = $("#totals").text();
    var a = $("#totals").text();
    $(".totalharga").each(function() {
        var tmpNilai = this.value.split('.').join("");
        var nilai = tmpNilai.split(',').join(".");
        if (!isNaN(nilai) && nilai.length != 0) {
            sum += parseFloat(nilai);
            // $(this).css("background-color", "#FEFFB0");
        } else if (nilai.length != 0) {

        } else {
            //add only if the value is number
            sum += parseFloat(nilai);
            if (!isNaN(nilai) && nilai.length != 0) {
                sum += parseFloat(nilai);
                // $(this).css("background-color", "#FEFFB0");
            } else if (nilai.length != 0) {
                sum += parseFloat(nilai);
            }
        }
    });
    $('#totals').val(numberFormat(sum, 2, ',', '.'));
    $("#labelnya").html(numberFormat(sum, 2, ',', '.'));
}

function selectmenu() {
    var category = $("#category").val();
    var json = null;
    $.get('{{URL::to("/Costumer/cek_menu/")}}/' + category, function(data) {
        json = JSON.parse(data);
        console.log(json);
        test = '';
        var url = "{{ URL::asset('/image_menu') }}";
        for (let i = 0; i < json.length; i++) {
            test +=
                "<div class='col-md-3'><div class='well'><div class='form-group'><img style='max-width: 100%;min-width: 100%; width:180px; height:180px;' src='" +
                url + "/" + json[i].url_pict +
                "'/><input type='hidden' readonly='' class='form-control' value='" +
                json[i].id_menu +
                "'><center>" + json[i].nama_menu + "</center><br/><center>Rp. "+numberFormat(json[i].price,2,',','.')+"</center><br/><button data-item='" + json[i].price +
                "' data-menu='" + json[i].nama_menu +
                "' data-id='" + json[i].id_menu +
                "' type='button' onclick='passing_text(this)' class='btn btn-primary btn-lg btn-block'>Pilih</button></div></div></div>";
        }
        $('#menu').html(test);
    });
    clear();
}

function refresh() {
    setTimeout(function() {
        location.reload()
    }, 100);
}

function passing_text(button) {
    var harga = $(button).data('item');
    var nama_menu = $(button).data('menu');
    var id_menu = $(button).data('id');
    $('#harga').val(harga);
    $('#nama_menu').val(nama_menu);
    $('#id_menu').val(id_menu);
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
    var menu = $('#nama_menu').val();
    var qty = $('#qty').val();
    var harga = $('#harga').val();
    var id_menu = $('#id_menu').val();
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
    html += '<td><center><input type="text" style="display:none;" name="qtys[]" value="' +
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