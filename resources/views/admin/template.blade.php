@extends('layouts')
@section('content')
<meta name="link-api" link="{{ url('/api/v1/template/data') }}">
<meta name="link-api-simpan" link="{{ url('/api/v1/template/simpan') }}">
<meta name="link-api-hapus" link="{{ url('/api/v1/template/hapus') }}">
<meta name="link-api-update" link="{{ url('/api/v1/template/update') }}">
<meta name="link-template" link="{{ url('/template') }}">
<meta name="link-image" link="{{ url('/image/template') }}">
<meta name="link-redirect" link="{{ url('/admin-wedding/template-undangan') }}">



<style>
    #upload {
        opacity: 0;
    }

    #upload-label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
    }

    #upload2 {
        opacity: 0;
    }

    #upload-label2 {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
    }

    .image-area {
        border: 2px dashed rgba(255, 255, 255, 0.7);
        padding: 1rem;
        position: relative;
    }

    .image-area::before {
        content: 'Uploaded image result';
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.8rem;
        z-index: 1;
    }

    .image-area img {
        z-index: 2;
        position: relative;
    }
</style>

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

<div class="modal" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title form-title">Form Tambah Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form_addTemplate" method="POST" enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Nama Template</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <span class="text-danger name_err"></span>
                    </div>
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link">
                        <span class="text-danger link_err"></span>
                    </div>
                    <div class="col-12">
                        <label for="inputPassword4" class="form-label">Gambar / Preview</label>
                        <div class="input-group mb-3 px-2 py-2 rounded-pill element-image shadow-sm" style="background: #dee2e6">
                            <input id="upload" type="file" onchange="readURL(this);" accept="image/*" name="image_template" class="form-control border-0 image-template">
                            <label id="upload-label" for="upload" class="font-weight-light text-muted">Pilih Gambar</label>
                            <div class="input-group-append">
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Unggah Gambar</small></label>
                            </div>
                        </div>
                        <span class="text-danger image_template_err"></span>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <p class="font-italic text-secondary text-center">(Ukuran gambar maksimal 3 MB)</p>
                            <p class="font-italic text-secondary text-center">Preview Gambar Baru</p>
                            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" width="200" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        <button type="reset" class="btn btn-warning btn-reset"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-close-modal-tambah" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title form-title">Form Edit Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form_editTemplate" method="POST" enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Nama Template</label>
                        <input type="hidden" class="form-control" name="id" id="id_edit">
                        <input type="text" class="form-control" name="name" id="name_edit">
                        <span class="text-danger name_err"></span>
                    </div>
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link_edit" name="link">
                        <span class="text-danger link_err"></span>
                    </div>
                    <div class="col-12">
                        <label for="inputPassword4" class="form-label">Gambar / Preview</label>
                        <div class="input-group mb-3 px-2 py-2 rounded-pill element-image shadow-sm" style="background: #dee2e6">
                            <input type="hidden" name="old_image" id="old_image">
                            <input id="upload2" type="file" onchange="readURL2(this);" accept="image/*" name="image_template" class="form-control border-0 image-template">
                            <label id="upload-label2" for="upload2" class="font-weight-light text-muted">Pilih Gambar</label>
                            <div class="input-group-append">
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Unggah Gambar</small></label>
                            </div>
                        </div>
                        <span class="text-danger image_template_err"></span>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="font-italic text-secondary text-center">Gambar Lama</p>
                                <p class="font-italic text-secondary text-center">Preview Gambar Lama</p>
                                <div class="image-area mt-4"><img id="imageView" src="#" alt="" width="200" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            </div>
                            <div class="col-md-6">
                                <p class="font-italic text-secondary text-center">(Ukuran gambar maksimal 3 MB)</p>
                                <p class="font-italic text-secondary text-center">Preview Gambar</p>
                                <div class="image-area mt-4"><img id="imageResult2" src="#" alt="" width="200" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Update</button>
                        <button type="reset" class="btn btn-warning btn-reset"><i class="fa fa-refresh"></i> Reset</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-close-modal-tambah" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="{{ url('js/admin/template.js') }}"></script>
@endsection
