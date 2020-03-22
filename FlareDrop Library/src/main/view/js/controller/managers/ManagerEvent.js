function ManagerEventClass() {
}


/**
 * Dispatch an event
 *
 * @param element The element that has the event to be dispatched
 * @param event Event name
 */
ManagerEventClass.prototype.dispatch = function (element, event) {
    $(element).trigger(event);
};


/**
 * Add an event to be listened. If the same event has previously added, it will be duplicated, causing a multiple callback.
 *
 * @param element The element to add the event listener
 * @param event The event name
 * @param callback The callback function (example: function(){callback(arg1, arg2);})
 */
ManagerEventClass.prototype.addEventListener = function (element, event, callback) {
    $(element).bind(event, callback);
};


/**
 * Remove a previously added event
 *
 * @param element The element who has the event to be removed
 * @param event The event name
 * @param previouslyCallback If defined, it will remove only the event that calls a previously defined callback
 */
ManagerEventClass.prototype.removeEventListener = function (element, event, previouslyCallback) {

    if (previouslyCallback !== undefined) {
        $(element).unbind(event, previouslyCallback);
    }
    else {
        $(element).unbind(event);
    }
};