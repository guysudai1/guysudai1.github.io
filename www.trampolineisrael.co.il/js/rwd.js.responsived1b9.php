var rwdDone=0;
var rwdBack=0;
var rwdIframeEffectGalleryDone=0;
var rwdTablesDone=0;
var rwdSize;
var scriptsLoaded=0;
var catType=12;
var galType="0";
var fixedToolbarOpen=false;
var loaded=0;
var mobile_logo="";
var mobile_mainpic_photo="7DB7731E-DBB5-8DF4-0543-D0D1C81DE701.png";
var productPage="";
var media_url="/gallery";
    media_url="//cdn.exiteme.com/exitetogo/www.trampolineisrael.co.il/gallery";
     
rwdSize=jQuery(window).width();

if (rwdSize<680) {
    //jQuery('iframe').not('[id^="iframe_gallery"]').not('[id^="iframe_shortContent"]').not('[id^="iframe_form"]').not('[id^="search_content"]').addClass("hideElement");
    jQuery('iframe[src^="//www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="https://www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="https://www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="//player.vimeo"]').removeClass("hideElement");
    jQuery('iframe[src^="https://player.vimeo"], iframe[src^="https://player.vimeo"]').removeClass("hideElement");
    jQuery('iframe[src^="https://w.soundcloud"]').removeClass("hideElement");
    //if (jQuery('#headerMaster_marginizer').length>0) jQuery('#headerMaster_marginizer').css("min-height",jQuery(".masterHeader_wrapper").height()+"px");
    
}


var contact_open=0;
var lastScrollTop = 0;
var footerHidden=0;
 if (!rwdDone && rwdSize<680) {
       if (jQuery(".mobileLogoMasterHeader").length>0) {
            jQuery(".mobileLogoMasterHeader").before(jQuery(".topHeaderLogo"));
            jQuery(".topHeaderLogo").before(jQuery(".dl-menuwrapper"));
        }
        else  jQuery(".topHeaderLogo").before(jQuery(".dl-menuwrapper"));
 }

function isScrolledIntoView_exite(elem)
{
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
      && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
}
function loadFixedToolbarContent(type) {
    contact_open=0;
    jQuery(".outer").load("/LoadAjaxContent.php?type="+type);
    if (type=="contact") contact_open=1;
}
function loadScripts2Dom(sName) {
    var scriptName=sName;
    (function() {
            var st = document.createElement('script'); st.type = 'text/javascript'; st.async = true;
            st.src=scriptName;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(st, s);
            
        })();
    scriptsLoaded=1;
};    

function toggleFixedToolbar(type) {
    if (type=="phone" || type=="exite_topTop" || type=="shopping_cart" || type=="wu") {
        if (type=="phone") {
            loadFixedToolbarContent("countCalls");
            if (typeof(ga)=="undefined") _gaq.push(['_trackEvent', 'Calls From Mobile', 'Call', 'Clicked on Call']);
            else ga('send','event','Calls From Mobile', 'Call', 'Clicked on Call');
        }
        if (type=="exite_topTop") jQuery.smoothScroll({scrollTarget: '#TopHead'});
        return;
    
    }
    //contact_open=0;
    if (fixedToolbarOpen) {
        jQuery("html").removeClass("modal-noscroll");
        jQuery(".fixed_footer.open").removeClass("open");
        jQuery(".fixed_footer .inner .icon").removeClass("opened");
        fixedToolbarOpen=false;
        jQuery(".fixed_footer .inner .icon_close").hide();
    }
    else {
        jQuery("html").addClass("modal-noscroll");
        jQuery(".fixed_footer").addClass("open");
        jQuery(".fixed_footer .inner #"+type).addClass("opened");
       
        if (loaded!=type) {
            if (contact_open==0 || type!="contact") {
                jQuery('.outer').html('<i class="fa fa-refresh fa-spin fa-2x" style="margin-top:40%"></i>');
                window.setTimeout('loadFixedToolbarContent("'+type+'");',1400);
                
            }
            loaded=type;
        }
        fixedToolbarOpen=true;
        jQuery(".fixed_footer .inner .icon_close").show();
    }
     
}
function BindFixedFooter() {
    jQuery(".fixed_footer .inner>div").click(function() {
        toggleFixedToolbar(jQuery(this).attr('id'));
        });
        jQuery(window).scroll(function(event){
            var st = jQuery(this).scrollTop();
            if (st > lastScrollTop && st>150){
                 if (footerHidden==0) {
                    jQuery(".fixed_footer").addClass("hiddenFooter");
                    jQuery("#mini_cart").addClass("go_down");
                    footerHidden=1;
               }
            } else {
               if (footerHidden) {
                    jQuery(".fixed_footer").removeClass("hiddenFooter");
                    jQuery("#mini_cart").removeClass("go_down");
                    footerHidden=0;
               }
            }
            lastScrollTop = st;
         });

    
}
function rwdGlobal() {
    if (scriptsLoaded==0) {
      //  loadScripts2Dom('/js/jquery.lazy.min.js');
        
    }
    if (jQuery('iframe[id^="iframe_form"]').length>0) {
        jQuery('iframe[id^="iframe_form"]').each(function() {jQuery(this).attr("src",jQuery(this).attr("src").replace("horizontal=1","mob=1"));});
    }
    if (!rwdIframeEffectGalleryDone) {
        media_url=media_url.replace("//cdn.exiteme.com/exitetogo","//res.cloudinary.com/exite/image/upload/f_auto/exitetogo");
        if (mobile_logo) jQuery(".topHeaderLogo img").attr('src',media_url+'/sitepics/'+mobile_logo);
        if (mobile_mainpic_photo && jQuery(".mobile_mainpic_homepage").length>0) jQuery(".mobile_mainpic_homepage").html('<img src="'+media_url+'/sitepics/'+mobile_mainpic_photo+'" border="0" />');
        else {
            if (jQuery(".staticHeadPic").length>0) jQuery(".mobile_mainpic_homepage").html('<img src='+jQuery(".staticHeadPic").attr("data-src-main-mobile")+' border="0" />');
        }
      
        rwdIframeEffectGalleryDone=1;
    }
}

function setGalleryLightBox() {
            if (jQuery("a.photo_gallery").length>0) {
                jQuery("a.photo_gallery").addClass("enlarge");
                jQuery("a.photo_gallery").unbind("click");
                jQuery("a.photo_gallery").removeClass("photo_gallery");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true,backButtonHideEnabled:false });
            }
            if (jQuery("a.fancybox").length>0) {
               jQuery(".photoWrapper a.fancybox").addClass("enlarge");
                jQuery("a.fancybox").unbind("click");
                jQuery("a.fancybox").removeAttr("data-fancybox-group");
                jQuery("a.fancybox").removeClass("fancybox");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true, enableKeyboard: true,backButtonHideEnabled:false });
            }
           if (jQuery("a.fancybox-thumbs").length>0) {
                jQuery("a.fancybox-thumbs").addClass("enlarge");
                jQuery("a.fancybox-thumbs").unbind("click");
                jQuery("a.fancybox-thumbs").removeAttr("data-fancybox-group");
                jQuery("a.fancybox-thumbs").removeClass("fancybox-thumbs");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true,backButtonHideEnabled:false });
            }
}


function rwdTables() {
    if (rwdTablesDone==0) {
            //jQuery(".mainContentText table, .middleContentText table").addClass("responsive");
            jQuery(".middleContentText table").not(".mobileview").wrap('<div class="tablesWrapper">');
            //jQuery(".mainContentText table").wrap('<div class="tablesWrapper">');
              if (jQuery(".tablesWrapper").length>0) {
                if (isScrolledIntoView_exite(jQuery(".tablesWrapper"))) jQuery(".tablesWrapper table").addClass("exite_scroll_animate");
              }
            rwdTablesDone=1;
    }
}
function desktopShortContent() {
    rwdDone=0;
    rwdBack=1;
}

function rwdShopProductPage() {
		jQuery(".oneProduct .right_part").before(jQuery(".left_part"));
}

function showBubble() {
     jQuery(".eXite.bubble").addClass("open");
     jQuery(".eXite.bubble").click(function() {
        jQuery(".eXiteBubbleOverlay").addClass("open");
     })
}

//if (rwdSize<680) rwdGlobal();
jQuery(document).ready(function() {
     if (rwdSize<680) {
            
            BindFixedFooter();
            rwdGlobal();
            rwdTables();
           
            
            if (productPage!="") rwdShopProductPage();
            //loadFixedToolbarContent('contact');
      }
});

var w_width = jQuery(window).width(), w_height = jQuery(window).height();
jQuery(window).resize(function() {
        rwdSize=jQuery(this).width();
        if (rwdSize<680 && rwdSize!=w_width) {
            rwdGlobal();
            //rwdTables();
            
           
        }
        else {
            if (rwdDone==1 && rwdSize!=w_width) {
                 desktopShortContent();
            }
        }
});