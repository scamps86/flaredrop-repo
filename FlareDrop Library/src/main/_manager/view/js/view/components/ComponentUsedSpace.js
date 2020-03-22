function ComponentUsedSpace() {

    // Define this component
    var component = this;

    // Define the component's container
    component.container = $('<div id="componentUsedSpace"></div>');

    // Define the top container
    component.topContainer = $('<div class="row" id="componentUsedSpaceTopContainer"></div>');

    // Define bar container
    component.barContainer = $('<div class="row" id="componentUsedSpaceBarContainer"></div>');
    component.barPictures = $('<div class="transitionSlow componentUsedSpaceBar" id="componentUsedSpaceBarPictures"></div>');
    component.barFiles = $('<div class="transitionSlow componentUsedSpaceBar" id="componentUsedSpaceBarFiles"></div>');

    // Define legend container
    component.legendContainer = $('<div id="componentUsedSpaceLegendContainer" class="row"></div>');
    component.legendPictures = $('<p id="componentUsedSpaceLegendPictures"></p>');
    component.legendFiles = $('<p id="componentUsedSpaceLegendFiles"></p>');
    component.legendRequest = $('<p id="componentUsedSpaceBarRequest">' + ModelApplication.literals.get("REQUEST_SPACE", "ManagerApp") + '</p>');

    // Do the appends
    $(component.barContainer).append(component.barPictures, component.barFiles);
    $(component.legendContainer).append(component.legendPictures, component.legendFiles, component.legendRequest);
    $(component.container).append(component.topContainer, component.barContainer, component.legendContainer);


    // Add the event listeners
    ManagerEvent.addEventListener(ControlApplication, ModelApplication.EVENT_GET_FILES_USED_SPACE_SUCCESS, function () {
        component.update();
    });

    ManagerEvent.addEventListener(ControlApplication, ModelApplication.EVENT_GET_PICTURES_USED_SPACE_SUCCESS, function () {
        component.update();
    });

    $(component.legendRequest).click(function () {
        ManagerPopUp.dialog(ModelApplication.literals.get("REQUEST_SPACE", "ManagerApp"), ModelApplication.literals.get("REQUEST_SPACE_MESSAGE", "ManagerApp"), [
                {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
            ], {className: "info"}
        );
    });

    // Reset the component
    component.update();
}


/**
 * Update the component
 */
ComponentUsedSpace.prototype.update = function () {
    // Define this component
    var component = this;

    // Get the total used space
    var totalUsedSpace = UtilsUnits.bytesToMegabytes(ModelApplication.dataBasePicturesUsedSpace + ModelApplication.dataBaseFilesUsedSpace);

    // Calculate percentages
    var imagesPercent = UtilsUnits.bytesToMegabytes(ModelApplication.dataBasePicturesUsedSpace) * 100 / ModelApplication.configuration.global.allowedSpace;
    var filesPercent = UtilsUnits.bytesToMegabytes(ModelApplication.dataBaseFilesUsedSpace) * 100 / ModelApplication.configuration.global.allowedSpace;

    // Update top container contents
    $(component.topContainer).html("<p>" + ModelApplication.literals.get("USED_SPACE", "ManagerApp") + ': <span class="fontBold">' + totalUsedSpace + " MB / " + UtilsFormatter.setDecimals(ModelApplication.configuration.global.allowedSpace, 2) + " MB</span></p>");

    // Update the bar container contents
    $(component.barPictures).css({"width": imagesPercent + "%"});
    $(component.barFiles).css({"width": filesPercent + "%"});

    // Update the legend bar container contents
    $(component.legendPictures).html("<span></span>" + ModelApplication.literals.get("LEGEND_PICTURES", "ManagerApp") + ' (' + UtilsUnits.bytesToMegabytes(ModelApplication.dataBasePicturesUsedSpace) + " MB)");
    $(component.legendFiles).html("<span></span>" + ModelApplication.literals.get("LEGEND_FILES", "ManagerApp") + ' (' + UtilsUnits.bytesToMegabytes(ModelApplication.dataBaseFilesUsedSpace) + " MB)");
};