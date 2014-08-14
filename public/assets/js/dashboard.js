$(document).ready(function() {

        /** BUTTON SHOW / HIDDEN SIDEBAR **/
        $(".btn-sidebar-collapse").click(function() {
            $(".sidebar").toggleClass("collapse-sidebar");
            $(".content-page").toggleClass("collapse-content");
        });


        /** NICE SCROLL FUNCTION FOR SIDEBAR MENU **/
        if ($(window).width() > 767) {
            $(".sidebar").addClass("sidebar-nicescroller");
        }
        else {
            $(".sidebar").removeClass("sidebar-nicescroller");
        }

        $(".sidebar-nicescroller").niceScroll({
            cursorcolor: "#000",
            cursorborder: "0px solid #fff",
            cursorborderradius: "0px",
            cursorwidth: "5px"
        });
        $(".sidebar-nicescroller").getNiceScroll().resize();


        /** SIDEBAR MENU **/
        $('.sidebar ul.stacked-menu li a').click(function() {
            $('.sidebar li').removeClass('active');
            $(this).closest('li').addClass('active');
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('fast');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('.sidebar ul.stacked-menu ul:visible').slideUp('fast');
                checkElement.slideDown('fast');
            }
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;
            }
        });
    });