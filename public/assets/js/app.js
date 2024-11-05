
!function N() {
  document.webkitIsFullScreen ||
    document.mozFullScreen ||
    document.msFullscreenElement ||
    document.body.classList.remove("fullscreen-enable");
}

  // (L = document.querySelector('[data-toggle="fullscreen"]')) &&
  // L.addEventListener("click", function (e) {
  //   e.preventDefault(),
  //     document.body.classList.toggle("fullscreen-enable"),
  //     document.fullscreenElement ||
  //       document.mozFullScreenElement ||
  //       document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen()
  //         : document.mozCancelFullScreen ? document.mozCancelFullScreen()
  //           : document.webkitCancelFullScreen &&
  //           document.webkitCancelFullScreen()
  //       : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen()
  //         : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen()
  //           : document.documentElement.webkitRequestFullscreen &&
  //           document.documentElement.webkitRequestFullscreen(
  //             Element.ALLOW_KEYBOARD_INPUT
  //           );
  // }),
  // document.addEventListener("fullscreenchange", N),
  // document.addEventListener("webkitfullscreenchange", N),
  // document.addEventListener("mozfullscreenchange", N),

  (k = document.getElementsByTagName("HTML")[0]),
  (z = document.querySelectorAll(".light-dark-mode")) && z.length && z[0].addEventListener("click", function (e) {
    k.hasAttribute("data-bs-theme") && "dark" == k.getAttribute("data-bs-theme") ? C("data-bs-theme", "light", "layout-mode-light", k) : C("data-bs-theme", "dark", "layout-mode-dark", k), window.dispatchEvent(x);
  })


var mybutton = document.getElementById("back-to-top");
function scrollFunction() {
  100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? (mybutton.style.display = "block") : (mybutton.style.display = "none");
}
function topFunction() {
  (document.body.scrollTop = 0), (document.documentElement.scrollTop = 0);
}
mybutton && (window.onscroll = function () {
  scrollFunction();
});


document.getElementById("sidebarUserProfile")?.addEventListener("click", function (e) {
  e.target.checked ? document.documentElement.setAttribute("data-sidebar-user-show", "") : document.documentElement.removeAttribute("data-sidebar-user-show");
})
