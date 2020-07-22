jQuery(document).ready(function($) {
    class Authentication {
        constructor() {
            this.login_form = $('#oe-login-form');
            this.reg_form = $('#oe-reg');
            this.events();
        }
        events() {
            this.login_form.on('submit', this.handle_submit)
            this.reg_form.on('submit', this.handle_submit)
        }
        handle_submit(e) {
            e.preventDefault();
            let form_data = $(this).serialize();
            $.ajax({
                url: files.authentication_page,
                data: form_data,
                method: 'post',
                success: res => {
                    console.log(res)
                    if (res == 'success') {
                        window.location.href = files.site_url;
                    } else {
                        if (res == 'user_registered') {
                            $(this).find('.input100').val('');
                            $('.oe-warning').addClass('oe-success');
                            $('.oe-warning').hide().slideDown().html('Registered successfully. Check your email :)');
                            $('.reg-btn').attr('disabled', false);
                        } else {
                            $('.oe-warning').removeClass('oe-success');
                            $('.oe-warning').hide().slideDown().html(res);
                            $('.reg-btn').attr('disabled', false);
                        }
                    }
                },
            })
            $('.reg-btn').attr('disabled', true);
        }
    }
    new Authentication();
})