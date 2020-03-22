$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {

        // Initialize countdown refreshing
        var timeLeftContainer = $("#timeLeftContainer");

        setInterval(function () {
            $.ajax({
                url: URL_SERVICE_GAME_LIST_INFO, success: function (data) {
                    $(timeLeftContainer).attr("remaining", data.roundRemainingSeconds);
                    countdownStart();
                }
            });
        }, GAME_LIST_REFRESH_TIME);

        // Start the countdown
        countdownStart();

    });
});


/**
 * Start the countdown
 */
function countdownStart() {
    var timeLeftContainer = $("#timeLeftContainer"),
        timeLeftBar = $("#timeLeftBar"),
        timeLeftBarWidth = 0,
        timeLeft = $(timeLeftContainer).attr("remaining"),
        timeLeftTotal = $(timeLeftContainer).attr("total"),
        timers = $(".timeLeftTimer");

    if (timeLeftContainer) {
        UtilsTimer.stopCountdown("gamesRemaining");
        UtilsTimer.countdown($(timeLeftContainer).children("p"), "gamesRemaining", timeLeft, 1000, {
            days: "d ",
            hours: "h ",
            minutes: "m ",
            seconds: "s"
        }, function () {
            timeLeftBarWidth = (timeLeftTotal - timeLeft) * 100 / timeLeftTotal;
            $(timeLeftBar).css({width: timeLeftBarWidth + '%'});


            $(timers).addClass("pulse animated").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass("pulse animated");
            });


            timeLeft--;
        }, function () {
            //TODO
        });
    }
}