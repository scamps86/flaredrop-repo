$(document).ready(function () {

    //Set the forms to the manager
    ManagerForm.add($("#userJoinForm"), function () {
        ManagerPopUp.dialog("Titol", "OK", [{label: "accept"}], {className: "success"});
    }, function () {
        ManagerPopUp.dialog("Titol", "KO", [{label: "accept"}], {className: "error"});
    });

    ManagerForm.add($("#userLoginForm"), function () {
        // Reload the current page
        UtilsHttp.refresh();
    }, function () {
        ManagerPopUp.dialog("Titol", "KO", [{label: "accept"}], {className: "error"});
    });

    // Define the click events
    $(".userJoinBtn").click(function (e) {
        e.preventDefault();
        ManagerPopUp.window("Join", $("#joinFormContainer"));
    });
    $(".userLoginBtn").click(function (e) {
        e.preventDefault();
        ManagerPopUp.window("Login", $("#loginFormContainer"));
    });
});