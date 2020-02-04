<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PDF;

class KokiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        //dd($data);
        return view('Koki.dashboard',$data);
    }
    public function list_order()
    {
        $data['user'] = Auth::user();
        $data['transaksi'] = DB::table('trans')
        ->where('status',null)
        ->get();
        $data['transaksi_detail'] = DB::table('transdet')
        ->join('menu_restoran','transdet.id_menu','menu_restoran.id_menu')
        ->get();   
        //dd($data);
        return view('Koki.list_order',$data);
    }

    public function data_menu()
    {
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
        ->join('categorymenu','menu_restoran.id_catMenu','categorymenu.id_catMenu')
        ->orderBy('menu_restoran.id_menu','ASC')->get();

        //dd($data);
        return view('Koki.master_menu',$data);
    }

    public function getmenu($id_cat){
       
        $cek = DB::table('menu_restoran')
        ->where('id_catMenu',$id_cat)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }

    public function get_detail_menu($id_menu){
        $cek = DB::table('menu_restoran')
        ->where('id_menu',$id_menu)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $menu = $jsonDecode;
        }
        return $menu;
    }

    public function get_detail_barang($id_barang)
    {

        $cek = DB::table('master_barang')
            ->join('supplier', 'master_barang.id_supplier', 'supplier.id_supp')
            ->where('master_barang.id_barang', $id_barang)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }

    public function store_menu(Request $request)
    {
        try {
            $status ='';
            if ($request->status =='on') {
                $status='1';
            }
            else {
                $status='2';
            }
            $bukti_bayar = $request->file('gambar');
            $destination = public_path() . '/image_menu\\';
            
            $data = ([
                'id_menu' => $request->id_menu,
                'nama_menu' => $request->menu,
                'price' => $request->harga,
                'status_menu' => $status,
                'id_catMenu' => $request->category,
            ]);
            if ($bukti_bayar != null) {
                $nama_file2 = 'MN-' . uniqid() . '.' . $bukti_bayar->getClientOriginalExtension();
                $bukti_bayar->move($destination, $nama_file2);
                $data['url_pict'] = $nama_file2;
            }
            //dd($data);
            $simpan = DB::table('menu_restoran')->Insert($data);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }

    public function update_status(Request $request)
    {
        try {
            $ubah = DB::table('trans')->where('id_trans', $request->id_transaksi)->update(['status' => 1]);

            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }

    public function update_menu(Request $request)
    {
        try {
            $status ='';
            if ($request->status_edit =='on') {
                $status='1';
            }
            else {
                $status='2';
            }
            $bukti_bayar = $request->file('gambar_edit');
            $destination = public_path() . '/image_menu\\';
            $data = ([
                'price' => $request->harga_edit,
                'status_menu' => $status,
            ]);
            if ($bukti_bayar != null) {
                $nama_file2 = 'MN-' . uniqid() . '.' . $bukti_bayar->getClientOriginalExtension();
                $bukti_bayar->move($destination, $nama_file2);
                $data['url_pict'] = $nama_file2;
            }
            $ubah = DB::table('menu_restoran')->where('id_menu', $request->id_menu_edit)
            ->update($data);
            //dd($data,$ubah);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }


    public function insert_pembelian(Request $request)
    {
        // dd($request->all());
        try {
            $data = ([
                'id_pp' => $request->id_pp,
                'no_permintaan_pembelian' => $request->no_pp,
                'tanggal_pp' => $request->tgl_pp,
                'periode' => $request->periode,
                'estimasi_arrival' => $request->tgl_eta,
                'id_barang' => $request->id_barang,
                'ket_barang' => $request->ket_barang,
                'qty_pp' => $request->jumlah_pp,
            ]);
            //dd($data);
            $simpan = DB::table('permintaan_pembelian')->Insert($data);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }
    
    public function permintaan_pembelian()
    {
        $data['permintaan_pembelian'] = DB::table('permintaan_pembelian')->
            Join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')->get();
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();
        $data['master_barang'] = DB::table('master_barang')
            //->join('supplier', 'master_barang.id_supplier', 'supplier.id_supp')
            ->get();

        //dd($data);

        //dd($data);
        return view('Koki.permintaan_pembelian',$data);
    }
}
