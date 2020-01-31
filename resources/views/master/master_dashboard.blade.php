@extends('template.backend.main')
@section('css')
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../front_login/css/util.css">
    <link rel="stylesheet" type="text/css" href="../front_login/css/main.css">
<style>
.container-login100s {
  width: 100%;  
  /* min-height: 100vh; */
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 10px;
  /* background: #e9faff; */
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
                        <div class="row">
                            <div class="container-login100s">
                                <a href="{{ url('/Purchasing/permintaan-pembelian') }}" class="btn btnround" id="homebtn"><img
                                        src="{{url('assets/icon/edit/Managing_item.png')}}"></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{ url('/Purchasing/supplier') }}" class="btn btnround" id="menu1btn"><img
                                        src="{{url('assets/icon/edit/supplier.png')}}"></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{ url('/Purchasing/master-barang') }}" class="btn btnround" id="menu2btn"><img
                                        src="{{url('assets/icon/edit/master_barang.png')}}"></a>
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

    function selectmenu() {
        var category = $("#category").val();
        var json = null;
        $.get('{{URL::to("cashier/cek_menu/")}}/' + category, function(data) {
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

    function getdetail() {
        var menu = $("#menu").val();
        var json = null;
        $.get('{{URL::to("cashier/get_detail_menu/")}}/' + menu, function(data) {
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
        var menu = $('#menu').val();
        var status = $('#status :selected').val();
        var harga = $('#harga').val();
        var id_menu = $('#menu :selected').val();
        var total = $('#total').val();
        if (menu == 'undefined' || harga == 'undefined' || status == 'undefined' || total == 'undefined') {
            menu = '';
            harga = '';
            total = '';
            status = '';
        }
        $('#nodetail').val(no + 1);
        $('#halu').css("display", "none");

        html += '<tr id="isiContentTable' + $('#nodetail').val() + '">';
        html += '<td><center><input type="text" style="display:none;" name="uud_insert[]" value="' +
            id_menu + '">' + menu + '</center></td>';
        html += '<td><center><input type="text" style="display:none;" name="pasal_insert[]" value="' +
            status + '">' + status + '</td>';
        html += '<td><center><input type="text" style="display:none;" name="ayat_insert[]" value="' +
            harga + '">' + harga + '</center></td>';
        html += '<td><center><input type="text" style="display:none;" name="ayat_insert[]" value="' +
            total + '">' + total + '</center></td>';
        html += '<td><center><button type="button" onclick="delete_detail(' + $('#nodetail').val() +
            ')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></center></td>';

        html += '</tr>';
        $('#isiTableedit').append(html);
        clear();
    });

    function delete_detail(no) {
        var cek = parseInt($('#nodetail').val());
        if (cek != 0) {
            $('#nodetail').val(cek - 1);
        }
        $('#isiContentTable' + no).remove();
        clear();
    }
    </script>
    @endsection