@extends('layouts')
@section('content')
<meta name="link-api" link="{{ url('/api/v1/template/data') }}">

<div class="pagetitle">
    <h1>Template Undangan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Template Undangan</li>
        </ol>
    </nav>
</div>

<section class="section" style="margin-bottom: 10%">
    <div class="row" style="margin-top: 20px">
        <div class="col-sm-12">
            <div class="card">
                <div class="col-sm-4 mt-3 mb-3" style="margin-left: 10px">
                    <a href="#tambah" class="btn btn-primary btn-sm btn-tambah"><i class="fa fa-plus-circle"></i> Tambah Template</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 5px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-bold">List Data Template</h5>
                    <div class="table-responsive">
                        <table class="table table-stripped" id="data_template">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Link</th>
                                    <th>Jumlah Dipakai</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
