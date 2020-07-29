jQuery(document).ready(function($) {
    class Contact_us {
        constructor() {
            this.contact_us = $('#oe-contact-us-form');
            this.events();
        }
        events() {
            this.contact_us.on('submit', this.handle_submit)
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
                    if (res == 'contact_us_success') {
                        $(this).find('.input').val('')
                        $('.sent-msg').hide().slideDown().html('Sent Messege Successfully');
                        $('.reg-btn').attr('disabled', false);
                    } else {
                        $('.sent-msg').addClass('error-msg');
                        $('.sent-msg').hide().slideDown().html(res);
                        $('.reg-btn').attr('disabled', false);
                    }
                },
                error: err => {
                    $('.sent-msg').addClass('error-msg');
                    $('.sent-msg').hide().slideDown().html("Something went wrong");
                    $('.reg-btn').attr('disabled', false);
                }
            })
            $('.reg-btn').attr('disabled', true);
        }
    }
    new Contact_us();
})