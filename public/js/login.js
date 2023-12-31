$(document).ready(function() {

    $('.view-password').click(function() {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    });

    $(document).on('click', '.btn-login', function() {
        let link_api = $("meta[name='link-api']").attr("link");
        let email = $('input#email').val();
        let password = $('input#password').val();

        if(email == "" || password == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Catatan!',
                text: 'Email atau password wajib diisi'
            });
        } else {

            $.ajax({
                url: link_api,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    "email": email,
                    "password": password,
                },
                success: function(res) {

                    if(res.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: res.message,
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        .then (function() {
                            set_cookie('ALD_SESSION',res.remember_token)
                            window.location.href = res.redirect;
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal!',
                            text: res.message
                        });
                    }

                }
            })

        }

    })

})

