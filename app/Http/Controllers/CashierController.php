<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PDF;

class CashierController extends Controller
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
        $data['transaksi'] = DB::table('trans')->get();
        //dd($data);
        return view('cashier_trans', $data);
    }
    public function checkout()
    {
        $data['user'] = Auth::user();
        $data['transaksi'] = DB::table('trans')
            ->get();
        $data['transaksi_detail'] = DB::table('transdet')
            ->join('menu_restoran', 'transdet.id_menu', 'menu_restoran.id_menu')
            ->get();

        return view('list_order_table', $data);
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

    public function store_trans(Request $request)
    {

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
                            'qty' => $request->qty[$i],
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
            //dd($transaksi,$transaksi_detail);
            set_time_limit(600);
            $pdf = PDF::setOptions([
                'enable_remote' => true,
                'images' => true,
            ])
                ->loadView('cetak_struk',
                    compact('transaksi', 'transaksi_detail', 'bayar', 'kembalian'))
                ->setPaper('a6', 'potrait');
            $name = 'TRX - ' . uniqid() . '.pdf';
            return $pdf->download($name);
            //return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }

    }

    public function finishing(Request $request)
    {
        $id_transaksi = $request->id_transaksi;

        try {
            $transaksi = DB::table('trans')->where('id_trans',$id_transaksi)
            ->get();
            $transaksi_detail = DB::table('transdet')
            ->join('menu_restoran', 'transdet.id_menu', 'menu_restoran.id_menu')
            ->where('id_trans', $id_transaksi)
            ->get();
            $bayar = 0;
            $kembalian  = 0;
            if ($transaksi[0]->status == null) {
                set_time_limit(600);
                $pdf = PDF::setOptions([
                    'enable_remote' => true,
                    'images' => true,
                ])
                    ->loadView('cetak_struk',
                        compact('transaksi', 'transaksi_detail', 'bayar', 'kembalian'))
                    ->setPaper('a6', 'potrait');
                $name = 'TRX - ' . uniqid() . '.pdf';
                return $pdf->download($name);
            }else {
                $cek = DB::table('trans')->where('id_trans',$id_transaksi)
                ->get();
                $id_table= $cek[0]->id_meja;
                $update = DB::table('tbl_meja')->where('id_meja',$id_table)
                ->update(['status' => 't']);
                $ubah = DB::table('trans')->where('id_trans', $id_transaksi)->update(['status' => 2]);
                return redirect()->back()->with('message', 'Data Berhasil Disimpan');
            }
        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }
}
