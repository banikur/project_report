<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PDF;

class MasterController extends Controller
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
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();

        //dd($data);
        return view('master', $data);
    }

    public function index_dashboard()
    {
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();
        $data['master_barang'] = DB::table('master_barang')
            ->join('supplier', 'master_barang.id_supplier', 'supplier.id_supp')->get();

        //dd($data);
        return view('master.master_dashboard', $data);
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
            ->get();

        //dd($data);
        return view('Purchasing.permintaan_pembelian', $data);
    }

    public function permintaan_barang_koki()
    {
        $data['purchasing_order'] = DB::table('purchasing_order')->get();
        $data['permintaan_pembelian'] = DB::table('permintaan_pembelian')->
            Join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')->get();

        $data['user'] = Auth::user();
        $data['supplier'] = DB::table('supplier')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();
        //dd($data);
        return view('Purchasing.request_koki', $data);
    }

    public function purchasing_order()
    {
        $data['purchasing_order'] = DB::table('purchasing_order')->get();
        $data['permintaan_pembelian'] = DB::table('permintaan_pembelian')->
            Join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')->get();

        $data['user'] = Auth::user();
        $data['supplier'] = DB::table('supplier')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();

        //dd($data);
        return view('Purchasing.purchasing_order', $data);
    }

    public function surat_terima_barang()
    {
        $data['user'] = Auth::user();
        $data['suratterimabarang'] = DB::table('suratterimabarang')->get();
        $data['purchasing_order'] = DB::table('purchasing_order')
            ->join('permintaan_pembelian', 'purchasing_order.id_pp', 'permintaan_pembelian.id_pp')
            ->join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')
            ->join('supplier', 'purchasing_order.no_supplier', 'supplier.id_supp')
            ->get();
        return view('Purchasing.surat_terima_barang', $data);
    }

    public function payment_voucher()
    {
        $data['user'] = Auth::user();
        // $data['stb']  = DB::table('suratterimabarang')
        // ->select('qty_stb', DB::raw('SUM(qty_stb) as qty'))
        // ->join('purchasing_order','purchasing_order.id_po','suratterimabarang.id_po')
        // ->get();
        
        $data['stb'] = DB::select("SELECT
            sum(suratterimabarang.qty_stb) AS qty,
            suratterimabarang.id_po as id_purchasing,
            sum(suratterimabarang.sub_total_stb) as sub_total,
            suratterimabarang.status_stb
            FROM
            suratterimabarang
            JOIN purchasing_order ON suratterimabarang.id_po = purchasing_order.id_po
            GROUP BY id_purchasing,	status_stb 
        ");
        //dd($data);
        $data['purchasing_order'] = DB::table('purchasing_order')
        ->join('permintaan_pembelian', 'purchasing_order.id_pp', 'permintaan_pembelian.id_pp')
        ->join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')
        ->join('supplier', 'purchasing_order.no_supplier', 'supplier.id_supp')
        ->get();
        $data['paymentvoucher'] = DB::table('paymentvoucher')->get();
        return view('Purchasing.payment_voucher', $data);
    }
    public function cetak_pv()
    {
        $data['user'] = Auth::user();

        $data['paymentvoucher'] = DB::table('paymentvoucher')
            ->join('master_barang', 'master_barang.id_barang', 'paymentvoucher.id_barang')
            ->join('supplier', 'supplier.id_supp', 'paymentvoucher.no_supplier')
            ->get();
        return view('Purchasing.cetak_pv', $data);
    }

    public function supplier()
    {
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();
        $data['supplier'] = DB::table('supplier')->get();

        //dd($data);
        return view('Purchasing.supplier', $data);
    }

    public function master_barang()
    {
        $data['user'] = Auth::user();
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();
        $data['supplier'] = DB::table('supplier')->get();
        $data['master_barang'] = DB::table('master_barang')
            //->join('supplier', 'master_barang.id_supplier', 'supplier.id_supp')
            ->get();

        //dd($data);
        return view('Purchasing.master_barang', $data);
    }

    public function employee()
    {
        $data['kategori'] = DB::table('categorymenu')->get();
        $data['menu'] = DB::table('menu_restoran')
            ->join('categorymenu', 'menu_restoran.id_catMenu', 'categorymenu.id_catMenu')
            ->orderBy('menu_restoran.id_menu', 'ASC')->get();

        //dd($data);
        return view('employee', $data);
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

    public function get_detail_barang($id_barang)
    {

        $cek = DB::table('master_barang')
            ->where('master_barang.id_barang', $id_barang)->get();
        $jsonDecode = json_encode($cek);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }

    public function get_supp($id_supp)
    {

        $cek = DB::table('supplier')
            ->where('id_supp', $id_supp)->get();
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

    public function store_supp(Request $request)
    {
        try {
            $data = ([
                'id_supp' => $request->id_supp,
                'nama_supp' => $request->nama_supp,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat_supp,
            ]);
            //dd($data);
            $simpan = DB::table('supplier')->Insert($data);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');
        }
    }

    public function store_barang(Request $request)
    {
        try {
            $data = ([
                'id_barang' => $request->id_barang,
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'stok' => str_replace(',', '.', $request->stok),
            ]);
            //dd($data);
            $simpan = DB::table('master_barang')->Insert($data);
            //dd($simpan);
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

    
    public function store_po(Request $request)
    {
        try {
            $data = ([
                'id_po' => $request->id_po,
                'no_purchasing_order' => $request->no_purchasing,
                'tanggal_po' => $request->tgl_po,
                'periode_po' => $request->periode,
                'estimasi_arrival_po' => $request->tgl_eta,
                'no_supplier' => $request->supplier_edit,
                'id_barang' => $request->id_barang,
                'qty_po' => str_replace('.', '', str_replace(',', '.', $request->qty)),
                'harga_po' => str_replace('.', '', str_replace(',', '.', $request->harga)),
                'sub_total' => str_replace(',', '.',str_replace('.', '', $request->sub_total)),
                'status_po' => null,
                'id_pp' => $request->id_pp,
            ]);
            //dd($data);
            $simpan = DB::table('purchasing_order')->Insert($data);
            $ubah = DB::table('permintaan_pembelian')->where('id_pp', $request->id_pp)->update(['status' => 1]);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }

    }

    public function store_koki(Request $request)
    {
        try {
            $data = ([
                'id_po' => $request->id_po,
                'no_purchasing_order' => $request->no_purchasing,
                'tanggal_po' => $request->tgl_po,
                'periode_po' => $request->periode,
                'estimasi_arrival_po' => $request->tgl_eta,
                'no_supplier' => $request->supplier_edit,
                'id_barang' => $request->id_barang,
                'qty_po' => str_replace('.', '', str_replace(',', '.', $request->qty)),
                'harga_po' => 0,
                'sub_total' => 0,
                'status_po' => 1,
                'id_pp' => $request->id_pp,
            ]);
            //dd($data);
            $simpan = DB::table('purchasing_order')->Insert($data);
            $ubah = DB::table('permintaan_pembelian')->where('id_pp', $request->id_pp)->update(['status' => 1]);
            $get_inven = DB::table('master_barang')
                ->where('id_barang', $request->id_barang)->first();
            $stok = $get_inven->stok;
            $total_stok = $stok - $request->qty;
            $update_stok = DB::table('master_barang')
                ->where('id_barang', $request->id_barang)
                ->update(['stok' => $total_stok]);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }

    public function store_pv(Request $request)
    {
        try {
            $data = ([
                'id_pv' => $request->id_pv,
                'no_payment_voucher' => $request->no_pv,
                'tanggal_pv' => $request->tgl_pv,
                'periode_pv' => $request->periode,
                'id_barang' => $request->id_barang,
                'qty' => $request->qty_stb,
                'sub_total_pv' => str_replace(',', '.',str_replace('.', '',  $request->sub_total)),
                'no_supplier' => $request->id_supp,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'no_purchasing_order' => $request->no_po,
            ]);
            //dd($data);
            $simpan = DB::table('paymentvoucher')->Insert($data);
            $id_po = DB::table('purchasing_order')->where('no_purchasing_order',$request->no_po)->first();
            $ubah = DB::table('suratterimabarang')->where('id_po', $id_po->id_po)->update(['status_stb' => 1]);
            //dd($id_po,$ubah);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }

    public function store_stb(Request $request)
    {
        try {
            $bukti_bayar = $request->file('bukti_bayar');
            $destination = public_path() . '/upload-dokumen\\';
            $data = ([
                'id_stb' => $request->id_stb,
                'no_stb' => $request->no_stb,
                'tanggal_stb' => $request->tgl_stb,
                'periode_stb' => $request->periode_po,
                'id_barang' => $request->id_barang,
                'qty_po' => str_replace('.', '', str_replace(',', '.', $request->qty_po)),
                'qty_stb' => str_replace('.', '', str_replace(',', '.', $request->qty_stb)),
                'status_stb' => null,
                'id_po' => $request->id_po,
                'sub_total_stb' =>null,
            ]);
            if ($bukti_bayar != null) {
                if (!in_array($bukti_bayar->getClientOriginalExtension(), ['pdf', 'doc', 'docx'])) {
                    return redirect()->back()->with(['error' => 'Silahkan upload surat tugas dengan ekstensi yang sesuai dan maksimal ukuran 5 MB']);
                }
                $nama_file2 = 'BB-' . uniqid() . '.' . $bukti_bayar->getClientOriginalExtension();
                $bukti_bayar->move($destination, $nama_file2);
                $data['dokumen_bukti'] = $nama_file2;
            }

            if ($request->qty_stb == $request->qty_po) {
                $ubah = DB::table('purchasing_order')->where('id_po', $request->id_po)->update(['status_po' => 1]);
            } else {
                $sudah_masuk_inven = DB::table('suratterimabarang')->where('id_po', $request->id_po)->sum('qty_stb');
                $total_stb = $sudah_masuk_inven + str_replace('.', '', str_replace(',', '.', $request->qty_stb));
                
                if ($total_stb == $request->qty_po) {
                    $ubah = DB::table('purchasing_order')->where('id_po', $request->id_po)->update(['status_po' => 1]);
                }
            }
            $simpan = DB::table('suratterimabarang')->Insert($data);

            $get_inven = DB::table('master_barang')
                ->where('id_barang', $request->id_barang)->first();
            $stok = $get_inven->stok;
            $total_stok = $stok + $request->qty_stb;
            $update_stok = DB::table('master_barang')
                ->where('id_barang', $request->id_barang)
                ->update(['stok' => $total_stok]);
            //dd($sudah_masuk_inven,$total_stb);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }

    public function get_data_pp($id_pp)
    {
        $data = DB::table('permintaan_pembelian')
            ->Join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')
            ->where('permintaan_pembelian.id_pp', $id_pp)
            ->get();
        $jsonDecode = json_encode($data);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;

    }

    public function get_data_po($id_po)
    {
        $data = DB::table('purchasing_order')
            ->join('permintaan_pembelian', 'purchasing_order.id_pp', 'permintaan_pembelian.id_pp')
            ->join('master_barang', 'permintaan_pembelian.id_barang', 'master_barang.id_barang')
            ->join('supplier', 'purchasing_order.no_supplier', 'supplier.id_supp')
            ->where('purchasing_order.id_po', $id_po)
            ->get();
        $jsonDecode = json_encode($data);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;

    }

    public function get_data_stb($id_stb)
    {
        $data = DB::table('suratterimabarang')
            ->join('purchasing_order', 'purchasing_order.id_po', 'suratterimabarang.id_po')
            ->join('master_barang', 'purchasing_order.id_barang', 'master_barang.id_barang')
            ->join('supplier', 'purchasing_order.no_supplier', 'supplier.id_supp')
            ->where('purchasing_order.no_purchasing_order', base64_decode($id_stb))
            ->get();
        $jsonDecode = json_encode($data);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }

    public function print_pv($id_pv)
    {

        $paymentvoucher = DB::table('paymentvoucher')
            ->join('purchasing_order', 'purchasing_order.no_purchasing_order', 'paymentvoucher.no_purchasing_order')
            ->join('master_barang', 'master_barang.id_barang', 'paymentvoucher.id_barang')
            ->join('supplier', 'supplier.id_supp', 'paymentvoucher.no_supplier')
            ->where('paymentvoucher.id_pv',$id_pv)
            ->get();

        // dd($data);
        set_time_limit(600);
        $pdf = PDF::setOptions([
            'enable_remote' => true,
            'images' => true,
        ])
            ->loadView('Purchasing.print',
                compact('paymentvoucher'))
            ->setPaper('a5', 'landscape');
        $name = 'LHV - ' . uniqid() . '.pdf';
        // return $pdf->download($name);
        return $pdf->stream('PV-' . uniqid() . '.pdf');
    }

    public function update_barang(Request $request){
        try {
           
            //dd($request->harga_edit,str_replace('.','',$request->harga_edit));
            $ubah = DB::table('master_barang')->where('id_barang', $request->id_barang_edit)
            ->update(['nama_barang'=>$request->nama_barang_edit]);

            return redirect()->back()->with('message', 'Data Berhasil Ubah');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Ubah');

        }
    }

    public function update_supp(Request $request){
        try {
           
            //dd($request->harga_edit,str_replace('.','',$request->harga_edit));
            $ubah = DB::table('supplier')->where('id_supp', $request->id_supp_edit)
            ->update(['nama_supp'=>$request->nama_supp_edit,'alamat'=>$request->alamat_edit, 'no_telp'=>$request->no_telp_edit]);

            return redirect()->back()->with('message', 'Data Berhasil Ubah');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Ubah');

        }
    }
}
