/**
 * Component tree
 *
 * @param parentElement The parent element where the tree will be appended
 * @param id The tree component ID. This id is mandatory
 * @param data The tree nodes data object similar than this: [{nodeId : 1, nodeLabel : "test", nodeChildren : [{...}, {...}], ...}]
 * @param nodeIdKey The tree node data property name that indicates its id. "nodeId" by default
 * @param nodeLabelKey The tree node data property name that indicates its label. "nodeLabel" by default
 * @param nodeChildrenKey The tree node data property name that indicates its children array. "nodeChildren" by default
 * @param options The tree options object where we can configure: "sortable[true:false]", "dragRevertTime[200 by default]", "dragOpacity[0.5 by default]", "dragCursorAt[{top : 10, left : -15} by default]", "dragAutoExpandTime[1000 by default]",
 * "itemDropAccept" ".componentDataGridRow" by default
 * @param events The tree event actions object: "onSelect[node]", "onUnselect", "onSort", "onOuterItemDrop[outerItemHtml, nodeId]", "onDragStart[node]", "onDblClick[node]"
 */
function ComponentTree(parentElement, id, data, nodeIdKey, nodeLabelKey, nodeChildrenKey, options, events) {

    // Define this component
    var component = this;

    // Set the parent element
    component.parentElement = parentElement;

    // Set the component id
    component.id = id;

    // Set the tree nodes data
    component.data = data;

    // Set the tree options
    options = options === undefined ? {} : options;
    component.sortable = options.sortable === undefined ? true : options.sortable;
    component.dragRevertTime = options.dragRevertTime === undefined ? 200 : options.dragRevertTime;
    component.dragOpacity = options.dragOpacity === undefined ? 0.5 : options.dragOpacity;
    component.dragCursorAt = options.dragCursorAt === undefined ? {
        top: 10,
        left: -15
    } : options.dragCursorAt;
    component.dragAutoExpandTime = options.dragAutoExpandTime === undefined ? 1000 : options.dragAutoExpandTime;
    component.itemDropAccept = options.itemDropAccept === undefined ? ".componentDataGridRow" : options.itemDropAccept;

    // Set the tree events
    events = events === undefined ? {} : events;
    component.onSelect = events.onSelect;
    component.onUnselectAll = events.onUnselectAll;
    component.onSort = events.onSort;
    component.onOuterItemDrop = events.onOuterItemDrop;
    component.onDragStart = events.onDragStart;
    component.onDblClick = events.onDblClick;

    // Set the node keys
    component.nodeIdKey = nodeIdKey === undefined ? "nodeId" : nodeIdKey;
    component.nodeLabelKey = nodeLabelKey === undefined ? "nodeLabel" : nodeLabelKey;
    component.nodeChildrenKey = nodeChildrenKey === undefined ? "nodeChildren" : nodeChildrenKey;

    // Set state to know if a tree item is dragging or not
    component.isDragging = false;

    // Last sorted node
    component.lastSortedNode = null;

    // Define the component's container
    component.container = $('<ul id="' + component.id + '" class="componentTree"></ul>');

    // Update the tree's data and regenerate it
    component.updateData(data);

    // Collapse all nodes
    component.collapseAll();

    // Append the component to the parent element
    $(component.parentElement).append(component.container);
}


/**
 * Update the tree with a new data
 *
 * @param data The tree nodes data object similar than this: [{nodeId : 1, nodeLabel : "test", nodeChildren : [{...}, {...}], ...}]
 */
ComponentTree.prototype.updateData = function (data) {

    // Define this component
    var component = this;

    // Update the tree nodes data
    component.data = data;

    // Update the tree's html code
    var html = component._generateHtml(data);

    $(component.container).html(html);

    // Update the tree's indexes
    component._updateNodeIndexes();

    // Make all nodes sortables if enabled
    if (component.sortable) {

        var sortOptions = {
            revert: component.dragRevertTime,
            opacity: component.dragOpacity,
            connectWith: "#" + component.id + ", #" + component.id + " ul.componentTreeNodeUl",
            distance: 15,
            cursor: "move",
            cursorAt: component.dragCursorAt,
            containment: "window",
            placeholder: "componentTreePlaceholder",
            tolerance: "intersect",
            start: function (e, ui) {
                component.lastSortedNode = component.getNode($(ui.item).attr("nodeId"));

                component.isDragging = true;

                if (component.onDragStart !== undefined) {
                    component.onDragStart.apply(null, [component.lastSortedNode]);
                }
            },
            update: function () {
                component._updateNodeIndexes();

                // Call the sort action if defined
                if (component.onSort !== undefined && component.isDragging) {

                    component.isDragging = false;
                    component.onSort.apply();
                }
            }
        };

        $(component.container).sortable(sortOptions);
        $(component.container).find("ul.componentTreeNodeUl").sortable(sortOptions);
    }

    // Get the tree nodes
    var treeNodes = $(component.container).find("li.componentTreeNodeLi");

    // Get the tree labels
    var treeLabels = $(component.container).find("div.componentTreeNodeLabel");

    // Define each node select click event
    $(treeLabels).click(function () {

        component.selectNode($(this.parentElement).attr("nodeId"));
    });

    // Define the node events
    $(treeNodes).mouseenter(function () {

        var li = this;
        var nodeId = $(this).attr("nodeId");

        if (component.isDragging) {
            $(li).addClass("componentTreeHover");
        }

        setTimeout(function () {
            if (component.isDragging && $(li).hasClass("componentTreeHover")) {

                component.expandNode(nodeId);
            }
        }, component.dragAutoExpandTime);
    });

    $(treeNodes).mouseleave(function () {
        $(this).removeClass("componentTreeHover");
    });

    $(treeNodes).dblclick(function () {
        if (component.onDblClick !== undefined) {
            component.onDblClick.apply(null, [component.getSelectedNode()]);
        }
    });

    // Define the item droppable
    $(treeLabels).droppable({
        drop: function (event, ui) {

            // Call the drop action if defined
            if (component.onOuterItemDrop !== undefined) {
                component.onOuterItemDrop.apply(null, [ui.draggable, $(event.target).parent("li").attr("nodeId")]);
            }
        },
        hoverClass: "componentTreeNodeLiDropHover",
        tolerance: "pointer",
        accept: component.itemDropAccept
    });
};


/**
 * Verify if a node is expanded or not
 *
 * @param nodeId The node id to verify
 *
 * @returns boolean
 */
ComponentTree.prototype.isNodeExpanded = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    // Toogle the node
    if (node != null) {

        return $(node).hasClass("componentTreeNodeExpanded");
    }

    return false;
};


/**
 * Verify if a node is selected or not
 *
 * @param nodeId The node id to verify
 *
 * @returns boolean
 */
ComponentTree.prototype.isNodeSelected = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    // Toogle the node
    if (node != null) {

        // Get the node label
        var label = $($(node).find("div.componentTreeNodeLabel"))[0];

        return $(label).hasClass("nodeSelected");
    }

    return false;
};


/**
 * Toogle a node (expand or minimize) only if this one has childrens
 *
 * @param nodeId The node id to toogle
 */
ComponentTree.prototype.toogleNode = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    // Toogle the node
    if (node != null) {
        if ($(node).hasClass("componentTreeNodeExpanded")) {
            component.collapseNode(nodeId);
        }
        else {
            component.expandNode(nodeId);
        }
    }

    // Collapse the nodes that not have children
    $(component.container).find("li.componentTreeNodeEmpty").parent().parent().find("li.componentTreeNodeLi, ul.componentTreeNodeUl, div.componentTreeNodeLabel").removeClass("componentTreeNodeExpanded");
};


/**
 * Collapse a node
 *
 * @param nodeId The node to collapse
 */
ComponentTree.prototype.collapseNode = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    // Toogle the node
    if (node != null) {
        $(node).removeClass("componentTreeNodeExpanded");
        $(node).find("ul.componentTreeNodeUl").removeClass("componentTreeNodeExpanded");
        $(node).find("div.componentTreeNodeLabel").removeClass("componentTreeNodeExpanded");
    }
};


/**
 * Expand a node
 *
 * @param nodeId The node to collapse
 */
ComponentTree.prototype.expandNode = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    // Toogle the node
    if (node != null) {
        $(node).addClass("componentTreeNodeExpanded");

        var ul = $(node).find("ul.componentTreeNodeUl");

        if (ul.length > 0) {
            $(ul[0]).addClass("componentTreeNodeExpanded");
        }

        $($(node).find("div.componentTreeNodeLabel")[0]).addClass("componentTreeNodeExpanded");
    }
};


/**
 * Unselect all selected nodes
 */
ComponentTree.prototype.unselectAllNodes = function () {

    // Define this component
    var component = this;

    $(component.container).find("div.componentTreeNodeLabel").removeClass("nodeSelected");

    // Call the unselection action if defined
    if (component.onUnselectAll !== undefined) {
        component.onUnselectAll.apply();
    }
};


/**
 * Select a node and expand it
 *
 * @param nodeId The node id to be selected
 * @param expand Boolean telling if the node is also expanded or not
 */
ComponentTree.prototype.selectNode = function (nodeId, expand) {

    // Define this component
    var component = this;

    // Set expand false by default
    expand = expand === undefined ? false : expand;

    // Get the node
    var node = component.getNodeHtml(nodeId);

    if (node != null) {

        // Toogle if the node is currently selected
        if (component.isNodeSelected(nodeId)) {
            component.toogleNode(nodeId);
        }

        // Unselect all nodes manually to prevent dispatching the unselect all action
        $(component.container).find("div.componentTreeNodeLabel").removeClass("nodeSelected");

        // Get the node label
        var label = $($(node).find("div.componentTreeNodeLabel"))[0];

        $(label).addClass("nodeSelected");

        // Expand the node parents
        $(node).parents("li.componentTreeNodeLi, ul.componentTreeNodeUl, div.componentTreeNodeLabel").addClass("componentTreeNodeExpanded");

        // Expand the current node only if it's requested
        if (expand) {
            component.expandNode(nodeId);
        }

        // Call the selection action if defined
        if (component.onSelect !== undefined) {
            component.onSelect.apply(null, [component.getNode(nodeId)]);
        }
    }
};


/**
 * Expand all nodes
 */
ComponentTree.prototype.expandAll = function () {

    // Define this component
    var component = this;

    // Expand all nodes
    $(component.container).find("li, ul, div.nodeLabel").addClass("componentTreeNodeExpanded");

    // Collapse the nodes that don't have children
    $(component.container).find("li.componentTreeNodeEmpty").parent().parent().find("li.componentTreeNodeLi, ul.componentTreeNodeUl, div.componentTreeNodeLabel").removeClass("componentTreeNodeExpanded");
};


/**
 * Collapse all nodes
 */
ComponentTree.prototype.collapseAll = function () {

    // Define this component
    var component = this;

    $(component.container).find("li.componentTreeNodeLi, ul.componentTreeNodeUl, div.componentTreeNodeLabel").removeClass("componentTreeNodeExpanded");
};


/**
 * Get the tree node HTML element
 *
 * @param nodeId The node id to get
 *
 * @returns The HTML element
 */
ComponentTree.prototype.getNodeHtml = function (nodeId) {

    // Define this component
    var component = this;

    // Define the resulting node
    var node = null;

    $(component.container).find("li.componentTreeNodeLi").each(function (k, n) {
        if ($(n).attr("nodeId") == nodeId) {

            node = n;
        }
    });

    return node;
};


/**
 * Get the node object data
 *
 * @param nodeId The node id to get
 * @returns
 */
ComponentTree.prototype.getNode = function (nodeId) {

    // Define this component
    var component = this;

    // Scan all nodes and get the selected one
    return component._getNodeData(nodeId, component.data);
};


/**
 * Get the selected node HTML element
 *
 * @returns The HTML element
 */
ComponentTree.prototype.getSelectedNodeHtml = function () {

    // Define this component
    var component = this;

    // Get the selected node
    var node = $(component.container).find("div.componentTreeNodeLabel.nodeSelected");

    if (node.length == 1) {

        return $(node[0].parentElement);
    }

    return null;
};


/**
 * Get the selected node object data
 *
 * @returns The node object data
 */
ComponentTree.prototype.getSelectedNode = function () {

    // Define this component
    var component = this;

    // Get the selected node
    var node = $(component.container).find("div.componentTreeNodeLabel.nodeSelected");

    if (node.length == 1) {

        return component.getNode($(node[0]).parent().attr("nodeId"));
    }

    return null;
};


/**
 * Get an object containing the node indexes information in the format: nodeId -> nodeIndex
 *
 * @returns Object Associative array
 */
ComponentTree.prototype.getNodeIndexes = function () {

    // Define this component
    var component = this;

    // The array to store the info
    var info = {};

    $(component.container).find("li.componentTreeNodeLi").each(function (k, n) {

        info[$(n).attr("nodeId")] = $(n).attr("nodeIndex");

    });

    return info;
};


/**
 * Get a parent node object data from a node children. If the node not exists or don't have any parent, a null object will be returned
 *
 * @param nodeId The children node id
 *
 * @returns The node object data
 */
ComponentTree.prototype.getParentNode = function (nodeId) {

    // Define this component
    var component = this;

    // The parent node
    var parentNode = null;

    // Get the node HTML element
    var li = component.getNodeHtml(nodeId);

    // Get the node parent
    var parents = $(li).parents("li.componentTreeNodeLi");

    if (parents.length > 0) {

        parentNode = component.getNode($(parents[0]).attr("nodeId"));
    }

    // Return the parent node object data
    return parentNode;
};


/**
 * Get the node children levels
 *
 * @param nodeId The node id
 *
 * @returns Number
 */
ComponentTree.prototype.getNodeChildrenLevels = function (nodeId) {

    // Define this component
    var component = this;

    // Get the node HTML element
    var node = component.getNodeHtml(nodeId);

    // Set the level ul to find
    var levelUl = "ul";

    // Count the levels
    var levels = -1;

    // Count the levels
    while ($(node).find(levelUl).length > 0) {

        levelUl += " ul";
        levels++;
    }

    return levels;
};


/**
 * Get the tree children levels
 *
 * @returns Number
 */
ComponentTree.prototype.getChildrenLevels = function () {

    // Define this component
    var component = this;

    // Set the level ul to find
    var levelUl = "ul";

    // Count the levels
    var levels = -1;

    // Count the levels
    while ($(component.container).find(levelUl).length > 0) {

        levelUl += " ul";
        levels++;
    }

    return levels;
};


/**
 * Recursive method that generates all tree HTML code
 *
 * @param data The level node data
 *
 * @returns String The level HTML code
 */
ComponentTree.prototype._generateHtml = function (data) {

    // Define this component
    var component = this;

    // Define the variable to store the html code
    var html = "";

    $(data).each(function (k, n) {

        html += '<li class="componentTreeNodeLi" nodeId="' + n[component.nodeIdKey] + '"><div class="componentTreeNodeLabel">';
        html += '<div class="componentTreeNodeIcon"></div><p class="componentTreeNodeP">' + UtilsString.htmlSpecialChars(n[component.nodeLabelKey]) + '</p></div><ul class="componentTreeNodeUl">';

        // If the node has children
        if (n[component.nodeChildrenKey] !== undefined) {
            if (n[component.nodeChildrenKey].length > 0) {
                html += component._generateHtml(n[component.nodeChildrenKey]);
            }
        }
        else {
            html += '<li class="componentTreeNodeEmpty"></li>';
        }

        html += '</ul></li>';
    });

    return html;
};


/**
 * Update the node indexes on the HTML code
 */
ComponentTree.prototype._updateNodeIndexes = function () {

    // Define this component
    var component = this;

    // Loop the node children level
    $(component.container).find("li.componentTreeNodeLi").each(function (k, n) {

        $(n).attr("nodeIndex", k);
    });
};


/**
 * Recursive method to scan all nodes and get the requested one
 *
 * @param nodeId The node id to get
 * @param data The level node data object
 *
 * @returns The node if it's found, and null if not
 */
ComponentTree.prototype._getNodeData = function (nodeId, data) {

    // Define this component
    var component = this;

    // The node to be returned
    var node = null;

    // Loop the node children level
    $(data).each(function (k, n) {
        if (n[component.nodeIdKey] == nodeId) {
            node = n;
            return false;
        }
        else if (n[component.nodeChildrenKey] !== undefined) {
            if (n[component.nodeChildrenKey].length > 0) {

                node = component._getNodeData(nodeId, n[component.nodeChildrenKey]);

                if (node != null) {
                    return false;
                }
            }
        }
    });

    return node;
};