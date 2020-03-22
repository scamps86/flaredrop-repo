$(document).ready(function () {
    SystemWeb.initializeSectionJs("downloads", function () {

        var x = 0, y = 0;

        document.onmousemove = function (e) {
            x = e.pageX;
            y = e.pageY;
        };

        setInterval(function () {
            var ad = $("#gAdsenseAd2"),
                cx = x - ($(ad).width() / 2),
                cy = y - ($(ad).height() / 2);

            $(ad).css({top: cy + "px", left: cx + "px"});
        }, 1800);
    });
});