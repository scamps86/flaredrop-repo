/**
 * *IMPORTANT: This class should import the Google Maps API imported.
 *
 * Google Maps utilities
 */
function UtilsGoogleMapsClass() {

    // Define this utils
    var utils = this;

    /* MAP TYPES */
    utils.MAP_TYPE_ROADMAP = "";
    utils.MAP_TYPE_SATELLITE = "";
    utils.MAP_TYPE_HYBRID = "";
    utils.MAP_TYPE_TERRAIN = "";
}


/**
 * *IMPORTANT This method must be called when window load is done (not document ready)
 *
 * Generates a Google Map and fit it in a specified DOM element
 *
 * @param containerElement The container DOM element that the Generated Google Map will be placed
 * @param latitude The map latitude
 * @param longitude The map longitude
 * @param zoom The map zoom. 16 by default
 * @param contentHtml The HTML content that will be placed on the info window. The info windoe won't be shown only if this content is not defined
 * @param mapType Specify the map type. Roadmap by default
 */
UtilsGoogleMapsClass.prototype.generateMap = function (containerElement, latitude, longitude, zoom, contentHtml, mapType) {

    // Define this utils
    var utils = this;

    // Validate if the Google Maps library is loaded
    if (typeof google === "undefined") {

        utils.loadLibrary(function () {
            utils.generateMap(containerElement, latitude, longitude, zoom, contentHtml, mapType);
        });
        return;
    }

    // Generate default properties
    if (zoom === undefined) {
        zoom = 16;
    }

    if (contentHtml === undefined) {
        contentHtml = "";
    }

    if (mapType === undefined) {
        mapType = this.MAP_TYPE_ROADMAP;
    }

    // A jQuery DOM element doesn't work in Google Maps. So we have to get it by its id
    containerElement = document.getElementById($(containerElement).attr("id"));

    // Generate the Google Map
    var position = new google.maps.LatLng(latitude, longitude);

    var options = {
        zoom: zoom,
        center: position,
        scrollwheel: false,
        mapTypeId: mapType
    };

    var map = new google.maps.Map(containerElement, options);

    var marker = new google.maps.Marker({
        position: position,
        map: map
    });

    if (contentHtml != "") {
        var infoWindow = new google.maps.InfoWindow({
            content: contentHtml
        });

        infoWindow.open(map, marker);
    }

};


/**
 * Load the Google Maps library
 */
UtilsGoogleMapsClass.prototype.loadLibrary = function (action) {

    // Define this utils
    var utils = this;

    // Get the Google Maps library script
    $.getScript("https://www.google.com/jsapi", function () {
        google.load("maps", "3", {
            other_params: "sensor=false",
            callback: function () {
                utils._libraryLoaded(function () {

                    action.apply();
                });
            }
        });
    });
};


/**
 * Called when the Google Maps library is loaded
 */
UtilsGoogleMapsClass.prototype._libraryLoaded = function (action) {
    // Define this utils
    var utils = this;

    /* Define map types */
    utils.MAP_TYPE_ROADMAP = google.maps.MapTypeId.ROADMAP;
    utils.MAP_TYPE_SATELLITE = google.maps.MapTypeId.SATELLITE;
    utils.MAP_TYPE_HYBRID = google.maps.MapTypeId.HYBRID;
    utils.MAP_TYPE_TERRAIN = google.maps.MapTypeId.TERRAIN;

    // Call the action
    if (action !== undefined) {

        action.apply();
    }
};