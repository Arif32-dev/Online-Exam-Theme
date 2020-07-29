jQuery(document).ready(function($) {
    class Comment {
        constructor() {
            this.comment_form = $('#oe-comment-form')
            this.events();
        }
        events() {
            this.comment_form.on('submit', this.handle_submit)
        }
        handle_submit(e) {
            let form_data = $(this).serialize();
            $.ajax({
                url: files.comment_file,
                data: form_data,
                method: 'post',
                success: res => {
                    console.log(res)
                },
                error: (err) => {
                    alert('Something went wrong');
                }
            })
        }
    }
    new Comment();
})