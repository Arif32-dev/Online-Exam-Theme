jQuery(document).ready(function($) {
    class Profile {
        constructor() {
            this.user_form = $('#oe_user_profile');
            this.events();
        }
        events() {
            this.user_form.on('submit', this.handle_submit)
        }
        handle_submit(e) {
            e.preventDefault();
            let form_data = $(this).serialize();
            $.ajax({
                url: files.profile,
                data: form_data,
                method: 'post',
                success: res => {
                    if (res == 'success') {
                        $('.warning_text').addClass('success_text');
                        $('.warning_text').html('Updated Successfully').hide().slideDown();
                    } else {
                        $('.warning_text').html(res).hide().slideDown();
                    }
                },
                error: err => {
                    alert('Something went wrong')
                }
            })
        }
    }
    new Profile();
})