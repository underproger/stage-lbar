$(document).ready(function(){
    $('.slimmenu .level1.active').removeClass('active');
    $('.slimmenu .level1').each((i, el) => {
        if($(el).find('a').prop('href') == location.href) {
            $(el).addClass('active');
        }
    })
    if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
     console.log('this is a touch device');
    } else {
     document.body.classList.add('no-touch');
    }
    
    // Map google
//     $('.overlay-map').click(function() {
// 	   $(this).remove();
// 	});
     
    // Table-responsive
    $('table').resTables();
     
    // Navigation
    $('.slimmenu').slimmenu({
        resizeWidth: '1200'
    });
    
    //Autoheight
    $('.box').AutoHeight()
    
    // Jacor
    $('a[href^="#"], *[data-href^="#"]').on('click', function(e){
        e.preventDefault();
        var t = 1000;
        var d = $(this).attr('data-href') ? $(this).attr('data-href') : $(this).attr('href');
        $('html,body').stop().animate({ scrollTop: $(d).offset().top }, t);
    });
    
    // Modal forms subject
    $(".form-modal-overlay").css({backgroundColor: 'rgba(0,0,0,.9)'});
    $(function () { // ??? ?a??? ?o??? ?a?????? ???a????
        $('.btn-mobal').click(function (event) { // ?o??? ???? ?o ?????? ? class="modal"
            event.preventDefault(); // ??????a?? ??a??a????? ?o?? ???????a
            if ($(this).next('.form-modal-overlay').size()) {
                var form_modal_overlay = $(this).next('.form-modal-overlay');
            } else {
                var form_modal_overlay = $('.wrapper .form-modal-overlay');
            }
            form_modal_overlay.fadeIn(400, // ??a?a?a ??a??o ?o?a???a?? ?????? ?o??o???
                function () { // ?o??? ???o?????? ??????????? a???a???
                    $('.form-modal-body').css('display', 'block') // ????a?? ? ?o?a???o?o o??a display: none;
                        .animate({opacity: 1, top: '50%'}, 300); // ??a??o ????a????? ??o??a??o??? o??o???????o ?o ?????a???? ????
                        let width = form_modal_overlay.find('form').width();
                        form_modal_overlay.find('.iti__country-list').css('width', width);
                });
        });
        /* ?a?????? ?o?a???o?o o??a, ??? ???a?? ?o ?? ?a?o? ?o ? o??a??o? ?o????? */
        $('.modal-close,.form-modal-overlay').click(function (e) { // ?o??? ???? ?o ???????? ??? ?o??o???
            if(!$(e.target).hasClass('ic-close modal-close') && ($(e.target).hasClass('form-modal-body') || $(e.target).parents('.form-modal-body').length > 0)) return;
            $('.form-modal-body').animate({opacity: 0, top: '0'}, 300, // ??a??o ?????? ??o??a??o??? ?a 0 ? o??o???????o ????a?? o??o ?????
                function () { // ?o??? a???a???
                    $(this).css('display', 'none'); // ???a?? ??? display: none;
                    $('.form-modal-overlay').fadeOut(400); // ?????a?? ?o??o???
                }
            );
        });
    });
    // END MODAL FORM
    
    
    // Accordion
    var acc = document.getElementsByClassName("accordion-bar");
    var i;
    
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight){
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      });
    }
    
    // Open panel menu
    function resize_menu(){
        var mql1200 = window.matchMedia("screen and (min-width: 1200px)");
    	if(!mql1200.matches){
                jQuery(".tel-append").prependTo(".cd-panel-tel");
    	}
        else {
                jQuery(".tel-append").prependTo(".colum-header-tel");
        }
    }

    $(window).resize(function(){
        resize_menu();
    });
    $(window).resize();
    $(window ).load(function() {
    $(window).resize();
    });
    
    
    
   //slider Portfolio
   
    $('.portfolio-slider').slick({
        infinite: true,
  speed: 300,
  slidesToShow: 1,
  centerMode: true,
  variableWidth: true,
        arrows: true,
        appendArrows: $('.arrow-wrapper-slider-bl3')
    });
    

 
});

/*GOOGLE MAP*/
// function initMap() {
//   //??????????????: ???????, ?????? ? ??????????? ??????????
//   var latitude = 50.453578,
//     longitude = 30.479942,
//     map_zoom = 17;
//   //????? ?? ?????? ? ????????
//   var marker_url = '/images/design/map-marker.png';

//   //????? ??? ????????? ?? ?????
//   var style = [
//     { featureType: "all", elementType: "geometry", stylers: [{ visibility: "on" }] },

//     // ???????????? https://developers.google.com/maps/documentation/javascript/style-reference?hl=ru
//     //https://mapstyle.withgoogle.com/
//   ];

//   //???????? ????? ?? ????? 
//   var map_options = {
//     center: new google.maps.LatLng(latitude, longitude),
//     zoom: map_zoom,
//     panControl: false,
//     //zoomControl: false,
//     mapTypeControl: false,
//     streetViewControl: false,
//     fullscreenControl: true,
//     mapTypeId: google.maps.MapTypeId.ROADMAP,
//     scrollwheel: false,
//     styles: style
//   }
//   //????????????? ?????
//   var map = new google.maps.Map(document.getElementById('google-container'), map_options);
//   //????????? ???? ?????? ??????????????? ?? ????? (???? ??????)      
//   var marker = new google.maps.Marker({
//     position: new google.maps.LatLng(latitude, longitude),
//     map: map,
//     title: 'LBar Studio',
//     visible: true,
//     icon: marker_url
//   });
// }

/*AjaxForm*/

var AjaxForm={initialize:function(e){jQuery().ajaxForm||document.write('<script src="'+e.assetsUrl+'js/lib/jquery.form.min.js"></script>'),jQuery().jGrowl||document.write('<script src="'+e.assetsUrl+'js/lib/jquery.jgrowl.min.js"></script>'),$(document).ready(function(){$.jGrowl.defaults.closerTemplate="<div>[ "+e.closeMessage+" ]</div>"}),$(document).off("submit",e.formSelector).on("submit",e.formSelector,function(r){return $(this).ajaxSubmit({dataType:"json",data:{pageId:e.pageId},url:e.actionUrl,beforeSerialize:function(e){e.find(":submit").each(function(){e.find('input[type="hidden"][name="'+$(this).attr("name")+'"]').length||$(e).append($('<input type="hidden">').attr({name:$(this).attr("name"),value:$(this).attr("value")}))})},beforeSubmit:function(e,r){return"undefined"!=typeof afValidated&&0==afValidated?!1:(r.find(".error").html(""),r.find(".error").removeClass("error"),r.find("input,textarea,select,button").attr("disabled",!0),!0)},success:function(e,r,t,s){if(s.find("input,textarea,select,button").attr("disabled",!1),e.form=s,$(document).trigger("af_complete",e),e.success)AjaxForm.Message.success(e.message),s.find(".error").removeClass("error"),s[0].reset(),"undefined"!=typeof grecaptcha&&grecaptcha.reset();else if(AjaxForm.Message.error(e.message),e.data){var a,o,n;for(a in e.data)e.data.hasOwnProperty(a)&&(n||(s.find('[name="'+a+'"]').focus(),n=!0),o=e.data[a],s.find(".error_"+a).html(o).addClass("error"),s.find('[name="'+a+'"]').addClass("error"))}}}),r.preventDefault(),!1}),$(document).on("keypress change",".error",function(){var e=$(this).attr("name");$(this).removeClass("error"),$(".error_"+e).html("").removeClass("error")}),$(document).on("reset",e.formSelector,function(){$(this).find(".error").html(""),AjaxForm.Message.close()})}};AjaxForm.Message={success:function(e,r){e&&(r||(r=!1),$.jGrowl(e,{theme:"af-message-success",sticky: true}))},error:function(e,r){e&&(r||(r=!1),$.jGrowl(e,{theme:"af-message-error",sticky:r}))},info:function(e,r){e&&(r||(r=!1),$.jGrowl(e,{theme:"af-message-info",sticky:r}))},close:function(){$.jGrowl("close")}};

/*easycomm*/
var easyComm={initialize:function(){jQuery().ajaxForm||easyComm.notice.error("Can`t find jQuery ajaxForm plugin!"),easyComm.rating.initialize(),jQuery(document).on("submit","form.ec-form",function(e){return easyComm.message.send(this),e.preventDefault(),!1})},message:{send:function(e){jQuery(e).ajaxSubmit({data:{action:"message/create"},url:easyCommConfig.actionUrl,form:e,dataType:"json",beforeSubmit:function(){return jQuery(e).find('input[type="submit"]').attr("disabled","disabled"),jQuery(e).find(".has-error").removeClass("has-error"),jQuery(e).find(".ec-error").text("").hide(),!0},success:function(t){var a=jQuery(e).data("fid");jQuery(e).find('input[type="submit"]').removeAttr("disabled"),t.success?(jQuery(e)[0].reset(),"string"==typeof t.data?(jQuery("#ec-form-success-"+a).html(t.data),jQuery(e).hide()):easyComm.notice.show(t.message)):t.data&&t.data.length?jQuery.each(t.data,function(t,r){jQuery(e).find('[name="'+r.field+'"]').closest(".form-group").addClass("has-error"),jQuery(e).find("#ec-"+r.field+"-error-"+a).text(r.message).show().closest(".form-group").addClass("has-error")}):easyComm.notice.error(t.message)},error:function(){jQuery(e).find('input[type="submit"]').removeAttr("disabled"),easyComm.notice.error("Submit error")}})}},rating:{initialize:function(){var e=jQuery(".ec-rating").find(".ec-rating-stars>span");e.on("touchend click",function(e){var t=jQuery(this).data("description");jQuery(this).parent().parent().find(".ec-rating-description").html(t).data("old-text",t),jQuery(this).parent().children().removeClass("active active2 active-disabled"),jQuery(this).prevAll().addClass("active"),jQuery(this).addClass("active");var a=jQuery(this).closest(".ec-rating").data("storage-id");jQuery("#"+a).val(jQuery(this).data("rating"))}),e.hover(function(){var e=jQuery(this).parent().parent().find(".ec-rating-description");e.data("old-text",e.html()),e.html(jQuery(this).data("description")),jQuery(this).addClass("active2").removeClass("active-disabled"),jQuery(this).prevAll().addClass("active2").removeClass("active-disabled"),jQuery(this).nextAll().removeClass("active2").addClass("active-disabled")},function(){var e=jQuery(this).parent().parent().find(".ec-rating-description");e.html(e.data("old-text")),jQuery(this).parent().children().removeClass("active2 active-disabled")})}},notice:{error:function(e){alert(e)},show:function(e){alert(e)}}};jQuery(document).ready(function(){easyComm.initialize()});var easyCommReCaptchaCallback=function(){"undefined"!=typeof grecaptcha?$(".ec-captcha").each(function(e){grecaptcha.render($(this).attr("id"),{sitekey:easyCommConfig.reCaptchaSiteKey})}):easyComm.notice.error("grecaptcha is not defined!")};

/*ms2Gallery*/
var ms2Gallery={initialize:function(selector){var galleries=$(selector);if(!galleries.length){return false;}if($(document).find('.fotorama').length){this.fotorama();}galleries.each(function(){var gallery=$(this);if(gallery.hasClass('fotorama')){return;}var thumbnails=gallery.find('.thumbnail');thumbnails.on('click',function(e){e.preventDefault();thumbnails.removeClass('active');var thumbnail=$(this);thumbnail.addClass('active');var main=gallery.find('#mainImage, .mainImage');main.attr('src',thumbnail.attr('href'));main.parent().attr('href',thumbnail.data('image'));var image=$(this).find('img');if(image.length){main.attr('title',image[0].title).attr('alt',image[0].alt);}return false;});gallery.find('.thumbnail:first').click();});return true;},fotorama:function(){$('<link/>',{rel:'stylesheet',type:'text/css',href:ms2GalleryConfig.cssUrl+'lib/fotorama.min.css',}).appendTo('head');$('<script/>',{type:'text/javascript',src:ms2GalleryConfig.jsUrl+'lib/fotorama.min.js',}).appendTo('head');}};$(document).ready(function(){ms2Gallery.initialize('#msGallery, .ms2Gallery');});
