//Detect Mobile Devices. Available in the global scope
window.Radium_isMobile = {

    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },

    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },

    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },

    iPhone: function() {
        return navigator.userAgent.match(/iPhone/i);
    },

    iPad: function() {
        return navigator.userAgent.match(/iPad/i);
    },

    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },

    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },

    Landscape: function () {
        return (window.orientation === 90 || window.orientation === -90);
    },

    Portrait: function () {
        return (window.orientation === 0 || window.orientation === 180);
    },

    any: function() {
        return ( window.Radium_isMobile.Android() ||window.Radium_isMobile.BlackBerry() || window.Radium_isMobile.iOS() || window.Radium_isMobile.Opera() || window.Radium_isMobile.Windows() || Modernizr.mq('screen and (max-width:767px)') );
    }
};