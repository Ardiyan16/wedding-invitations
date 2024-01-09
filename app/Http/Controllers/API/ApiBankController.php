<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;

class ApiBankController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $dataBank = Bank::orderBy('id', 'desc');

        if (!empty($search)) {
            $dataBank = $dataBank->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }

        $total = $dataBank->count();

        if($total == 0) {
            $result['recordsTotal']     = 0;
            $result['recordsFiltered']  = 0;
            $result['draw']             = $draw;
            $result['data']             = [];
            $result['status']           = false;
            $result['message']          = "Data tidak ditemukan";
            return response($result);
        }

        $data = $dataBank->offset($start)->limit($length)->get();

        $result['recordsTotal']     = $total;
        $result['recordsFiltered']  = $total;
        $result['draw']             = $draw;
        $result['data']             = $data;
        $result['status']           = true;
        $result['message']          = "OK";
        return response($result);
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required|max:3024'
        ], [
            'name.required' => 'Nama bank wajib diisi',
            'logo.required' => 'Gambar logo wajib diisi',
            'logo.max' => 'Ukuran gambar logo maksimal 3Mb'
        ]);

        if($validasi->fails()) {
            return response([
                'success' => false,
                'info_error' => 'validasi_eror',
                'errors' => $validasi->errors()
            ]);
        }

        $imageLogo = $request->file('logo');
        $nameImage = time() ."-". $imageLogo->getClientOriginalName();
        $folder_upload = 'image/bank';
        $imageLogo->move($folder_upload, $nameImage);

        $bank = [
            'name' => $request->name,
            'logo' => $nameImage
        ];

        $simpan = Bank::create($bank);
        if($simpan) {
            return response([
                'success' => true,
                'message' => 'Data bank berhasil disimpan'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data bank gagal disimpan'
        ]);
    }

    public function update(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'max:3024'
        ], [
            'name.required' => 'Nama bank wajib diisi',
            // 'logo.required' => 'Gambar logo wajib diisi',
            'logo.max' => 'Ukuran gambar logo maksimal 3Mb'
        ]);

        if($validasi->fails()) {
            return response([
                'success' => false,
                'info_error' => 'validasi_eror',
                'errors' => $validasi->errors()
            ]);
        }

        if(!empty($request->logo)) {

            $datalogo = Bank::where('id', $request->id)->first();
            $image_patch = public_path('image/bank/' . $datalogo->logo);
            if(file_exists($image_patch)) {
                unlink($image_patch);
            }

            $imageLogo = $request->file('logo');
            $nameImage = time() ."-". $imageLogo->getClientOriginalName();
            $folder_upload = 'image/bank';
            $imageLogo->move($folder_upload, $nameImage);
        } else {
            $nameImage = $request->old_image;
        }

        $bank = [
            'name' => $request->name,
            'logo' => $nameImage
        ];

        $update = Bank::where('id', $request->id)->update($bank);
        if($update) {
            return response([
                'success' => true,
                'message' => 'Data bank berhasil diperbarui'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data bank gagal diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $datalogo = Bank::where('id', $id)->first();
        $image_patch = public_path('image/bank/' . $datalogo->logo);
        if(file_exists($image_patch)) {
            unlink($image_patch);
        }
        $hapus = Bank::where('id', $id)->delete();
        if($hapus) {
            return response([
                'success' => true,
                'message' => 'Data bank berhasil dihapus'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data bank gagal dihapus'
        ]);
    }
}
