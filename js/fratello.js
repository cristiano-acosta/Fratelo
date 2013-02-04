/* =============================================================================
 Created by Cristiano Acosta. Date: 16/07/12.  Time: 11:35
 Jquery Efects for Theme Template EZ Comunicação
 ========================================================================== */
$(document).ready(function () {
  if ($.browser.webkit) {
      //alert( "this is webkit!" );
    //$('div#chromefix').css('height', '40px');
  }
  /*== Slides Responsiveis ==*/
  $(".rslides").responsiveSlides({
    auto:true, // Boolean: Animate automatically, true or false
    speed:2000, // Integer: Speed of the transition, in milliseconds
    timeout:4000, // Integer: Time between slide transitions, in milliseconds
    pager:false, // Boolean: Show pager, true or false
    nav:false, // Boolean: Show navigation, true or false
    random:false, // Boolean: Randomize the order of the slides, true or false
    pause:false, // Boolean: Pause on hover, true or false
    pauseControls:false, // Boolean: Pause when hovering controls, true or false
    prevText:"Previous", // String: Text for the "previous" button
    nextText:"Next", // String: Text for the "next" button
    maxwidth:"", // Integer: Max-width of the slideshow, in pixels
    controls:"", // Selector: Where controls should be appended to, default is after the 'ul'
    namespace:"rslides", // String: change the default namespace used
    before:function () {
    }, // Function: Before callback
    after:function () {
    }     // Function: After callback
  });
    /*== Slides Responsiveis ==*/
  $('#minicontact form input').focus(function () {
    $('label[for="' + $(this)[0].id + '"]').fadeOut();
  }).blur(function () {
      if ($(this).val() == '') {
        $('label[for="' + $(this)[0].id + '"]').fadeIn();
      }
    });
  $('#minicontact form textarea').focus(function () {
    $('label[for="' + $(this)[0].id + '"]').fadeOut();
  }).blur(function () {
      if ($(this).val() == '') {
        $('label[for="' + $(this)[0].id + '"]').fadeIn();
      }
    });
  $("div#mask").mouseover(function () {
	    $(this).find("img.change").attr("src", "http://ezcomunicacao.servehttp.com/fratellosole/wpsite/wp-content/themes/fratello.2.0.1/img/eventos/mask.opt.hover.png");
	  }).mouseout(function () {
	      $(this).find("img.change").attr("src", "http://ezcomunicacao.servehttp.com/fratellosole/wpsite/wp-content/themes/fratello.2.0.1/img/eventos/mask.opt.png");
	   });
	});
/*== Inicializar após imagens são carregadas ==*/
$(window).load(function () {
	/* index.php - loads first product in black bg  */
  //$('#myTab a:first').tab('show');
  var hash = window.location.hash;
  // do some validation on the hash here
  hash && $('#myTab a[href="' + hash + '"]').tab('show');
  $('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  /* index.php - loads first product in black bg  */
  //$('#myTab h3').corner("10px");

	$('div[data-id="nss-ad"]').hide();
	$('div.nss-admin-link').hide();


});

