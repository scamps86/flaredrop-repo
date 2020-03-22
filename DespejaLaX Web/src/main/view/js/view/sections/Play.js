GAME_SOLUTION = "";

$(document).ready(function () {
    SystemWeb.initializeSectionJs("play", function () {

        var elementSolutionScreen = $("#solutionScreen"), qPos;

        // Listen the start btn click event
        $("#startGameBtn").click(function () {
            startGame();
        });

        // Listen reset button
        $("#resetBtn").click(function () {
            resetSolution();
        });

        // Listen commit button
        $("#commitBtn").click(function () {
            commit();
        });

        // Listen keyboard and concat the solution
        $("#gameKeyboard li.in").click(function () {

            // Quote position
            qPos = GAME_SOLUTION.indexOf(".");

            if ($(this).hasClass("e")) {
                // Error
                GAME_SOLUTION = "E";
            }
            else if ($(this).hasClass("n")) {
                // Numbers
                if (GAME_SOLUTION == "E") {
                    GAME_SOLUTION = "";
                }
                if (GAME_SOLUTION.length - qPos < 3) {
                    GAME_SOLUTION += $(this).html();
                }
            }
            else if ($(this).hasClass("q")) {
                // Quote
                if (GAME_SOLUTION.length > 0 && qPos == -1) {
                    GAME_SOLUTION += ".";
                }
            }

            $(elementSolutionScreen).html(GAME_SOLUTION);
        });
    });
});


/**
 * Start the game
 */
function startGame() {
    $.ajax({
        url: URL_SERVICE_GAME_START,
        data: {gameId: GAME_ID},
        method: "POST",
        success: function (data) {
            console.log(data);
            if (data != "") {
                alert(window["GAME_" + data]);
            }
            UtilsHttp.refresh();
        },
        error: function () {
            alert("KO");
            UtilsHttp.refresh();
        }
    });
}


/**
 * Generate the issue solution
 */
function generateIssue() {
    $("#blackboard").attr("src", URL_SERVICE_GENERATE_ISSUE + "?" + new Date().getTime());
}


/**
 * Commit the issue
 */
function commit() {
    var elementTotalPoints = $("#totalPoints"),
        elementIssuePoints = $("#issuePoints");

    $.ajax({
        method: "POST",
        url: URL_SERVICE_EVALUATE_ISSUE, data: {solution: GAME_SOLUTION}, success: function (data) {
            $(elementTotalPoints).html(data.totalPoints);
            $(elementIssuePoints).html(data.points);
            generateIssue();
        }, error: function () {
            alert("error evaluate!");
            UtilsHttp.refresh();
        }
    });

    // Reset the solution
    resetSolution();
}


/**
 * Reset the solution
 */
function resetSolution() {
    var elementSolutionScreen = $("#solutionScreen");

    // Reset the game solution
    GAME_SOLUTION = "";
    $(elementSolutionScreen).empty();
}