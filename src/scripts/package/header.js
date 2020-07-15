jQuery(document).ready(function($) {
    class header {
        constructor() {
            this.hamburger = $('.hamburger > span');
            this.mobile_link = $('.mobile_link');
            this.header = $('header');
            this.events()
        }
        events() {
            this.hamburger.on('click', this.toggle_link.bind(this));
        }
        toggle_link(e) {
            this.mobile_link.toggleClass('link-active')
        }
    }
    new header();
});