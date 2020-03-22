/** Users view module class */
function ViewModule(moduleComponent) {

    // Define this view
    var view = this;

    // Get the module component
    view.moduleComponent = moduleComponent;

    // Get the module container
    view.moduleContainer = moduleComponent.containerElement;

    // Create the module element
    view.module = $('<div class="block module"></div>');

    // Append the module to the module container
    $(view.moduleContainer).append(view.module);

    // Create the folders component
    view.folders = new ComponentFolders(view.moduleComponent);

    // Create the objects component
    view.objects = new ComponentObjects(view.moduleComponent);

    // Create the divided box
    view.dividedBox = new ComponentDividedBox(view.module, 200, function () {
        view.objects.datagrid.dividedBox.reset();
    });

    // Add the folders and objects to the divided box
    if (view.moduleComponent.modeler.configuration.objects.foldersShow == 1) {
        view.dividedBox.add(view.folders.container, 20);
        view.dividedBox.add(view.objects.container, 80);
    }
    else {
        view.dividedBox.add(view.objects.container, 100);
    }
}