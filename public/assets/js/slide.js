$(document).ready(function() {

  scroll(20000 - 5000);

});


function scroll(tti) {

  $(".summer").delay(0).animate({
    opacity: '1',
  }, 800, 'easeOutCirc').delay(19000 - 5000);
  $(".imm8").delay(0).animate({
    opacity: '1',
  }).delay(19000 - 5000).animate({
    opacity: '0',
  }, 800).fadeOut();
  //$( ".map" ) .delay(600 ) .animate({  "button": "+=20px" , opacity:'1',  }, 500 , 'easeOutCirc' ) .delay( 6000 ).animate({  opacity:'0',  }, 500 ) .fadeOut();

  $(".phone").delay(800 - 800).animate({
    "left": "+=150px",
    opacity: '1',
  }, 500, 'easeOutCirc').delay(14000 - 9000 + 800).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".v-icon1").delay(1000).animate({
    "top": "-=50px",
    opacity: '1',
  }, 600, 'easeOutBack').delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".v-icon2").delay(1200).animate({
    "top": "-=50px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".v-icon3").delay(1400).animate({
    "top": "-=50px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".v-icon4").delay(1600).animate({
    "top": "-=50px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".map2").delay(9000 - 9000).animate({
    "top": "-=30px",
    opacity: '1',
  }, 500, 'easeOutBounce').delay(6000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".back").delay(9000 - 9000).animate({
    opacity: '1',
  }, 500 - 500).animate({
    "left": "+=20px",
  }, 0).animate({
    "left": "-=20px",
  }, 500).delay(6000).animate({
    opacity: '0',
  }, 500).fadeOut();
  //-------------------------------------------------------------//
  $(".m-text").delay(11000 - 9000).animate({
    "top": "-=30px",
    opacity: '1',
  }, 500, 'easeOutElastic').delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".line").delay(12000 - 9000).animate({
    "left": "-=50px",
    opacity: '1',
  }, 500, 'easeInOutQuad').delay(4000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".point").delay(14000 - 9000).animate({
    "top": "-=50px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(3000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".bg-2-airplane").delay(16000 - 9000).animate({
    opacity: '1',
  }, 500, 'easeOutBack').delay(1000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".bg-2-hand").delay(16500 - 9000).animate({
    "top": "-=392px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(1000).animate({
    opacity: '0',
  }, 500).fadeOut();
  $(".phone2").delay(16700 - 9000).animate({
    opacity: '1',
  }, 500).delay(7000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".p-txt").delay(17500 - 9000).animate({
    "top": "-=30px",
    opacity: '1',
  }, 500, 'easeOutElastic').delay(6000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".num").delay(17500 - 9000).animate({
    opacity: '1'
  }, 500).delay(5000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".suport").delay(18000 - 9000).animate({
    "left": "+=150px",
    opacity: '1'
  }, 500).delay(2000).animate({
    opacity: '1',
  }, 500).fadeOut();

  // ------------------------------------------------------------------------------------------------------------------------------------------------
  $(".slid1").delay(0).animate({
    opacity: '1',
  }, 800, 'easeOutCirc').delay(200);
  $(".imm1").delay(tti + 500).animate({
    "left": "-=50px",
    opacity: '1',
  }, 500, 'easeInOutQuad').delay(6000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".bg-4-bag").delay(tti + 800).animate({
    "top": "-=10px",
    opacity: '1',
  }, 500, 'easeOutBack').delay(19000 - 9000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".bg-4-hands").delay(tti + 1200).animate({
    opacity: '1',
    "left": "-=200px"
  }, 500).delay(35000).animate({
    "left": "+=200px",
    opacity: '0',
  }, 500).fadeOut();
  $(".bg-4-map").delay(tti + 1800).animate({
    "top": "-=30px",
    opacity: '1',
  }, 500, 'easeOutElastic').delay(19500 - 9000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".bg-4-text-1").delay(tti + 2300).animate({
    opacity: '1'
  }, 500).delay(19000 - 9000).animate({
    opacity: '0',
  }, 500).fadeOut();

  $(".bg-4-text-2").delay(tti + 2300).animate({
    "top": "+=30px",
    opacity: '1'
  }, 500).delay(11000 - 9000).animate({
    opacity: '1',
  }, 500).fadeOut();



  /**************************************************************************************************************************************************************************/


  $(".slid2").delay(tti + 6000).animate({
    opacity: '1',
  }, 800, 'easeOutCirc').delay(500);
  $(".imm2").delay(tti + 6100).animate({
    opacity: '1',
  }, 300).delay(3000);
  $(".man").delay(tti + 6400).animate({
    opacity: '1',
  }, 300).delay(3000);
  $(".tablet").delay(tti + 6600).animate({
    "left": "-=80px",
    opacity: '1',
  }, 500);
  $(".sms1").delay(tti + 6800).animate({
    "left": "-=10px",
    opacity: '1',
  }, 500);
  $(".sms2").delay(tti + 7000).animate({
    "left": "-=10px",
    opacity: '1',
  }, 500);
  $(".slid7").delay(tti + 15000).animate({
    opacity: '1'
  }, 800).delay(55555400);



}
