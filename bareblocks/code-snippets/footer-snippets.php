<?php
/** These go before the closing </body> tag for all pages. */
/** Place <script> tags in this document. */ 
?>

<script>
    jQuery(document).ready(function($) {
        var deviceAgent = navigator.userAgent.toLowerCase();
        if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
        $("html").addClass("ios");
        $("html").addClass("mobile");
        }
        if (deviceAgent.match(/(Android)/)) {
        $("html").addClass("android");
        $("html").addClass("mobile");
        }
        if (navigator.userAgent.search("MSIE") >= 0) {
        $("html").addClass("ie");
        }
        else if (navigator.userAgent.search("Chrome") >= 0) {
        $("html").addClass("chrome");
        }
        else if (navigator.userAgent.search("Firefox") >= 0) {
        $("html").addClass("firefox");
        }
        else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        $("html").addClass("safari");
        }
        else if (navigator.userAgent.search("Opera") >= 0) {
        $("html").addClass("opera");
        }
    });
</script>

<script async defer>
    function hamburgerBtnClick(id) {
        let header = document.getElementsByClassName('site-header')[0];
        let state = document.getElementById(id).style.display;
        if (state == 'block') {
            document.getElementById(id).style.display = 'none';
            header.classList.remove('height-100');
        } else {
            document.getElementById(id).style.display = 'block';
            header.classList.add('height-100');
        }
    }
</script>