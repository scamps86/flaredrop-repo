/** HTML cursor manager */
function ManagerCursorClass() {
    // Define this manager
    var manager = this;

    // Define the cursor state
    manager.state = "default";
}

/**
 * Set the cursor icon state
 *
 * @param state [Default state by default] Cursor state: "default", "pointer", "progress", "wait", "text", "move", ...
 */
ManagerCursorClass.prototype.setState = function (state) {
    // Define this manager
    var manager = this;

    // Define the current cursor state
    manager.state = state !== undefined ? state : "default";

    // Apply the current state
    $("body").css("cursor", manager.state);
};


/**
 * Get the current mouse state
 */
ManagerCursorClass.prototype.getState = function () {
    // Define this manager
    var manager = this;

    // Return the current mouse state
    return manager.state;
};