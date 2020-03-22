/** Flaredrop system filter. Please note that after every set, we have to define a contition (AND, OR or parenthesis) */
function VoSystemFilter() {
    this._filterData = [];
}


/**
 * Get only the objects containing this disk id
 *
 * @param diskId
 */
VoSystemFilter.prototype.setDiskId = function (diskId) {
    this._filterData.push(['diskId', diskId]);
};


/**
 * Get only the objects that are in this root id
 *
 * @param rootId
 */
VoSystemFilter.prototype.setRootId = function (rootId) {
    this._filterData.push(['rootId', rootId]);
};


/**
 * Get only the objects containing this folder
 *
 * @param folderId
 */
VoSystemFilter.prototype.setFolderId = function (folderId) {
    this._filterData.push(['folderId', folderId]);
};


/**
 * Set the language for the object list
 *
 * @param lanTag
 */
VoSystemFilter.prototype.setLanTag = function (lanTag) {
    this._filterData.push(['lanTag', lanTag]);
};


/**
 * Search a text on a property. It's not case sensitive and it won't consider the accents
 *
 * @param property The object property where we have to do the search
 * @param search The text to be searched on the corresponding property
 */
VoSystemFilter.prototype.setPropertySearch = function (property, search) {
    this._filterData.push(['propertySearch', [property, search]]);
};


/**
 * Get only the objects that matches a property
 *
 * @param property The object property where we have to do the match
 * @param value The value to match
 */
VoSystemFilter.prototype.setPropertyMatch = function (property, value) {
    this._filterData.push(['propertyMatch', [property, value]]);
};


/**
 * Get only the objects that have a property value between two values (min and max) (not logical accumulative)
 *
 * @param property The object property where we have to do the validation
 * @param min The minimum value
 * @param max The maximum value
 * @param type The value type to apply. It can be: "TEXT", "NUMBER" or "DATE". Text by default
 */
VoSystemFilter.prototype.setPropertyInner = function (property, min, max, type) {
    this._filterData.push(['propertyInner', [property, min, max, type]]);
};


/**
 * Set which property is used to sort the list
 *
 * @param property The object property to consider to apply the sorting
 * @param direction The sorting direction. It can be "ASC" or "DESC". "ASC" by default
 */
VoSystemFilter.prototype.setSortFields = function (property, direction) {
    if (direction === undefined) {
        direction = 'ASC';
    }
    this._filterData.push(['sortField', [property, direction]]);
};


/**
 * Set the current page when we are getting a paginated list. (not logical accumulative)
 *
 * @param pageIndex The page index. An empty string means that it is the first page
 */
VoSystemFilter.prototype.setPageCurrent = function (pageIndex) {
    if (pageIndex == "") {
        pageIndex = 0;
    }
    this._filterData.push(['pageCurrent', pageIndex]);
};


/**
 * Set the number of items by page when we are getting a paginated list. (not logical accumulative)
 *
 * @param numItems The number of items for each page
 */
VoSystemFilter.prototype.setPageNumItems = function (numItems) {
    this._filterData.push(['pageNumItems', numItems]);
};


/**
 * Randomize the resulting list (not logical accumulative)
 */
VoSystemFilter.prototype.setRandom = function () {
    this._filterData.push(['random']);
};


/**
 * Set AND logical condition operation
 */
VoSystemFilter.prototype.setAND = function () {
    this._filterData.push(['logical', 'AND']);
};


/**
 * Set OR logical condition operation
 */
VoSystemFilter.prototype.setOR = function () {
    this._filterData.push(['logical', 'OR']);
};


/**
 * Set open parenthesis for the logical operations
 */
VoSystemFilter.prototype.setOpenParenthesis = function () {
    this._filterData.push(['logical', '(']);
};


/**
 * Set close parenthesis for the logical operations
 */
VoSystemFilter.prototype.setCloseParenthesis = function () {
    this._filterData.push(['logical', ')']);
};


/**
 * Get the defined filter data
 *
 * @returns array Array of arrays containing the filter data like: [['filter type', 'value'], ...]
 */
VoSystemFilter.prototype.getData = function () {
    return this._filterData;
};


/**
 * Override the current filter data
 *
 * @param filterData The filter data like: [['filter type', 'value'], ...]
 */
VoSystemFilter.prototype.setData = function (filterData) {
    this._filterData = filterData;
};