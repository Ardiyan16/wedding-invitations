<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Bride_data;
use App\Models\Bridal_photo;
use App\Models\Template_invitation;

class ApiPengantinController extends Controller
{
    public function index(Request $request)
    {
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw   = $request->input('draw');
        $search = $request->input('search.value');

        $dataPengantin = DB::table('bride_datas')
                        ->select('bride_datas.*', 'template_invitations.name')
                        ->leftJoin('template_invitations', 'template_invitations.id', '=', 'bride_datas.template_id')
                        ->orderBy('id', 'desc');

        if (!empty($search)) {
            $dataPengantin = $dataPengantin->where(function ($query) use ($search) {
                $query->where('name_invitation', 'like', "%$search%");
            });
        }

        $total = $dataPengantin->count();

        if($total == 0) {
            $result['recordsTotal']     = 0;
            $result['recordsFiltered']  = 0;
            $result['draw']             = $draw;
            $result['data']             = [];
            $result['status']           = false;
            $result['message']          = "Data tidak ditemukan";
            return response($result);
        }

        $data = $dataPengantin->offset($start)->limit($length)->get();

        $result['recordsTotal']     = $total;
        $result['recordsFiltered']  = $total;
        $result['draw']             = $draw;
        $result['data']             = $data;
        $result['status']           = true;
        $result['message']          = "OK";
        return response($result);
    }
}
