$(document).ready(function(){
$(window).load(function() {prettyPrint()})


/********************************* BEGIN TOOLTIP FUNCTION *********************************/
$('.tooltips').tooltip({
  selector: "[data-toggle=tooltip]",
  container: "body"
})
$('.popovers').popover({
  selector: "[data-toggle=popover]",
  container: "body"
})
/********************************* END TOOLTIP FUNCTION *********************************/



/********************************* BEGIN MAGNIFIC POPUP *********************************/
$(function () {
	$('.magnific-popup-wrap').each(function() {
		$(this).magnificPopup({
			delegate: 'a.zooming',
			type: 'image',
			removalDelay: 300,
			mainClass: 'mfp-fade',
			gallery: {
			  enabled:true
			}
		});
	}); 
}); 

$(function () {
	$('.inline-popups').magnificPopup({
	  delegate: 'a',
	  removalDelay: 500,
	  callbacks: {
		beforeOpen: function() {
		   this.st.mainClass = this.st.el.attr('data-effect');
		}
	  },
	  midClick: true
	});
});
/********************************* END MAGNIFIC POPUP *********************************/


/********************************* BEGIN OWL CAROUSEL *********************************/
$(function () {
  $("#owl-lazy-load").owlCarousel({
	items : 4,
	lazyLoad : true,
	navigation : true
  });
});

$(function () {
  $("#owl-lazy-load-autoplay").owlCarousel({
	autoPlay: 3000,
	items : 4,
	lazyLoad : true
  });
});

$(function () {
  $("#owl-lazy-load-gallery").owlCarousel({
	items : 4,
	lazyLoad : true,
	navigation : true
  });
});

$(function () {
  var Owltime = 7;
  var $progressBar,
      $bar, 
      $elem, 
      isPause, 
      tick,
      percentTime;
 
    $("#owl-single-progress-bar").owlCarousel({
      slideSpeed : 500,
      paginationSpeed : 500,
      singleItem : true,
      afterInit : progressBar,
      afterMove : moved,
      startDragging : pauseOnDragging
    });
 
    function progressBar(elem){
      $elem = elem;
      buildProgressBar();
      start();
    }
 
    function buildProgressBar(){
      $progressBar = $("<div>",{
        id:"OwlprogressBar"
      });
      $bar = $("<div>",{
        id:"Owlbar"
      });
      $progressBar.append($bar).prependTo($elem);
    }
 
    function start() {
      percentTime = 0;
      isPause = false;
      tick = setInterval(interval, 10);
    };
 
    function interval() {
      if(isPause === false){
        percentTime += 1 / Owltime;
        $bar.css({
           width: percentTime+"%"
         });
        if(percentTime >= 100){
          $elem.trigger('owl.next')
        }
      }
    }
 
    function pauseOnDragging(){
      isPause = true;
    }
 
    function moved(){
      clearTimeout(tick);
      start();
    }
});
/********************************* END OWL CAROUSEL *********************************/
	
});