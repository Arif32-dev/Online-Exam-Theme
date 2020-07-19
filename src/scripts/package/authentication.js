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
            form_data += '&action=user_login';
            // console.log(form_data);
            $.ajax({
                url: files.authentication_page,
                data: form_data,
                method: 'post',
                success: res => {
                    if (res == 'success') {
                        window.location.href = files.site_url;
                    }
                    if (res == 'Incorrect Password' || res == 'Invalid username' || res == 'Invalid email') {
                        $('#oe-login-form > .oe-warning').hide().slideDown().html(res);
                    }
                }
            })
        }
    }
    new Authentication();
})