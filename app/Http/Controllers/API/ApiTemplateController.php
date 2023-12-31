<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Template_invitation;

class ApiTemplateController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $dataTemplate = Template_invitation::orderBy('id', 'desc');

        if (!empty($search)) {
            $dataTemplate = $dataTemplate->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }

        $total = $dataTemplate->count();

        if($total == 0) {
            $result['recordsTotal']     = 0;
            $result['recordsFiltered']  = 0;
            $result['draw']             = $draw;
            $result['data']             = [];
            $result['status']           = false;
            $result['message']          = "Data tidak ditemukan";
            return response($result);
        }

        $data = $dataTemplate->offset($start)->limit($length)->get();

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
            'link' => 'required',
            'image_template' => 'required|max:3024'
        ], [
            'name.required' => 'Nama template wajib diisi',
            'link.required' => 'Link wajib diisi',
            'image_template.required' => 'Gambar template wajib diunggah',
            'image_template.max' => 'Ukuran maksimal gambar 3Mb'
        ]);

        if($validasi->fails()) {
            return response([
                'success' => false,
                'info_error' => 'validasi_eror',
                'errors' => $validasi->errors()
            ]);
        }

        $imageTemplate = $request->file('image_template');
        $nameImage = time() ."-". $imageTemplate->getClientOriginalName();
        $folder_upload = 'image/template';
        $imageTemplate->move($folder_upload, $nameImage);

        $template = [
            'name' => $request->name,
            'link' => $request->link,
            'image_template' => $nameImage,
            'count_select' => '0'
        ];

        $simpan = Template_invitation::create($template);
        if($simpan) {
            return response([
                'success' => true,
                'message' => 'Data template undangan berhasil disimpan'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data template undangan gagal disimpan'
        ]);
    }

    public function update(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'link' => 'required',
        ], [
            'name.required' => 'Nama template wajib diisi',
            'link.required' => 'Link wajib diisi',
        ]);

        if($validasi->fails()) {
            return response([
                'success' => false,
                'info_error' => 'validasi_eror',
                'errors' => $validasi->errors()
            ]);
        }

        if(!empty($request->image_template)) {

            $data_image = Template_invitation::where('id', $request->id)->first();
            $image_patch = public_path('image/template/' . $data_image->image_template);
            if(file_exists($image_patch)) {
                unlink($image_patch);
            }

            $imageTemplate = $request->file('image_template');
            $nameImage = time() ."-". $imageTemplate->getClientOriginalName();
            $folder_upload = 'image/template';
            $imageTemplate->move($folder_upload, $nameImage);
        } else {
            $nameImage = $request->old_image;
        }

        $template_edit = [
            'name' => $request->name,
            'link' => $request->link,
            'image_template' => $nameImage,
        ];

        $update = Template_invitation::where('id', $request->id)->update($template_edit);
        if($update) {
            return response([
                'success' => true,
                'message' => 'Data template berhasil diperbarui'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data template gagal diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $data_image = Template_invitation::where('id', $id)->first();
        $image_patch = public_path('image/template/' . $data_image->image_template);
        if(file_exists($image_patch)) {
            unlink($image_patch);
        }

        $hapus = Template_invitation::where('id', $id)->delete();
        if($hapus) {
            return response([
                'success' => true,
                'message' => 'Data template berhasil dihapus'
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Data template gagal dihapus'
        ]);
    }
}
