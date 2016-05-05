/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function ($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
    var Roots = {
        // All pages
        common: {
            init: function () {
                var $slides = $('#slides');
                if($slides.length){
                    var $tr = $slides.find('tr');
                    rotateTimer = timer(function(){
                        moveSlider($slides,$tr);
                    },2500);

                    $slides.hover(
                        function(){
                            isHovered = true;
                            rotateTimer.pause();
                        },
                        function(){
                            isHovered = false;
                            rotateTimer.start();
                        }
                    );
                }
            }
        },
        // Home page
        home: {
            init: function () {
                // JavaScript to be fired on the home page
            }
        },
        // About us page, note the change from about-us to about_us.
        about_us: {
            init: function () {
                // JavaScript to be fired on the about us page
            }
        }
    };

    var isHovered = false;
    var rotateTimer;

    var timer = function(callback, delay) {
        var id;
        var started;
        var remaining = delay;
        var running = false;

        this.start = function() {
            running = true;
            started = new Date();
            id = setTimeout(callback, remaining);
        };

        this.pause = function() {
            running = false;
            clearTimeout(id);
            remaining -= new Date() - started;
        };

        this.getTimeLeft = function() {
            if (running) {
                this.pause();
                this.start();
            }

            return remaining;
        };

        this.isActive = function() {
            return running;
        };

        this.start();

        return this;
    };

    var moveSlider = function($slides,$tr){
        var $logo = $slides.find('td').first();
        $slides.stop().animate({'marginLeft':-($logo.width() + 60) +'px'},{
            duration: 500,
            complete: function(){
                $logo.appendTo($tr);
                $slides.css('marginLeft',0);

                rotateTimer.pause();
                rotateTimer = timer(function(){
                    moveSlider($slides,$tr);
                },2500);
            }
        });
    };

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var namespace = Roots;
            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            UTIL.fire('common');

            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
            });
        }
    };

    $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
