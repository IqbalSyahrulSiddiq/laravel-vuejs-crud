<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use DB;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function getData()
    {
        $dataSiswa = DB::table('siswas')->get();
        return response()->json($dataSiswa);
    }

    public function storeSiswa()
    {
        $id_edit = request('id_edit');
        $photo = request('file');
        if ($id_edit != "null") {
            $data = Siswa::find($id_edit);
            $data->nama = request('nama');
            $data->alamat = request('alamat');
            if ($photo) {
                $nama_file = $photo->getClientOriginalName();
                $photo->move('uploads', $nama_file);
                $data->photo = env('APP_URL').'/'.'uploads/' . $nama_file;
            }
            $data->save();
        } else {
            $data = new Siswa;
            $data->nama = request('nama');
            $data->alamat = request('alamat');
            if ($photo) {
                $nama_file = $photo->getClientOriginalName();
                $photo->move('uploads', $nama_file);
                $data->photo = env('APP_URL').'/'.'uploads/' . $nama_file;
            }
            $data->save();
        }
        return response()->json('sukses', 200);
    }

    public function detailSiswa($id)
    {
        $dt = Siswa::find($id);
        return response()->json($dt, 200);
    }

    public function deleteSiswa($id)
    {
        Siswa::where('id', $id)->delete();
        return response()->json('sukses', 200);
    }
}
