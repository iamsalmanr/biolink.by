"use strict";
let enableMenuLocalStorage = !0, templateName = 'quick', menu, animate, isHorizontalLayout = !1;
document.getElementById("layout-menu") && (isHorizontalLayout = document.getElementById("layout-menu").classList.contains("menu-horizontal")), function () {
  setTimeout(function () {
  }, 1e3), document.querySelectorAll("#layout-menu").forEach(function (e) {
    menu = new Menu(e, {
      orientation: isHorizontalLayout ? "horizontal" : "vertical",
      closeChildren: !!isHorizontalLayout,
      showDropdownOnHover: localStorage.getItem("templateCustomizer-" + templateName + "--ShowDropdownOnHover") ? "true" === localStorage.getItem("templateCustomizer-" + templateName + "--ShowDropdownOnHover") : void 0 === window.templateCustomizer || window.templateCustomizer.settings.defaultShowDropdownOnHover
    }), window.Helpers.scrollToActive(animate = !1), window.Helpers.mainMenu = menu
  });
  document.querySelectorAll(".layout-menu-toggle").forEach(e => {
    e.addEventListener("click", e => {
      if (e.preventDefault(), window.Helpers.toggleCollapsed(), enableMenuLocalStorage && !window.Helpers.isSmallScreen()) try {
        localStorage.setItem("templateCustomizer-" + templateName + "--LayoutCollapsed", String(window.Helpers.isCollapsed()));
        var t, o = document.querySelector(".template-customizer-layouts-options");
        o && (t = window.Helpers.isCollapsed() ? "collapsed" : "expanded", o.querySelector(`input[value="${t}"]`).click())
      } catch (e) {
      }
    })
  });
  if (document.getElementById("layout-menu")) {
    var t = document.getElementById("layout-menu");
    var o = function () {
      Helpers.isSmallScreen() || document.querySelector(".layout-menu-toggle").classList.add("d-block")
    };
    let e = null;
    t.onmouseenter = function () {
      e = Helpers.isSmallScreen() ? setTimeout(o, 0) : setTimeout(o, 300)
    }, t.onmouseleave = function () {
      document.querySelector(".layout-menu-toggle").classList.remove("d-block"), clearTimeout(e)
    }
  }
  window.Helpers.swipeIn(".drag-target", function (e) {
    window.Helpers.setCollapsed(!1)
  }), window.Helpers.swipeOut("#layout-menu", function (e) {
    window.Helpers.isSmallScreen() && window.Helpers.setCollapsed(!0)
  });
  let e = document.getElementsByClassName("menu-inner"), n = document.getElementsByClassName("menu-inner-shadow")[0];
  0 < e.length && n && e[0].addEventListener("ps-scroll-y", function () {
    this.querySelector(".ps__thumb-y").offsetTop ? n.style.display = "block" : n.style.display = "none"
  });
  window.Helpers.setAutoUpdate(!0),  window.Helpers.initNavbarDropdownScrollbar();
  let u = document.querySelector("[data-template^='horizontal-menu']");
  if (u && (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? window.Helpers.setNavbarFixed("fixed") : window.Helpers.setNavbarFixed("")), window.addEventListener("resize", function (e) {
    window.innerWidth >= window.Helpers.LAYOUT_BREAKPOINT && document.querySelector(".search-input-wrapper") && (document.querySelector(".search-input-wrapper").classList.add("d-none"), document.querySelector(".search-input").value = ""), u && (window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? window.Helpers.setNavbarFixed("fixed") : window.Helpers.setNavbarFixed(""), setTimeout(function () {
      window.innerWidth < window.Helpers.LAYOUT_BREAKPOINT ? document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-horizontal") && menu.switchMenu("vertical") : document.getElementById("layout-menu") && document.getElementById("layout-menu").classList.contains("menu-vertical") && menu.switchMenu("horizontal")
    }, 100))
  }, !0), !isHorizontalLayout && !window.Helpers.isSmallScreen() && ("undefined" != typeof TemplateCustomizer && (window.templateCustomizer.settings.defaultMenuCollapsed ? window.Helpers.setCollapsed(!0, !1) : window.Helpers.setCollapsed(!1, !1)), "undefined" != typeof config) && enableMenuLocalStorage) try {
    null !== localStorage.getItem("templateCustomizer-" + templateName + "--LayoutCollapsed") && window.Helpers.setCollapsed("true" === localStorage.getItem("templateCustomizer-" + templateName + "--LayoutCollapsed"), !1)
  } catch (e) {
  }
}();
