<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
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

        //dd($data);
        return view('home',$data);
    }
    public function employee(){
        $data['user'] = Auth::user();
        $data['employee'] = DB::table('employee')->get();
        //dd($data);
        return view('manager.employee',$data);
    }
    public function store_employee(request $request){
        try {
            $cek = DB::table('users')->orderby('id', 'desc')->first();        
           
            $data = ([
                'id_empl' => $request->id_empl,
                'nama_empl' => $request->nama_empl,
                'gender' => $request->gender,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'id_akun' => $cek->id +1,
                'pass' => $request->pass,
                'position' => $request->position,
            ]);
            $data_user = ([
                
                'name'=>$request->nama_empl,
                'email'=>$request->email,
                'password' =>Hash::make($request->pass),
                'status'=>$request->position,
            ]);
            //dd($data);
            $simpan = DB::table('employee')->Insert($data);
            $simpan_user = DB::table('users')->Insert($data_user);
            return redirect()->back()->with('message', 'Data Berhasil Disimpan');

        } catch (exception $th) {
            return redirect()->back()->with('message', 'Data GAGAL Disimpan');

        }
    }
    public function get_data_emp($id_emp){
        $data = DB::table('employee')
        ->where('id_empl',$id_emp)
        ->get();
        $jsonDecode = json_encode($data);
        if ($jsonDecode != null) {
            $sumberBB = $jsonDecode;
        }
        return $sumberBB;
    }
}
