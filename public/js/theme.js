parcelRequire=function(e,r,t,n){var i,o="function"==typeof parcelRequire&&parcelRequire,u="function"==typeof require&&require;function f(t,n){if(!r[t]){if(!e[t]){var i="function"==typeof parcelRequire&&parcelRequire;if(!n&&i)return i(t,!0);if(o)return o(t,!0);if(u&&"string"==typeof t)return u(t);var c=new Error("Cannot find module '"+t+"'");throw c.code="MODULE_NOT_FOUND",c}p.resolve=function(r){return e[t][1][r]||r},p.cache={};var l=r[t]=new f.Module(t);e[t][0].call(l.exports,p,l,l.exports,this)}return r[t].exports;function p(e){return f(p.resolve(e))}}f.isParcelRequire=!0,f.Module=function(e){this.id=e,this.bundle=f,this.exports={}},f.modules=e,f.cache=r,f.parent=o,f.register=function(r,t){e[r]=[function(e,r){r.exports=t},{}]};for(var c=0;c<t.length;c++)try{f(t[c])}catch(e){i||(i=e)}if(t.length){var l=f(t[t.length-1]);"object"==typeof exports&&"undefined"!=typeof module?module.exports=l:"function"==typeof define&&define.amd?define(function(){return l}):n&&(this[n]=l)}if(parcelRequire=f,i)throw i;return f}({"m3VC":[function(require,module,exports) {
document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll(".card-header").forEach(function(e){e.classList.toggle("bg-dark"),e.classList.toggle("text-white")}),document.querySelectorAll(".card-header .fa-dot-circle").forEach(function(e){e.classList.toggle("text-white"),e.classList.toggle("text-dark")}),document.querySelectorAll(".card-metrics").forEach(function(e){e.classList.toggle("bg-dark"),e.classList.toggle("bg-light"),e.classList.toggle("text-white")}),document.querySelector(".navbar").classList.toggle("navbar-light"),document.querySelector(".navbar").classList.toggle("bg-light"),document.querySelector(".navbar").classList.toggle("navbar-dark"),document.querySelector(".navbar").classList.toggle("bg-dark"),document.querySelector(".sidebar-toggler").classList.toggle("border-dark"),document.querySelector(".sidebar-toggler").classList.toggle("border-light"),document.querySelector(".sidebar-toggler .fa-bars").classList.toggle("text-light"),document.querySelector("#dropdown-notifications")&&document.querySelector("#dropdown-notifications").classList.toggle("text-light"),document.querySelector("#dropdown-messages")&&document.querySelector("#dropdown-messages").classList.toggle("text-light"),document.querySelector(".btn-sm .fa-cog")&&document.querySelector(".btn-sm .fa-cog").classList.toggle("text-light"),document.querySelector(".wrapper__sidebar").classList.toggle("bg-light"),document.querySelector(".wrapper__sidebar").classList.toggle("bg-white"),document.querySelector(".wrapper__sidebar .sidebar-title").classList.toggle("bg-light"),document.querySelector(".wrapper__sidebar .sidebar-title").classList.toggle("bg-dark"),document.querySelector(".wrapper__sidebar .sidebar-title").classList.toggle("text-light"),document.querySelector(".wrapper__sidebar .sidebar-title .fa-times").classList.toggle("text-dark"),document.querySelector(".wrapper__sidebar .sidebar-title .fa-times").classList.toggle("text-light"),document.querySelector("#avatar-icon")&&(document.querySelector("#avatar-icon").classList.toggle("text-light"),document.querySelector("#avatar-icon").classList.toggle("bg-dark"),document.querySelector("#avatar-icon").classList.toggle("text-dark"),document.querySelector("#avatar-icon").classList.toggle("bg-light")),document.querySelectorAll(".card-header .btn-outline-dark").forEach(function(e){e.classList.toggle("btn-outline-dark"),e.classList.toggle("btn-light")}),document.querySelectorAll(".wrapper__sidebar .list-group-item").forEach(function(e){e.classList.toggle("bg-light")})});
},{}]},{},["m3VC"], null)
//# sourceMappingURL=/theme.js.map