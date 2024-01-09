@extends('layouts')
@section('content')
<meta name="link-api" link="{{ url('/api/v1/pengantin/data') }}">

<div class="pagetitle">
    <h1>Data Pengantin</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Data Pengantin</li>
        </ol>
    </nav>
</div>

<section class="section" style="margin-bottom: 10%">
    <div class="row" style="margin-top: 20px">
        <div class="col-sm-12">
            <div class="card">
                <div class="col-sm-4 mt-3 mb-3" style="margin-left: 10px">
                    <a href="#tambah" class="btn btn-primary btn-sm btn-tambah"><i class="fa fa-plus-circle"></i> Tambah Pengantin</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 5px">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-bold">List Data Pengantin</h5>
                    <div class="table-responsive">
                        <table class="table table-stripped" id="data_pengantin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Undangan</th>
                                    <th>Template Pilihan</th>
                                    <th>Nama Pengantin</th>
                                    <th>Tanggal Pernikahan</th>
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
@section('js')
    <script src="{{ url('js/admin/pengantin.js') }}"></script>
@endsection
