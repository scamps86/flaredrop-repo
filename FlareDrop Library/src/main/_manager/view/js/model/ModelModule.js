function ModelModule(moduleName, moduleComponent) {

    // Define this model
    var model = this;

    // Set the module's name, according to the object type. (user, new, staff, product...)
    model.name = moduleName;

    // Set the module's object primary key
    model.primaryKey = model.name == "user" ? "userId" : "objectId";

    // Get the module component
    model.moduleComponent = moduleComponent;

    // Used to know if the module creation is completed or not
    model.isCreated = false;

    // Used to know if the module is selected or not
    model.isSelected = false;

    // Load the module configuration
    model.configuration = {};
    model.configuration.properties = [];
    model.configuration.list = [];

    $(ModelApplication.configuration.objects).each(function (k, v) {
        if (v.objectType == model.name) {
            model.configuration.objects = v;
        }
    });

    $(ModelApplication.configuration.filters).each(function (k, v) {
        if (v.objectType == model.name) {
            model.configuration.filters = v;
        }
    });

    $(ModelApplication.configuration.properties).each(function (k, v) {
        if (v.objectType == model.name) {
            model.configuration.properties.push(v);
        }
    });

    $(ModelApplication.configuration.list).each(function (k, v) {
        if (v.objectType == model.name) {
            model.configuration.list.push(v);
        }
    });

    // MODULE EVENTS
    model.EVENT_MODULE_CREATE_SUCCESS = "EVENT_MODULE_CREATE_SUCCESS";
    model.EVENT_FOLDERS_GET_SUCCESS = "EVENT_FOLDERS_GET_SUCCESS";
    model.EVENT_FOLDERS_GET_ERROR = "EVENT_FOLDERS_GET_ERROR";
    model.EVENT_FOLDER_REMOVE_SUCCESS = "EVENT_FOLDER_REMOVE_SUCCESS";
    model.EVENT_FOLDER_REMOVE_ERROR = "EVENT_FOLDER_REMOVE_ERROR";
    model.EVENT_FOLDER_GET_SUCCESS = "EVENT_FOLDER_GET_SUCCESS";
    model.EVENT_FOLDER_GET_ERROR = "EVENT_FOLDER_GET_ERROR";
    model.EVENT_FOLDER_MOVE_SUCCESS = "EVENT_FOLDER_MOVE_SUCCESS";
    model.EVENT_FOLDER_MOVE_ERROR = "EVENT_FOLDER_MOVE_ERROR";
    model.EVENT_FOLDER_SORT_SUCCESS = "EVENT_FOLDER_SORT_SUCCESS";
    model.EVENT_FOLDER_SORT_ERROR = "EVENT_FOLDER_SORT_ERROR";
    model.EVENT_FOLDER_SET_SUCCESS = "EVENT_FOLDER_SET_SUCCESS";
    model.EVENT_FOLDER_SET_ERROR = "EVENT_FOLDER_SET_ERROR";
    model.EVENT_OBJECT_GET_SUCCESS = "EVENT_OBJECT_GET_SUCCESS";
    model.EVENT_OBJECT_GET_ERROR = "EVENT_OBJECT_GET_ERROR";
    model.EVENT_OBJECT_SET_SUCCESS = "EVENT_OBJECT_SET_SUCCESS";
    model.EVENT_OBJECT_SET_ERROR = "EVENT_OBJECT_SET_ERROR";
    model.EVENT_OBJECTS_GET_SUCCESS = "EVENT_OBJECTS_GET_SUCCESS";
    model.EVENT_OBJECTS_GET_ERROR = "EVENT_OBJECTS_GET_ERROR";
    model.EVENT_OBJECTS_REMOVE_SUCCESS = "EVENT_OBJECTS_REMOVE_SUCCESS";
    model.EVENT_OBJECTS_REMOVE_ERROR = "EVENT_OBJECTS_REMOVE_ERROR";
    model.EVENT_OBJECTS_COLUMNS_GET_SUCCESS = "EVENT_OBJECTS_COLUMNS_GET_SUCCESS";
    model.EVENT_OBJECTS_COLUMNS_GET_ERROR = "EVENT_OBJECTS_COLUMNS_GET_ERROR";
    model.EVENT_OBJECTS_MOVE_SUCCESS = "EVENT_OBJECTS_MOVE_SUCCESS";
    model.EVENT_OBJECTS_MOVE_ERROR = "EVENT_OBJECTS_MOVE_ERROR";
    model.EVENT_OBJECTS_LINK_SUCCESS = "EVENT_OBJECTS_LINK_SUCCESS";
    model.EVENT_OBJECTS_LINK_ERROR = "EVENT_OBJECTS_LINK_ERROR";
    model.EVENT_OBJECTS_UNLINK_SUCCESS = "EVENT_OBJECTS_UNLINK_SUCCESS";
    model.EVENT_OBJECTS_UNLINK_ERROR = "EVENT_OBJECTS_UNLINK_ERROR";
    model.EVENT_OBJECTS_DUPLICATE_SUCCESS = "EVENT_OBJECTS_DUPLICATE_SUCCESS";
    model.EVENT_OBJECTS_DUPLICATE_ERROR = "EVENT_OBJECTS_DUPLICATE_ERROR";
    model.EVENT_PICTURES_REMOVE_SUCCESS = "EVENT_PICTURES_REMOVE_SUCCESS";
    model.EVENT_PICTURES_REMOVE_ERROR = "EVENT_PICTURES_REMOVE_ERROR";
    model.EVENT_FILES_REMOVE_SUCCESS = "EVENT_FILES_REMOVE_SUCCESS";
    model.EVENT_FILES_REMOVE_ERROR = "EVENT_FILES_REMOVE_ERROR";
    model.EVENT_FILE_SET_PRIVATE_SUCCESS = "EVENT_FILE_SET_PRIVATE_SUCCESS";
    model.EVENT_FILE_SET_PRIVATE_ERROR = "EVENT_FILE_SET_PRIVATE_ERROR";

    // Service URL definitions
    model.serviceFoldersGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FoldersGet";
    model.serviceFolderGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FolderGet";
    model.serviceFolderSetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FolderSet";
    model.serviceFolderRemoveUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FolderRemove";
    model.serviceFoldersSortUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FoldersSort";
    model.serviceFolderMoveUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FolderMove";
    model.serviceObjectGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectGet";
    model.serviceObjectSetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectSet";
    model.serviceObjectsGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsGet";
    model.serviceObjectsRemoveUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsRemove";
    model.serviceObjectsMoveUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsMove";
    model.serviceObjectsLinkUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsLink";
    model.serviceObjectsUnlinkUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsUnlink";
    model.serviceObjectsDuplicateUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsDuplicate";
    model.serviceObjectsColumnsGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsColumnsGet";
    model.serviceObjectsCsvGetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "ObjectsCsvGet";
    model.serviceFilesSetUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FilesSet";
    model.serviceFilesRemoveUrl = GLOBAL_URL_WEB_SERVICE_BASE + "FilesRemove";
    model.serviceFilePrivateKeyGenerate = GLOBAL_URL_WEB_SERVICE_BASE + "FilePrivateKeyGenerate";
    model.serviceFilePrivateSet = GLOBAL_URL_WEB_SERVICE_BASE + "FilePrivateSet";
    model.serviceFileGet = GLOBAL_URL_WEB_SERVICE_BASE + "FileGet";

    // Module states
    model.isRefreshing = false; // Full module refresh from db
    model.isGettingObjects = false; // When getting object list from db
    model.isGettingObject = false; // When getting an object from db
    model.isGettingFolder = false; // When getting a folder from db
    model.isSettingFolder = false; // When setting a folder on db
    model.isGettingFolders = false; // When getting the folder list from db
    model.isRemovingFolder = false; // When removing a folder from db
    model.isRemovingFolderPictures = false; // When removing folder pictures
    model.isRemovingFolderFiles = false; // When removing folder files
    model.isRemovingObjects = false; // When removing objects on db
    model.isMovingObjects = false; // When moving objects from a folder to another one on db
    model.isLinkingObjects = false; // When linking objects to a folder on db
    model.isUnlinkingObjects = false; // When unlinking objects to a folder on db
    model.isDuplicatingObjects = false; // When duplicating objects on db
    model.isGettingColumnsObjects = false; // When is getting the columns of a list of objects
    model.isMovingFolder = false; // When moving a folder from db
    model.isSortingFolders = false; // When sorting folders from db
    model.isSettingObject = false; // When setting an object on db
    model.isRemovingPicturesObject = false; // When removing object pictures
    model.isRemovingFilesObject = false; // When removing object files
    model.isSettingFilePrivate = false; // When setting a file as private or not

    // Ajax options
    model.getObjectsAgain = false; // If true, when the get object list operation finishes, it will recall it again
    model.getFoldersAgain = false; // If true, when the get object folder list operation finishes, it will recall it again
    model.getObjectAgain = false; // If true, when the get object object operation finishes, it will recall it again
    model.getFolderAgain = false; // If true, when the get object folder operation finishes, it will recall it again
    model.getObjectsColumnsAgain = false; // If true, when the get objects columns operation finishes, it will recall it again

    // Current data
    model.lastRequestData = null; // The last ajax request received data
    model.selectedDisk = null; // The selected disk
    model.selectedFolder = null; // The selected folder object from the folder tree
    model.selectedParentFolder = null; // The selected folder parent object from the folder tree
    model.selectedObjects = []; // The datagrid selected objects
    model.selectedPeriod = null; // The selected period [dd/mm/yyyy, dd/mm/yyyy] initial date - actual date. Null means no period selected
    model.copiedItems = []; // The items that are copied in this module
    model.pageNumItems = 200; // The total objects to show for each page in the datagrid
    model.currentPage = 0; // The current datagrid selected page

    model.foldersList = []; // The last object folder list getted from db
    model.folderGet = {}; // The last object folder object getted from db
    model.objectsList = []; // The last object list getted from db
    model.objectGet = {}; // The last object getted from db
    model.objectsColumnsGet = []; // The last objects columns getted from the db
    model.droppedFolderId = null; // The folder id where the objects are dropped

    model.filterTextSearch = ""; // The text to apply on the search filter

    model.sortObjectsBy = ["creationDate", "DESC"]; // Current object sort by

    // Current ajax request send data
    model.ajaxFolderGet = null;
    model.ajaxFolderSet = null;
    model.ajaxFoldersGet = null;
    model.ajaxFolderRemove = null;
    model.ajaxFolderMove = null;
    model.ajaxFoldersSort = null;
    model.ajaxObjectsGet = null;
    model.ajaxGet = null;
    model.ajaxSet = null;
    model.ajaxRemove = null;
    model.ajaxMove = null;
    model.ajaxLink = null;
    model.ajaxUnlink = null;
    model.ajaxDuplicate = null;
    model.ajaxFilesRemove = null;
    model.ajaxFileSetPrivate = null;

    // Another states
    model.attachOrEdit = null; // Action when the object / folder is getted ("EDIT", "ATTACH", "ATTACH_PICTURES", "ATTACH_FILES")
}