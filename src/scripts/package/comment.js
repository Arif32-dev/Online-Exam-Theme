jQuery(document).ready(function($) {
    class Comment {
        constructor() {
            this.comment_sec = $('.comments_area');
            this.events();
        }
        events() {
            $(document).on('click', '#oe_load_more', this.load_more_comment.bind(this))
        }
        load_more_comment(e) {
            $.ajax({
                url: files.comment_file,
                data: {
                    offset: $(e.currentTarget).attr('data-offset'),
                    post_id: $(e.currentTarget).attr('data-post_id'),
                },
                method: 'post',
                success: res => {
                    this.comment_sec.html(res);
                },
                error: (err) => {
                    alert('Something went wrong');
                }
            })
        }
    }
    new Comment();
})