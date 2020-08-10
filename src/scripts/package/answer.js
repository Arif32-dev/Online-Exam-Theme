jQuery(document).ready(function($) {
    class OE_answer {
        constructor() {
            this.answer_form = $('.oe_mcq');
            this.events();
        }
        events() {
            this.answer_form.on('submit', this.handle_submit)
        }
        handle_submit(e) {
            e.preventDefault();
            const form_data = $(this).serialize();
            $.ajax({
                url: files.answer,
                data: form_data,
                method: 'post',
                success: res => {
                    console.log(res);
                    if (res == 'error' || res == 'failed') {
                        alert('Something went wrong');
                    }
                    if (res == 'success') {
                        $(e.currentTarget).removeClass('oe_mcq');
                        $(e.currentTarget).parent().slideUp().hide();
                    }
                },
                error: (err) => {
                    alert('Something went wrong')
                }
            })
        }
    }
    new OE_answer();
})