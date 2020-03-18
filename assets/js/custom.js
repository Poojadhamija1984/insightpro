$(function() {
   "use strict";

   // Init collapsible
   $(".collapsible").collapsible({
      accordion: true,
      onOpenStart: function() {
         // Removed open class first and add open at collapsible active
         $(".collapsible > li.open").removeClass("open");
         setTimeout(function() {
            $("#slide-out > li.active > a")
               .parent()
               .addClass("open");
         }, 10);
      }
   });

   // Add open class on init
   $("#slide-out > li.active > a")
      .parent()
      .addClass("open");

   // Open active menu for multi level
   if ($("li.active .collapsible-sub .collapsible").find("a.active").length > 0) {
      $("li.active .collapsible-sub .collapsible")
         .find("a.active")
         .closest("div.collapsible-body")
         .show();
      $("li.active .collapsible-sub .collapsible")
         .find("a.active")
         .closest("div.collapsible-body")
         .closest("li")
         .addClass("active");
   }

   // Auto Scroll menu to the active item
   var position;
   if (
      $(".sidenav-main li a.active")
         .parent("li.active")
         .parent("ul.collapsible-sub").length > 0
   ) {
      position = $(".sidenav-main li a.active")
         .parent("li.active")
         .parent("ul.collapsible-sub")
         .position();
   } else {
      position = $(".sidenav-main li a.active")
         .parent("li.active")
         .position();
   }
   setTimeout(function() {
      if (position !== undefined) {
         $(".sidenav-main ul")
            .stop()
            .animate({ scrollTop: position.top - 300 }, 300);
      }
   }, 300);

   // Collapsible navigation menu
   $(".nav-collapsible .navbar-toggler").click(function() {
      // Toggle navigation expan and collapse on radio click
      if ($(".sidenav-main").hasClass("nav-expanded") && !$(".sidenav-main").hasClass("nav-lock")) {
         $(".sidenav-main").toggleClass("nav-expanded");
         $("header").toggleClass("header-full");
         $("main").toggleClass("main-full");
      } else {
         $("header").toggleClass("header-full");
         $("main").toggleClass("main-full");
      }
      // Set navigation lock / unlock with radio icon
      if (
         $(this)
            .children()
            .text() == "radio_button_unchecked"
      ) {
         $(this)
            .children()
            .text("radio_button_checked");
         $(".sidenav-main").addClass("nav-lock");
         $(".navbar .nav-collapsible").addClass("sideNav-lock");
      } else {
         $(this)
            .children()
            .text("radio_button_unchecked");
         $(".sidenav-main").removeClass("nav-lock");
         $(".navbar .nav-collapsible").removeClass("sideNav-lock");
      }
   });

   // Expand navigation on mouseenter event
   $(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseenter(function() {
      if (!$(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
         $(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
            .addClass("nav-expanded")
            .removeClass("nav-collapsed");
         $("#slide-out > li.close > a")
            .parent()
            .addClass("open")
            .removeClass("close");

         setTimeout(function() {
            // Open only if collapsible have the children
            if ($(".collapsible .open").children().length > 1) {
               $(".collapsible").collapsible("open", $(".collapsible .open").index());
            }
         }, 100);
      }
   });

   // Collapse navigation on mouseleave event
   $(".sidenav-main.nav-collapsible, .navbar .brand-sidebar").mouseleave(function() {
      if (!$(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
         var openLength = $(".collapsible .open").children().length;
         $(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
            .addClass("nav-collapsed")
            .removeClass("nav-expanded");
         $("#slide-out > li.open > a")
            .parent()
            .addClass("close")
            .removeClass("open");
         setTimeout(function() {
            // Open only if collapsible have the children
            if (openLength > 1) {
               $(".collapsible").collapsible("close", $(".collapsible .close").index());
            }
         }, 100);
      }
   });

   // Check first if any of the task is checked
   $("#task-card input:checkbox").each(function() {
      checkbox_check(this);
   });

   // Task check box
   $("#task-card input:checkbox").change(function() {
      checkbox_check(this);
   });

   // Check Uncheck function
   function checkbox_check(el) {
      if (!$(el).is(":checked")) {
         $(el)
            .next()
            .css("text-decoration", "none"); // or addClass
      } else {
         $(el)
            .next()
            .css("text-decoration", "line-through"); //or addClass
      }
   }

   //Init tabs
   $(".tabs").tabs();

   // Swipeable Tabs Demo Init
   if ($("#tabs-swipe-demo").length) {
      $("#tabs-swipe-demo").tabs({
         swipeable: true
      });
   }

   // Plugin initialization

   $("select").formSelect();

   // Set checkbox on forms.html to indeterminate
   var indeterminateCheckbox = document.getElementById("indeterminate-checkbox");
   if (indeterminateCheckbox !== null) indeterminateCheckbox.indeterminate = true;

   // Materialize Slider
   $(".slider").slider({
      full_width: true
   });

   // Commom, Translation & Horizontal Dropdown
   $(".dropdown-trigger").dropdown();

   // Commom, Translation
   $(".dropdown-button").dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false,
      hover: true,
      gutter: 0,
      coverTrigger: true,
      alignment: "left"
      // stopPropagation: false
   });

   // Notification, Profile, Translation, Settings Dropdown & Horizontal Dropdown
   $(".notification-button, .profile-button, .translation-button, .dropdown-settings, .dropdown-menu").dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: false,
      hover: false,
      gutter: 0,
      coverTrigger: false,
      alignment: "right"
      // stopPropagation: false
   });

   // Fab
   $(".fixed-action-btn").floatingActionButton();
   $(".fixed-action-btn.horizontal").floatingActionButton({
      direction: "left"
   });
   $(".fixed-action-btn.click-to-toggle").floatingActionButton({
      direction: "left",
      hoverEnabled: false
   });
   $(".fixed-action-btn.toolbar").floatingActionButton({
      toolbarEnabled: true
   });

   // Materialize Tabs
   $(".tab-demo")
      .show()
      .tabs();
   $(".tab-demo-active")
      .show()
      .tabs();

   // Materialize scrollSpy
   $(".scrollspy").scrollSpy();

   // Materialize tooltip
   $(".tooltipped").tooltip({
      delay: 50
   });

   //Main Left Sidebar Menu // sidebar-collapse
   $(".sidenav").sidenav({
      edge: "left" // Choose the horizontal origin
   });

   //Main Right Sidebar
   $(".slide-out-right-sidenav").sidenav({
      edge: "right"
   });

   //Main Right Sidebar Chat
   $(".slide-out-right-sidenav-chat").sidenav({
      edge: "right"
   });

   // Perfect Scrollbar
   /*$("select")
      .not(".disabled")
      .select();
   var leftnav = $(".page-topbar").height();
   var leftnavHeight = window.innerHeight - leftnav;
   var righttnav = $("#slide-out-right").height();

   if ($("#slide-out.leftside-navigation").length > 0) {
      if (!$("#slide-out.leftside-navigation").hasClass("native-scroll")) {
         var ps_leftside_nav = new PerfectScrollbar(".leftside-navigation", {
            wheelSpeed: 2,
            wheelPropagation: false,
            minScrollbarLength: 20
         });
      }
   }
   if ($(".slide-out-right-body").length > 0) {
      var ps_slideout_right = new PerfectScrollbar(".slide-out-right-body, .chat-body .collection", {
         suppressScrollX: true
      });
   }
   if ($(".chat-body .collection").length > 0) {
      var ps_slideout_chat = new PerfectScrollbar(".chat-body .collection", {
         suppressScrollX: true
      });
   }*/

   // Char scroll till bottom of the char content area
   var chatScrollAuto = $("#right-sidebar-nav #slide-out-chat .chat-body .collection");
   if (chatScrollAuto.length > 0){
      chatScrollAuto[0].scrollTop = chatScrollAuto[0].scrollHeight;
   }

   // Fullscreen
   function toggleFullScreen() {
      if (
         (document.fullScreenElement && document.fullScreenElement !== null) ||
         (!document.mozFullScreen && !document.webkitIsFullScreen)
      ) {
         if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
         } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
         } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
         }else if (document.documentElement.msRequestFullscreen) {
            if (document.msFullscreenElement) {
               document.msExitFullscreen();
            } else {
             document.documentElement.msRequestFullscreen(); 
            }
         }
      } else {
         if (document.cancelFullScreen) {
            document.cancelFullScreen();
         } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
         } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
         }
      }
   }

   $(".toggle-fullscreen").click(function() {
      toggleFullScreen();
   });

   // Detect touch screen and enable scrollbar if necessary
   function is_touch_device() {
      try {
         document.createEvent("TouchEvent");
         return true;
      } catch (e) {
         return false;
      }
   }
   if (is_touch_device()) {
      $("#nav-mobile").css({
         overflow: "auto"
      });
   }

resizetable();

$('.datepicker').datepicker({format : 'yyyy-mm-dd',maxDate: new Date()});
//$('.datepicker').datepicker({format : 'yyyy-mm-dd'});
$('.data_table').DataTable({"scrollX": true});
var tbl = $('.csv_table').DataTable({"scrollX": true});
if($('.csv_table').length != 0) {
var buttons = new $.fn.dataTable.Buttons(tbl, {
   buttons: [
      {
          extend: 'csv',
          text: 'Export CSV',
          exportOptions: {
              modifier: {
                  search: 'none'
              }
          }
      }
  ]
}).container().appendTo($('.csv_table_btns'));
}

/* custom switch */
$(document).on('click', '.custom_switch', function (){
   $(this).toggleClass('active');
   if($(this).parents('tr').find('.status').hasClass('green')) {
      $(this).parents('tr').find('.status').removeClass('green').addClass('red').text('Inactive');
   } else {
      $(this).parents('tr').find('.status').removeClass('red').addClass('green').text('Active');
   }
});

/* chart toggle */
if($(".toggle_chart_btns").length) {
   $('.toggle_chart_btn').click(function (){
      $(this).toggleClass('active');
      $(this).siblings().toggleClass('active');
      $(this).closest('.toggle_chart_outer').find('.toggle_chart').toggleClass('active');
   });
}

/* table header fix */
if( $('.table_outer').length ) {
   $('.table_outer').each(function(){
      var tbl_height = $(this).attr("data-height");
      $(this).css("max-height", tbl_height+"px");
   })
}
if($(".thead_fix").length) {
   $(".thead_fix").on("scroll", function(){
      var scrollTop = $(this).scrollTop();
      console.log(sTop);
      $(this).find('thead').css("transform", 'translateY(' + scrollTop + 'px)');
   })
}
/*var tableCont = document.querySelector('.thead_fix');
function scrollHandle (e){
   var scrollTop = this.scrollTop;
   this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
}
tableCont.addEventListener('scroll',scrollHandle);*/

/* mltiselect */
$('.multi_select > .select-wrapper > .select-dropdown').prepend('<li class="toggle selectall"><span><label></label>Select all</span></li>');
$('.multi_select > .select-wrapper > .select-dropdown').prepend('<li style="display:none" class="toggle selectnone"><span><label></label>Select none</span></li>');
$('.multi_select > .select-wrapper > .select-dropdown .selectall').on('click', function() {
      selectAll();
      $('.multi_select > .select-wrapper > .select-dropdown .toggle').toggle();
});
$('.multi_select > .select-wrapper > .select-dropdown .selectnone').on('click', function() {
      selectNone();
      $('.multi_select > .select-wrapper > .select-dropdown .toggle').toggle();
});

function selectNone() {
   $('select option:selected').not(':disabled').prop('selected', false);
   $('.dropdown-content.multiple-select-dropdown input[type="checkbox"]:checked').not(':disabled').prop('checked', '');
   var values = $('.dropdown-content.multiple-select-dropdown input[type="checkbox"]:disabled').parent().text();
   $('input.select-dropdown').val(values);
};

function selectAll() {
   $('select option:not(:disabled)').not(':selected').prop('selected', true);
   $('.dropdown-content.multiple-select-dropdown input[type="checkbox"]:not(:checked)').not(':disabled').prop('checked', 'checked');
   var values = $('.dropdown-content.multiple-select-dropdown input[type="checkbox"]:checked').not(':disabled').parent().map(function() {
         return $(this).text();
   }).get();
   $('input.select-dropdown').val(values.join(', '));
};



});

$(window).on("resize", function() {
   resizetable();
});

function resizetable() {
   if($(window).width() < 976){
      if($('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo').length > 0){
         $('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo-color.png');
      }
      if($('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo').length > 0){
         $('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo-color.png');
      }
      if($('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo').length > 0){
         $('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo.png');
      }
   }
   else{
      if($('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo').length > 0){
         $('.vertical-layout.vertical-gradient-menu .sidenav-dark .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo.png');
      }
      if($('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo').length > 0){
         $('.vertical-layout.vertical-dark-menu .sidenav-dark .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo.png');
      }
      if($('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo').length > 0){
         $('.vertical-layout.vertical-modern-menu .sidenav-light .brand-logo img').attr('src','../../../app-assets/images/logo/materialize-logo-color.png');
      }
   }
}
resizetable();

// Add message to chat
function slide_out_chat() {
   var message = $(".search").val();
   if (message != "") {
      var html =
         '<li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat"><div class="user-content speech-bubble-right">' +
         '<p class="medium-small">' +
         message +
         "</p>" +
         "</div></li>";
      $("#right-sidebar-nav #slide-out-chat .chat-body .collection").append(html);
      $(".search").val("");
      var charScroll = $("#right-sidebar-nav #slide-out-chat .chat-body .collection");
      if (charScroll.length > 0){
         charScroll[0].scrollTop = charScroll[0].scrollHeight;
      }
   }
}

// back to top button
var head_height= $("header").outerHeight();
$(window).on("scroll", function(){
   if($(window).scrollTop() > head_height) {
      $(".back_top").addClass("active");
   }
   else {$(".back_top").removeClass("active");}
})
$(".back_top").on("click", function(){
   $("html, body").animate({ scrollTop: 0 }, 500);
})
  // Or with jQuery
$(document).ready(function(){
   $('.modal').modal();
   $('#upload_modal').modal({dismissible: false});
   $('.filter_btn').on("click", function(){
      $(this).siblings(".custom_filter").toggleClass("active");
   })
});

