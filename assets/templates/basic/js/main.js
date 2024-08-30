(function ($) {
  "use strict";

  // active side bar
  $(".show-sidebar-btn").click(function (e) {
    e.stopPropagation();
    $(".sidebar-menu").toggleClass("active");
  });
  $(".cross-sidebar").click(function () {
    $(".sidebar-menu").removeClass("active");
  });
  $(window).click(function () {
    $(".sidebar-menu").removeClass("active");
  });

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {

    // ============== Header Hide Click On Body Js Start ===============
    $('.header-button').on('click', function () {
      $('.body-overlay').toggleClass('show')
    });

    $('.body-overlay').on('click', function () {
      $('.header-button').trigger('click')
      $(this).removeClass('show');
    });
    // =============== Header Hide Click On Body Js End ===============

    // =============== Header Hide Scroll Bar Js Start ===============
    $('.navbar-toggler.header-button').on('click', function () {
      $('body').toggleClass('scroll-hide-sm')
    });

    $('.body-overlay').on('click', function () {
      $('body').removeClass('scroll-hide-sm')
    });
    // =============== Header Hide Scroll Bar Js End ===============

    // ========================== Add Attribute For Bg Image Js Start =====================
    $(".bg-img").css('background-image', function () {
      var bg = ('url(' + $(this).data("background-image") + ')');
      return bg;
    });
    // ========================== Add Attribute For Bg Image Js End =====================

    // ========================== Add active class to ul > li top Active current page Js Start =====================
    function dynamicActiveMenuClass(selector) {
      let FileName = window.location.pathname.split("/").reverse()[0];

      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == FileName) {
          $(this).addClass("active");
        }
      });

      // if any li has active element add class
      selector.children("li").each(function () {
        if ($(this).find(".active").length) {
          $(this).addClass("active");
        }
      });

      // if no file name return
      if ("" == FileName) {
        selector.find("li").eq(0).addClass("active");
      }
    }

    if ($('ul').length) {
      dynamicActiveMenuClass($('ul'));
    }
    // ========================== Add active class to ul>li top Active current page Js End =====================

    // ========================== Password Show Hide Js Start ==========================
    $(".toggle-password").on('click', function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
   

    // ========================== Copy To Clipboard Js Start ==============================
    $('.input-group--copy .btn').on('click', function () {
      var copyInput = $('.input-group--copy .form--control');
      copyInput.select()
      copyInput[0].setSelectionRange(0, 99999);
      document.execCommand('copy');
      $(this).find('span').text('Copied');
      var timer = setTimeout(() => {
        $(this).find('span').text('Copy');
        clearTimeout(timer);
      }, 2000);
    });
    // ========================== Copy To Clipboard Js End ================================

    // ========================== Sidebar Show & Hide Js Start ============================
    $('[data-toggle="sidebar"]').on('click', function () {
      var target = $(this).data('target');
      var sidebar = $(target);
      var closeBtn = sidebar.find('.close-btn');
      var sidebarOverlay = $('.sidebar-overlay');
      var actions = {
        open() {
          sidebar.addClass('show');
          sidebarOverlay.addClass('show');
        },
        close() {
          sidebar.removeClass('show');
          sidebarOverlay.removeClass('show');

          // remove click event listener after closing the sidebar
          closeBtn.off('click', actions.close);
          sidebarOverlay.off('click', actions.close);
        }
      }
      actions.open();
      closeBtn.on('click', actions.close);
      sidebarOverlay.on('click', actions.close);
    })
    // ========================== Sidebar Show & Hide Js End ==============================
  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $('.preloader').fadeOut();
  })
  // ========================= Preloader Js End=====================

  // ========================= Header Sticky Js Start ==============
  $(window).on('scroll', function () {
    if ($(window).scrollTop() >= 300) {
      $('.header').addClass('fixed-header');
    } else {
      $('.header').removeClass('fixed-header');
    }
  });
  // ========================= Header Sticky Js End===================

  //============================ Scroll To Top Icon Js Start =========
  var btn = $('.scroll-top');

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, '300');
  });
  //========================= Scroll To Top Icon Js End ======================

})(jQuery);

// ================== Sidebar Menu Js Start ===============
// Sidebar Dropdown Menu Start
$(".has-dropdown > a").click(function () {
  $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
    .parent()
    .hasClass("active")
  ) {
    $(".has-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".has-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});
// Sidebar Dropdown Menu End

$(".dashboard-body__bar-icon").on("click", function (event) {
  $(".dashboard").toggleClass('show-sidebar');
  event.stopPropagation();
});

$(".sidebar-menu").on("click", function (event) {
  event.stopPropagation();
});

$(".sidebar-menu__close").on("click", function (event) {
  event.stopPropagation();
  $(".dashboard").removeClass('show-sidebar');
});

$('body').on('click', function () {
  $('.dashboard').removeClass('show-sidebar');
})
// Sidebar Icon & Overlay js 
// ===================== Sidebar Menu Js End =================

// ==================== Dashboard User Profile Dropdown Start ==================
$('.user-info__button').on('click', function (event) {
  event.stopPropagation();
  $('.user-info-dropdown').toggleClass('show');
});

$('.user-info-dropdown__link').on('click', function (event) {
  event.stopPropagation();
  $('.user-info-dropdown').addClass('show')
});

$('body').on('click', function () {
  $('.user-info-dropdown').removeClass('show');
})
// ==================== Dashboard User Profile Dropdown End ==================

// ==================== Custom Sidebar Dropdown Menu Js Start ==================
$('.has-submenu').on('click', function (event) {
  event.preventDefault(); // Prevent the default anchor link behavior

  // Check if this submenu is currently visible
  var isOpen = $(this).find('.sidebar-submenu').is(':visible');

  // Hide all submenus initially
  $('.sidebar-submenu').slideUp();

  // Remove the "active" class from all li elements
  $('.sidebar-menu__item').removeClass('active');

  // If this submenu was not open, toggle its visibility and add the "active" class to the clicked li
  if (!isOpen) {
    $(this).find('.sidebar-submenu').slideToggle(500);
    $(this).addClass('active');
  }
});
// ==================== Custom Sidebar Dropdown Menu Js End ==================


// language--------------------------------------------------------
$('.custom--dropdown__selected').on('click', function () {
  $(this).parent().toggleClass('open');
});

$(document).on('keyup', function (evt) {
  if ((evt.keyCode || evt.which) === 27) {
    $('.custom--dropdown').removeClass('open');
  }
});

$(document).on('click', function (evt) {
  if ($(evt.target).closest(".custom--dropdown > .custom--dropdown__selected").length === 0) {
    $('.custom--dropdown').removeClass('open');
  }
});
