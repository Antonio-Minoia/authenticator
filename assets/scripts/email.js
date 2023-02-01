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
  $.aside = function (action, param) {
    var defaults = {
      breakpoint: 1025,
      toggleElement: '[data-toggle="aside"]',
      backdropElement: "#aside-backdrop",
      transitionDuration: 200,
      transitionEasing: "linear",
      activeClass: "aside-show",
    };
    var settings = $.extend({}, defaults, $.aside.defaults);
    var methods = [
      {
        event: "init",
        action: function () {
          _init();
        },
      },
      {
        event: "show",
        action: function () {
          _show();
        },
      },
      {
        event: "hide",
        action: function () {
          _hide();
        },
      },
    ];
    function _hide() {
      var viewport = $(window).width();
      if (viewport < settings.breakpoint) {
        $("body").removeClass(settings.activeClass);
        $(settings.backdropElement)
          .animate(
            { opacity: 0 },
            {
              duration: settings.transitionDuration,
              easing: settings.transitionEasing,
              complete: function () {
                $(this).remove();
              },
            }
          )
          .off();
      }
    }
    function _show() {
      var viewport = $(window).width();
      if (viewport < settings.breakpoint) {
        $("body").addClass(settings.activeClass);
        var backdrop =
          '<div id="' + settings.backdropElement.substr(1) + '"></div>';
        $(backdrop)
          .appendTo("body")
          .animate(
            { opacity: 1 },
            {
              duration: settings.transitionDuration,
              easing: settings.transitionEasing,
              complete: function () {
                $(this).on("click", function () {
                  _hide();
                });
              },
            }
          );
      }
    }
    function _init() {
      $(settings.toggleElement).on("click", function () {
        if ($("body").hasClass(settings.activeClass)) {
          _hide();
        } else {
          _show();
        }
      });
    }
    if (typeof action == "string") {
      methods.forEach(function (method) {
        if (action == method.event) {
          method.action(param);
        }
      });
    }
  };
  $(function () {
    $.aside("init");
  });
});
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
  $.sidebar = function (action, param) {
    var defaults = {
      breakpoint: 1025,
      toggleElement: '[data-toggle="sidebar"]',
      backdropElement: "#sidebar-backdrop",
      transitionDuration: 200,
      transitionEasing: "linear",
      activeClass: "sidebar-show",
    };
    var settings = $.extend({}, defaults, $.sidebar.defaults);
    var methods = [
      {
        event: "init",
        action: function () {
          _init();
        },
      },
      {
        event: "show",
        action: function () {
          _show();
        },
      },
      {
        event: "hide",
        action: function () {
          _hide();
        },
      },
    ];
    function _hide() {
      var viewport = $(window).width();
      if (viewport < settings.breakpoint) {
        $("body").removeClass(settings.activeClass);
        $(settings.backdropElement)
          .animate(
            { opacity: 0 },
            {
              duration: settings.transitionDuration,
              easing: settings.transitionEasing,
              complete: function () {
                $(this).remove();
              },
            }
          )
          .off();
      }
    }
    function _show() {
      var viewport = $(window).width();
      if (viewport < settings.breakpoint) {
        $("body").addClass(settings.activeClass);
        var backdrop =
          '<div id="' + settings.backdropElement.substr(1) + '"></div>';
        $(backdrop)
          .appendTo("body")
          .animate(
            { opacity: 1 },
            {
              duration: settings.transitionDuration,
              easing: settings.transitionEasing,
              complete: function () {
                $(this).on("click", function () {
                  _hide();
                });
              },
            }
          );
      }
    }
    function _init() {
      $(settings.toggleElement).on("click", function () {
        if ($("body").hasClass(settings.activeClass)) {
          _hide();
        } else {
          _show();
        }
      });
    }
    if (typeof action == "string") {
      methods.forEach(function (method) {
        if (action == method.event) {
          method.action(param);
        }
      });
    }
  };
  $(function () {
    $.sidebar("init");
  });
});
$(function () {
  var stickyBreakpoint = 1025;
  var stickyHeaderDesktopElement = "#sticky-header-desktop";
  var stickyHeaderMobileElement = "#sticky-header-mobile";
  var stickyAsideElement = "#sticky-aside";
  var stickyHeaderConfig = { topSpacing: 0 };
  var stickyAsideConfig = {
    topSpacing: $(stickyHeaderDesktopElement).outerHeight(),
  };
  function asideScrollbarInit() {
    setTimeout(function () {
      new SimpleBar($(stickyAsideElement).find('[data-toggle="simplebar"]')[0]);
    }, 10);
  }
  function stickyInit(target, config) {
    if ($(target).parent(".sticky-wrapper").length < 1) {
      $(target).sticky(config);
    }
  }
  function stickyDestroy(target) {
    $(target).unstick();
  }
  $(window).resize(function () {
    var viewport = $(this).width();
    if (viewport >= stickyBreakpoint) {
      stickyInit(stickyAsideElement, stickyAsideConfig);
      stickyInit(stickyHeaderDesktopElement, stickyHeaderConfig);
      stickyDestroy(stickyHeaderMobileElement);
    } else {
      stickyInit(stickyHeaderMobileElement, stickyHeaderConfig);
      stickyDestroy(stickyHeaderDesktopElement);
      stickyDestroy(stickyAsideElement);
    }
    asideScrollbarInit();
  });
  if ($(window).width() >= stickyBreakpoint) {
    stickyInit(stickyHeaderDesktopElement, stickyHeaderConfig);
    stickyInit(stickyAsideElement, stickyAsideConfig);
  } else {
    stickyInit(stickyHeaderMobileElement, stickyHeaderConfig);
  }
  asideScrollbarInit();
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
  $(".dropdown").on("show.bs.dropdown", function () {
    $('[data-toggle="simplebar"]').each(function () {
      new SimpleBar(this);
    });
  });
  $('[data-toggle="tooltip"]').tooltip();
});
//# sourceMappingURL=email.js.map
