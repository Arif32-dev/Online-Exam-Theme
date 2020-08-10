jQuery(document).ready(function($) {
    class OE_timer {
        constructor() {
            this.events();
        }
        events() {
            this.timer();
            $(window).scroll(this.set_timer_fixed);
        }
        set_timer_fixed() {
            var scrollPos = $(document).scrollTop();
            if (window.outerWidth >= 540) {
                if (scrollPos > 132) {
                    $('#oe_timer').addClass('fixed')
                } else {
                    $('#oe_timer').removeClass('fixed')
                }
            } else {
                if (scrollPos > 254) {
                    $('#oe_timer').addClass('fixed')
                } else {
                    $('#oe_timer').removeClass('fixed')
                }
            }
        }
        timer() {
            var date_string = $('#oe_timer').attr('data-remaining_time');
            var countDownDate = new Date(date_string).getTime();
            // Update the count down every 1 second
            var qus_timer = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var min = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var sec = Math.floor((distance % (1000 * 60)) / 1000);
                var print_day = " " + days + "day";
                var print_hour = " " + hours + "hour";
                var print_min = " " + min + "min";
                var print_sec = "" + sec + "s";
                $('#oe_timer').html(`
                    ${days != 0 ? print_day : ""} ${hours != 0 ? print_hour : ""} ${min != 0 ? print_min : ''} ${print_sec}
                `)
                if (min < 3 && hours < 1) {
                    $('#oe_timer').addClass('timer_warning');
                } else {
                    $('#oe_timer').removeClass('timer_warning');
                }
                /* if time is over then show time off msg and clear all qustion */
                if (distance < 0) {
                    clearInterval(qus_timer);
                    $('.qus_card').slideUp();
                    document.getElementById("oe_timer").innerHTML = "Time Off";

                    /* sending rest of the answer to database */
                    let final_data = [];
                    let data = $('.oe_mcq').serializeArray();
                    /* breaking the array into chunk if array will consists of 2 elements key and value */
                    if (data.length) {
                        while (data.length > 0) {
                            chunk = data.splice(0, 2)
                            final_data.push(chunk)
                        }
                        console.log(final_data);
                        $.ajax({
                            type: "post",
                            url: files.bulk_answer,
                            data: {
                                final_data
                            },
                            success: function(res) {
                                console.log(res)
                            },
                            error: err => {
                                alert("Something went wrong");
                            }
                        });
                    }

                    let view_result = `
                    <section class="result-sec">
                            <a href="${files.exam_result}">View Result</a>
                    </section>
                    `;
                    $(view_result).insertAfter('.qus-container');
                }
            }, 1000);
        }
    }
    new OE_timer();
})