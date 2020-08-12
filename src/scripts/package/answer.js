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
                    console.log(JSON.parse(res));
                    if (JSON.parse(res).res_text == 'error' || res == 'failed') {
                        alert('Something went wrong');
                    }
                    if (JSON.parse(res).res_text == 'success') {
                        $(e.currentTarget).removeClass('oe_mcq');
                        $(e.currentTarget).parent().slideUp().hide();
                    }
                    if (JSON.parse(res).res_text == 'exam_folder_update') {
                        $(e.currentTarget).removeClass('oe_mcq');
                        $(e.currentTarget).parent().slideUp().hide();
                        let view_result = `
                            <section class="result-sec">
                                    <a href="${files.exam_result}?exam_folder_id=${JSON.parse(res).exam_folder_id}">View Result</a>
                            </section>
                        `;
                        $(view_result).insertAfter('.qus-container');
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