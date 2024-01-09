$(document).ready(function() {

    function load_table()
    {
        let link_api = $("meta[name='link-api']").attr("link");
        $("table#data_bank").DataTable().destroy();
        $("table#data_bank").DataTable({
            ajax: {
                url: link_api,
                headers: {
                    Authorization: "Bearer " + get_cookie("ALD_SESSION"),
                },
                type: "POST",
            },
            serverSide: true,
            processing: true,
            aaSorting: [[0, "desc"]],
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return (
                            meta.row + meta.settings._iDisplayStart + 1 + "."
                        );
                    },
                },
                { data: "name", name: "name" },
                {
                    data: null,
                    render: (res) => {
                        let link = $("meta[name='link-image']").attr("link");
                        let link_image = link+"/"+res.logo;
                        return `<a href="${link_image}" target="_blank" title="lihat gambar ukuran penuh" class="view_image"><img src="${link_image}" width="75"></a>`
                    }
                },
                {
                    data: null,
                    render: (res) => {
                        return `
                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-id="${res.id}" data-name="${res.name}" data-logo="${res.logo}" style="color: #FFF;" title="edit"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm btn-hapus" data-id="${res.id}" data-name="${res.name}" style="color: #FFF;" title="hapus"><i class="fa fa-trash"></i></button>
                        `;
                    },
                },
            ],
        });
    }
    load_table();

    $(document).on('click', '.btn-tambah', function() {
        $('input#name').val();
        $('input#upload').val();
        $('#tambah').modal('show');
    })

    $("#form_addBank").on('submit', function(e) {
        e.preventDefault();
        let link_api = $("meta[name='link-api-simpan']").attr("link");

        $.ajax({
            url: link_api,
            headers: {
                Authorization: "Bearer " + get_cookie("ALD_SESSION"),
            },
            data: new FormData(this),
            type: "POST",
            dataType: "JSON",
            contentType: false,
            processData: false,

            success: function(res) {

                if(res.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    .then (function() {
                        let redirect = $("meta[name='link-redirect']").attr("link");
                        window.location.href = redirect;
                    });

                } else {

                    if(res.info_error) {
                        validasi(res.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message
                        });
                    }

                }

            }
        })
    })

    function validasi(message) {
        $.each(message, function(key, val)  {
            $('.'+key+'_err').text(val);
        })
    }

    $(document).on('click', '.btn-edit', function() {
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        let logo = $(this).attr('data-logo');
        let link_html = $("meta[name='link-image']").attr("link");
        let link_image = link_html+"/"+logo;
        $('input#name_edit').val(name);
        $('input#id').val(id);
        $('input#old_image').val(link_image);
        $('#imageView').attr('src', link_image);
        $('#edit').modal('show');
    })

    $('#form_editTemplate').on('submit', function(e) {
        e.preventDefault();
        let link_api = $("meta[name='link-api-update']").attr("link");

        $.ajax({
            url: link_api,
            headers: {
                Authorization: "Bearer " + get_cookie("ALD_SESSION"),
            },
            data: new FormData(this),
            type: "POST",
            dataType: "JSON",
            contentType: false,
            processData: false,

            success: function(res) {

                if(res.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    .then (function() {
                        let redirect = $("meta[name='link-redirect']").attr("link");
                        window.location.href = redirect;
                    });

                } else {

                    if(res.info_error) {
                        validasi(res.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message
                        });
                    }

                }

            }
        })
    })

    $(document).on('click', '.btn-hapus', function() {
        let link_api = $("meta[name='link-api-hapus']").attr("link");
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        Swal.fire({
            title: 'Apakah anda yakin ?',
            text: "Data bank "+name+" akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#898989',
            confirmButtonText: 'Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: link_api+"/"+id,
                    headers: {
                        'Authorization': 'Bearer '+get_cookie('ALD_SESSION')
                    },
                    type: 'GET',
                    dataType: "JSON",
                    success: function(res) {

                        if(res.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                            .then (function() {
                                load_table();
                            });

                        } else {

                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal!',
                                text: res.message
                            });

                        }

                    }
                });

            }
        })
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $('#upload').on('change', function () {
            readURL(input);
        });
    });

    /*  ==========================================
        SHOW UPLOADED IMAGE NAME
    * ========================================== */
    var input = document.getElementById( 'upload' );
    var infoArea = document.getElementById( 'upload-label' );

    input.addEventListener( 'change', showFileName );
    function showFileName( event ) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = 'File name: ' + fileName;
    }

    function readURL2(input2) {
        if (input2.files && input2.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageResult2')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input2.files[0]);
        }
    }

    $(function () {
        $('#upload2').on('change', function () {
            readURL2(input2);
        });
    });

    var input2 = document.getElementById( 'upload2' );
    var infoArea2 = document.getElementById( 'upload-label2' );

    input2.addEventListener( 'change', showFileName2 );
    function showFileName2( event2 ) {
        var input2 = event2.srcElement;
        var fileName2 = input2.files[0].name;
        infoArea2.textContent = 'File name: ' + fileName2;
    }


})
