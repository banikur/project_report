<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PDF;

class CostumerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $data['kategori'] = DB::table('categorymenu')->get();
    //     $data['transaksi'] = DB::table('trans')->get();
    //     //dd($data);
    //     return view('Costumer.order', $data);
    // }

    public function pilih_meja()
    {
        $data['meja'] = DB::table('tbl_meja')
        ->where('status','t')->get();
        //dd($data);
        return view('Costumer.picktable', $data);
    }

    public function getmenu($id_cat)
    {

        $cek = DB::table('menu_restoran')
            ->where('id_catMenu', $id_cat)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }
    public function get_detail_menu($id_menu)
    {
        $cek = DB::table('menu_restoran')
            ->where('id_menu', $id_menu)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $menu = $jsonDecode;
        }
        return $menu;
    }
    
    public function store_table(Request $request){
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['transaksi'] = DB::table('trans')->get();
        $data["no_meja"] =  $request->id_meja;
        //dd($data);
        return view('Costumer.cashier', $data);
    }

    public function store_trans(Request $request)
    {
        //dd($request);
        try {
            $id_transaksi = $request->id_transaksi;
            $bayar = str_replace(',', '.', $request->bayar);
            $kembalian = str_replace(',', '.', $request->kembalian);

            $tanggalskr = date('Y-m-d H:i:s');
            $totals = str_replace('.', '', $request->totals);
            $data_trans = ([
                'id_trans' => $request->id_transaksi,
                'tanggal' => $tanggalskr,
                'total' => str_replace(',', '.', $totals),
                'id_meja'=>$request->id_meja,
            ]);
            $simpan = DB::table('trans')->Insert($data_trans);
            if ($simpan > 0) {
                $menu = $request->nama_menu;
                $total_menu = count($menu);
                if ($total_menu > 0) {
                    for ($i = 0; $i < $total_menu; $i++) {
                        $data_detail = [
                            'id_trans' => $request->id_transaksi,
                            'id_transdet' => $i + 1,
                            'id_menu' => $request->nama_menu[$i],
                            'qty' => $request->qtys[$i],
                            'subtotal' => $request->totalharga[$i],
                        ];
                        DB::table('transdet')->insert($data_detail);
                    }
                }
            }
            $tanggalskr = date('Y-m-d H:i:s');

            $transaksi = DB::table('trans')
                ->where('id_trans', $id_transaksi)
                ->get();
            $transaksi_detail = DB::table('transdet')
                ->join('menu_restoran', 'transdet.id_menu', 'menu_restoran.id_menu')
                ->where('id_trans', $id_transaksi)
                ->get();

            $update = DB::table('tbl_meja')->where('id_meja',$request->id_meja)
            ->update(['status' => null]);
            //
            return redirect('/');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }

    }
}
