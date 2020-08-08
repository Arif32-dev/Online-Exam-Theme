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
            var countDownDate = new Date("Aug 9, 2020 15:37:25").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById("oe_timer").innerHTML = days + "d " + hours + "h " +
                    minutes + "m " + seconds + "s ";

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("oe_timer").innerHTML = "EXPIRED";
                }
            }, 1000);
        }
    }
    new OE_timer();
})