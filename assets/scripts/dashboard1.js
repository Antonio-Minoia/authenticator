(function (factory) {
  if (typeof define === "function" && define.amd) {
    define(["jquery"], factory);
  } else if (typeof module === "object" && module.exports) {
    module.exports = factory(require("jquery"));
  } else {
    factory(jQuery);
  }
})(function ($) {
  "use strict";
  $.aside = function (action) {
    var defaults = {
      element: {
        main: ".aside",
        backdrop: "#aside-backdrop",
        toggle: '[data-toggle="aside"]',
      },
      breakpoint: 1025,
      class: {
        minimizedDesktop: "aside-desktop-minimized",
        minimizedMobile: "aside-mobile-minimized",
        maximizedDesktop: "aside-desktop-maximized",
        maximizedMobile: "aside-mobile-maximized",
        hover: "aside-hover",
      },
      transitionDuration: 200,
      easing: "linear",
    };
    var settings = $.extend({}, defaults, $.aside.defaults);
    var methods = [
      {
        event: "init",
        action: function (el) {
          _init(el);
        },
      },
      {
        event: "toggle",
        action: function () {
          _toggle();
        },
      },
      {
        event: "minimize",
        action: function () {
          _minimize();
        },
      },
      {
        event: "maximize",
        action: function () {
          _maximize();
        },
      },
    ];
    function _init() {
      var trigger = $(settings.element.toggle);
      if ($("body").hasClass(settings.class.minimizedDesktop)) {
        $(settings.element.main).addClass(settings.class.hover);
      }
      trigger.on("click", function () {
        var dataTarget = $(trigger.data("target"));
        var target =
          dataTarget.length > 0 ? dataTarget : $(settings.element.main);
        _toggle(target);
      });
    }
    function _toggle() {
      var target = $(settings.element.main);
      if (target.length > 0) {
        var isMinimized =
          $(window).width() >= settings.breakpoint
            ? settings.class.minimizedDesktop
            : settings.class.minimizedMobile;
        $("body").hasClass(isMinimized) ? _maximize() : _minimize();
      }
    }
    function _minimize() {
      var target = $(settings.element.main);
      if (target.length > 0) {
        $(window).width() >= settings.breakpoint
          ? _minimizeDesktop()
          : _minimizeMobile();
      }
    }
    function _maximize(target) {
      var target = $(settings.element.main);
      if (target.length > 0) {
        $(window).width() >= settings.breakpoint
          ? _maximizeDesktop()
          : _maximizeMobile();
      }
    }
    function _minimizeBodyClass() {
      if ($(window).width() >= settings.breakpoint) {
        var addClass = settings.class.minimizedDesktop;
        var removeClass = settings.class.maximizedDesktop;
      } else {
        var addClass = settings.class.minimizedMobile;
        var removeClass = settings.class.maximizedMobile;
      }
      $("body").addClass(addClass);
      $("body").removeClass(removeClass);
    }
    function _maximizeBodyClass() {
      if ($(window).width() >= settings.breakpoint) {
        var addClass = settings.class.maximizedDesktop;
        var removeClass = settings.class.minimizedDesktop;
      } else {
        var addClass = settings.class.maximizedMobile;
        var removeClass = settings.class.minimizedMobile;
      }
      $("body").addClass(addClass);
      $("body").removeClass(removeClass);
    }
    function _minimizeMobile() {
      var target = $(settings.element.main);
      _minimizeBodyClass();
      $(settings.element.backdrop)
        .animate(
          { opacity: 0 },
          {
            duration: settings.transitionDuration,
            easing: settings.easing,
            complete: function () {
              $(this).remove();
            },
          }
        )
        .off();
    }
    function _maximizeMobile() {
      var target = $(settings.element.main);
      var backdrop =
        '<div id="' + settings.element.backdrop.substr(1) + '"></div>';
      _maximizeBodyClass();
      $(backdrop)
        .appendTo("body")
        .animate(
          { opacity: 1 },
          {
            duration: settings.transitionDuration,
            easing: settings.easing,
            complete: function () {
              $(this).on("click", function () {
                _minimizeMobile();
              });
            },
          }
        );
    }
    function _minimizeDesktop() {
      var target = $(settings.element.main);
      _minimizeBodyClass();
      setTimeout(function () {
        target.first().addClass(settings.class.hover);
      }, settings.transitionDuration);
      $(window).trigger("resize");
    }
    function _maximizeDesktop() {
      var target = $(settings.element.main);
      _maximizeBodyClass();
      target.first().removeClass(settings.class.hover);
      $(window).trigger("resize");
    }
    var element = $(this);
    if (typeof action == "string") {
      methods.forEach(function (method) {
        if (action == method.event) {
          method.action(element);
        }
      });
    }
    return this;
  };
  $(function () {
    $.aside("init");
  });
});
$(function () {
  var stickyBreakpoint = 1025;
  var stickyConfig = { topSpacing: 0 };
  var stickyHeaderDesktopElement = "#sticky-header-desktop";
  var stickyHeaderMobileElement = "#sticky-header-mobile";
  function stickyInit(target) {
    if ($(target).parent(".sticky-wrapper").length < 1) {
      $(target).sticky(stickyConfig);
    }
  }
  function stickyDestroy(target) {
    $(target).unstick();
  }
  $(window).resize(function () {
    var viewport = $(this).width();
    if (viewport >= stickyBreakpoint) {
      stickyInit(stickyHeaderDesktopElement);
      stickyDestroy(stickyHeaderMobileElement);
    } else {
      stickyInit(stickyHeaderMobileElement);
      stickyDestroy(stickyHeaderDesktopElement);
    }
  });
  if ($(window).width() >= stickyBreakpoint) {
    stickyInit(stickyHeaderDesktopElement);
  } else {
    stickyInit(stickyHeaderMobileElement);
  }
  $("#theme-toggle").on("click", function () {
    var isDark = $("body").hasClass("theme-dark");
    if (isDark) {
      $("body").removeClass("theme-dark");
      $("body").addClass("theme-light");
      $(this).children("i").removeClass("fa-sun");
      $(this).children("i").addClass("fa-moon");
    } else {
      $("body").removeClass("theme-light");
      $("body").addClass("theme-dark");
      $(this).children("i").removeClass("fa-moon");
      $(this).children("i").addClass("fa-sun");
    }
  });
  $("#fullscreen-trigger").on("click", function () {
    var active = $("body").data("fullscreen-active");
    active
      ? document.exitFullscreen()
      : document.documentElement.requestFullscreen();
  });
  document.onfullscreenchange = function () {
    if (document.fullscreenElement) {
      $("body").addClass("fullscreen-active");
      $("body").data("fullscreen-active", true);
    } else {
      $("body").removeClass("fullscreen-active");
      $("body").data("fullscreen-active", false);
    }
  };
  $(".dropdown").on("show.bs.dropdown", function () {
    $('[data-toggle="simplebar"]').each(function () {
      new SimpleBar(this);
    });
  });
  var date = new Date();
  $("#copyright-year").html(date.getFullYear());
  $('[data-toggle="popover"]').popover();
  $('[data-toggle="tooltip"]').tooltip();
});

function cambiatema() {
  var temas = "";
  if ($('body[class*="theme-light"]').length > 0) {
    temas = "dark";
  } else {
    temas = "light";
  }
  $.post(
    "../api/helpers/tema.php",
    {
      tema: temas,
    },
    function (data) {
      if (data != "1") {
        alert(data);
      }
    }
  );
}

//# sourceMappingURL=dashboard1.js.map
