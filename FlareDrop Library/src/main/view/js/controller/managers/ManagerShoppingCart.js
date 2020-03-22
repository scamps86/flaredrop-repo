/**
 * Manager shopping cart
 */
function ManagerShoppingCartClass() {
    // Define this manager
    var manager = this;

    // Define private vars
    manager._cookieName = "fd_shcrt";
    manager._cart = {};
    manager._parentElement = "";
    manager._unitsElement = "";
    manager._totalPriceElement = "";
    manager._currency = "€";
    manager._shippingPrice = 0;
    manager._afterRenderCallback = null;
    manager._literals = {
        units: 'Units',
        price: 'Price',
        taxes: 'Taxes',
        remove: 'Remove',
        cancel: 'Cancel',
        alert: 'Alert!',
        emptyCart: 'Empty cart',
        shippingPrice: 'Shipping price',
        totalPrice: 'Total price',
        sureEmptyCart: 'Sure you want to empty your cart?',
        sureRemoveItem: 'Sure you want to remove the selected item?',
        noItems: 'Your cart is empty!'
    };
}


/**
 * Define the parent element. It can be more than one element id by respecting the css encoding. This is mandatory to render the shopping cart
 *
 * @param parentElement The parent element class or id
 */
ManagerShoppingCartClass.prototype.setParentElement = function (parentElement) {
    // Define this manager
    var manager = this;
    manager._parentElement = parentElement;

    // Update the cart
    manager.render();
};


/**
 * Define the units element. It can be more than one element id by respecting the css encoding. It is used to see the shopping cart units
 *
 * @param unitsElement The parent element class or id
 */
ManagerShoppingCartClass.prototype.setUnitsElement = function (unitsElement) {
    // Define this manager
    var manager = this;
    manager._unitsElement = unitsElement;

    // Update the cart
    manager.render();
};


/**
 * Define the units element. It can be more than one element id by respecting the css encoding. It is used to see the shopping cart units
 *
 * @param unitsElement The parent element class or id
 */
ManagerShoppingCartClass.prototype.setTotalPriceElement = function (totalPriceElement) {
    // Define this manager
    var manager = this;
    manager._totalPriceElement = totalPriceElement;

    // Update the cart
    manager.render();
};


/**
 * Set the price currency. € by default.
 *
 * @param currency The price currency
 */
ManagerShoppingCartClass.prototype.setCurrency = function (currency) {
    // Define this manager
    var manager = this;
    manager._currency = currency;

    // Update the cart
    manager.render();
};


/**
 * Set the shipping price. 0 by default
 *
 * @param shippingPrice The shipping price
 */
ManagerShoppingCartClass.prototype.setShippingPrice = function (shippingPrice) {
    // Define this manager
    var manager = this;
    manager._shippingPrice = parseFloat(shippingPrice);

    // Update the cart
    manager.render();
};


/**
 * Set the after render callback
 *
 * @param callback The callback function
 */
ManagerShoppingCartClass.prototype.setAfterRenderCallback = function (callback) {
    // Define this manager
    var manager = this;
    manager._afterRenderCallback = callback;
};


/**
 * Get the cart list
 *
 * @returns items list array
 */
ManagerShoppingCartClass.prototype.getCart = function () {
    // Define this manager
    var manager = this;

    // Get the cookie
    manager._cart = UtilsConversion.jsonToObject(UtilsConversion.base64Decode(UtilsCookie.get(manager._cookieName)));

    // Return the cart
    manager._cart = manager._cart == null ? {} : manager._cart;
    return manager._cart;
};


/** Add or modify a shopping cart item.
 *
 * @param item Object containing this fields: itemId, title, price, units, taxes, url, pictureUrl (manually)
 *
 * @returns boolean If the item is added or not
 */
ManagerShoppingCartClass.prototype.setItem = function (item) {
    // Define this manager
    var manager = this;

    if (!manager.validateItem(item)) {
        return false;
    }

    // Get the cart
    manager.getCart();

    // Be sure that the item units are an integer
    if (!isNaN(item.units)) {
        item.units = Math.floor(item.units);
    }

    // If the item already exists, increase the units
    if (manager._cart["_" + item.itemId] !== undefined) {
        manager._cart["_" + item.itemId].units++;
    }
    else {
        // Limit to 40 different objects
        var i = 0;

        for (k in manager._cart) {
            i++;
        }

        if (i > 40) {
            return false;
        }

        // Add the new item
        manager._cart["_" + item.itemId] = item;
    }

    // Update the cart
    manager.updateCart();

    // Return product added boolean
    return true;
};


/**
 * Get a shopping cart item. If not exists it will return null
 *
 * @param itemId The item id
 *
 * @returns The item object
 */
ManagerShoppingCartClass.prototype.getItem = function (itemId) {
    // Define this manager
    var manager = this;

    // Get the cart
    manager.getCart();

    // Get the item
    return manager._cart["_" + itemId] !== undefined && manager.validateItem(manager._cart["_" + itemId]) ? manager._cart["_" + itemId] : null;
};


/**
 * Remove an item from the shopping cart
 *
 * @param itemId The item id
 */
ManagerShoppingCartClass.prototype.removeItem = function (itemId) {
    // Define this manager
    var manager = this;

    // Get the cart
    manager.getCart();

    // Remove the item
    delete manager._cart["_" + itemId];

    // Update the cart
    manager.updateCart();
};


/**
 * Get a shopping cart item property
 *
 * @param itemId The item id
 * @param property The property to get
 *
 * @returns The property value
 */
ManagerShoppingCartClass.prototype.getItemProperty = function (itemId, property) {
    // Define this manager
    var manager = this;

    // Get the item
    var item = manager.getItem(itemId);

    // Return the item property
    return item != null && item[property] !== undefined ? item[property] : '';
};


/**
 * Set a shopping cart item property
 *
 * @param itemId The item id
 * @param property The item property
 * @param value The new item property value
 * @param type The value type: STRING, FLOAT, INTEGER, BOOLEAN. STRING by default
 */
ManagerShoppingCartClass.prototype.setItemProperty = function (itemId, property, value, type) {
    // Define this manager
    var manager = this;

    // Define the type
    type = type === undefined || (type != "INTEGER" && type != "FLOAT" && type != "BOOLEAN") ? "STRING" : type;

    // Get the item
    var item = manager.getItem(itemId);

    // Update the item
    if (manager.validateItem(item)) {
        // Get the cart
        manager.getCart();

        switch (type) {
            case "STRING" :
                item[property] = value;
                break;
            case "FLOAT" :
                item[property] = parseFloat(value);
                break;
            case "INTEGER" :
                item[property] = parseInt(value);
                break;
            case "BOOLEAN" :
                item[property] = value ? true : false;
                break;
        }

        manager._cart["_" + itemId] = item;
    }

    // Update the cart
    manager.updateCart();
};


/**
 * Calculate the shopping cart total price. We can include the item's taxes or not.
 *
 * @returns The total amount
 */
ManagerShoppingCartClass.prototype.getTotalPrice = function () {
    // Define this manager
    var manager = this;

    // Get the cart
    manager.getCart();

    // Calculate the total price
    var totalPrice = 0;

    for (k in manager._cart) {
        var p = manager._cart[k].price * manager._cart[k].units;
        totalPrice += p + (p * manager._cart[k].taxes / 100);
    }

    // Add the shipping price
    totalPrice += manager._shippingPrice;

    // Return the total amount
    return UtilsFormatter.setDecimals(totalPrice, 2);
};


/**
 * Calculate the total shopping cart added  units
 *
 * @returns The number of units
 */
ManagerShoppingCartClass.prototype.getTotalUnits = function () {
    // Define this manager
    var manager = this;

    // Get the cart
    manager.getCart();

    // Calculate the total units
    var totalUnits = 0;

    for (k in manager._cart) {
        totalUnits += manager._cart[k].units;
    }

    return totalUnits;
};


/**
 * Empty the shopping cart
 */
ManagerShoppingCartClass.prototype.emptyCart = function () {
    // Define this manager
    var manager = this;

    // Clear the cart
    manager._cart = {};

    // Update the cart
    manager.updateCart();
};


/**
 * Update the cart with the resulting _cart object and render again.
 */
ManagerShoppingCartClass.prototype.updateCart = function () {
    // Define this manager
    var manager = this;

    // Save the updated cart to the cookie
    UtilsCookie.set(manager._cookieName, UtilsConversion.base64Encode(UtilsConversion.objectToJson(manager._cart)));

    // Render again
    manager.render(manager._parentElement);
};


/**
 * Override the shopping cart literals
 *
 * @param literals Object that defines the needed shopping cart literals following this structure (by default):
 *      {
 *          units: 'Units',
 *          price: 'Price',
 *          taxes: 'Taxes',
 *          remove: 'Remove',
 *          cancel: 'Cancel',
 *          alert: 'Alert!',
 *          emptyCart: 'Empty cart',
 *          shippingPrice: 'Shipping price',
 *          totalPrice: 'Total price',
 *          sureEmptyCart: 'Sure you want to empty your cart?',
 *          sureRemoveItem: 'Sure you want to remove the selected item?',
 *          noItems: 'Your cart is empty!'
 *      }
 */
ManagerShoppingCartClass.prototype.overrideLiterals = function (literals) {
    // Define this manager
    var manager = this;

    // Save the literals
    manager._literals = literals;
};


/**
 * Render the shopping cart into a container element. It's an UL list followind this structure:
 *
 * <ul class="componentShoppingCart">
 *     <li class="componentShoppingCartItem" item-id="x">
 *         <p class="componentShoppingCartItemTitle">Item title</p>
 *         <p class="componentShoppingCartItemPrice">10€</p>
 *         <p class="componentShoppingCartItemUnits">Units</p>
 *         <input type="number" class="componentShoppingCartItemInputUnits" />
 *         <input type="button" class="componentShoppingCartItemInputRemove" />
 *     </li>
 *     <li class="componentShoppingCartItem" item-id="y">...</li>
 * </ul>
 *
 * When we interact with the input elements, the shopping cart will automatically be updated
 *
 */
ManagerShoppingCartClass.prototype.render = function () {

    // Define this manager
    var manager = this;

    // Do not render if no parent element defined
    if (manager._parentElement != "") {
        // Get the cart
        manager.getCart();

        // Empty the container
        $(manager._parentElement).empty();

        // Validate if there is an item on the list
        if (manager.getTotalUnits() > 0) {

            // Create the cart elements
            var containerList = $('<ul class="componentShoppingCartItemsList"></ul>');

            for (k in manager._cart) {
                if (manager.validateItem(manager._cart[k])) {

                    // Create the item elements and append them
                    var itemHtml = '<li class="componentShoppingCartItem" item-id="' + manager._cart[k].itemId + '">';

                    if (manager._cart[k].pictureUrl) {
                        itemHtml += '<img src="' + manager._cart[k].pictureUrl + '" class="componentShoppingCartItemPicture">';
                    }
                    itemHtml += '<a href="' + manager._cart[k].url + '" class="componentShoppingCartItemTitle">' + manager._cart[k].title + '</a>' +
                        '<p class="componentShoppingCartItemPrice">' + manager._literals.price + ' <span>' + UtilsFormatter.currency(manager._cart[k].price, manager._currency) + '</span></p>' +
                        '<p class="componentShoppingCartItemTaxes">' + manager._literals.taxes + ' <span>' + manager._cart[k].taxes + '&#37;</span></p>' +
                        '<p class="componentShoppingCartItemUnits">' + manager._literals.units + '</p></li>';

                    var item = $(itemHtml);
                    var units = $('<input type="text" maxlength="3" value="' + manager._cart[k].units + '" class="componentShoppingCartItemInputUnits"/>');
                    var remove = $('<input type="button" value="' + manager._literals.remove + '" class="componentShoppingCartItemInputRemove"/>');

                    $(item).find("p.componentShoppingCartItemUnits").append(units);
                    $(item).append(remove);
                    $(containerList).append(item);

                    // Create the units and item remove events
                    $(units).change(function () {
                        var itemId = $(this).parents("li.componentShoppingCartItem").attr("item-id");
                        if (!UtilsValidation.isInteger($(this).val())) {
                            $(this).val(1);
                        }
                        else if (parseInt($(this).val()) < 1) {
                            $(this).val(1);
                        }
                        manager.setItemProperty(itemId, 'units', $(this).val(), "INTEGER");
                    });

                    $(remove).click(function () {
                        var itemId = $(this).parents("li.componentShoppingCartItem").attr("item-id");
                        ManagerPopUp.dialog(manager._literals.alert, manager._literals.sureRemoveItem, [
                            {label: manager._literals.cancel},
                            {
                                label: manager._literals.remove,
                                action: function () {
                                    manager.removeItem(itemId);
                                }
                            }], {
                            className: 'warning'
                        });
                    });
                }
            }

            // Create the outer list container
            var containerOuter = $('<div class="componentShoppingCartOuter"></div>');

            // Create the empty cart button and its own event
            var empty = $('<input class="componentShoppingCartEmpty" type="button" value="' + manager._literals.emptyCart + '" />');

            $(empty).click(function () {
                ManagerPopUp.dialog(manager._literals.alert, manager._literals.sureEmptyCart, [
                    {label: manager._literals.cancel},
                    {
                        label: manager._literals.emptyCart,
                        action: function () {
                            manager.emptyCart();
                        }
                    }], {
                    className: 'warning'
                });
            });

            // Create the shipping price
            var shippingPrice = $('<p class="componentShoppingCartShippingPrice">' + manager._literals.shippingPrice + ' <span>' + UtilsFormatter.currency(manager._shippingPrice, manager._currency) + '</span></p>');

            // Create the total price
            var totalPrice = $('<p class="componentShoppingCartTotalPrice">' + manager._literals.totalPrice + ' <span>' + UtilsFormatter.currency(manager.getTotalPrice(), manager._currency) + '</span></p>');

            // Append the empty and total price to the containerOuter
            $(containerOuter).append(shippingPrice, totalPrice, empty);

            // Add the container to the parent element
            $(manager._parentElement).append(containerList, containerOuter);
        }
        else {
            // If no items added, show message only
            $(manager._parentElement).html('<p class="componentShoppingCartNoItems">' + manager._literals.noItems + '</p>');
        }
    }

    // Update the shopping cart units element
    if (manager._unitsElement != "") {
        $(manager._unitsElement).html(manager.getTotalUnits());
    }

    // Update the shopping cart total price element
    if (manager._totalPriceElement != "") {
        $(manager._totalPriceElement).html(UtilsFormatter.currency(manager.getTotalPrice()));
    }

    // Call the after render callback
    if (manager._afterRenderCallback != null) {
        manager._afterRenderCallback.apply();
    }
};


/**
 * Validate if an item is valid. It verifies if it has itemId, title, price, taxes and units properties defined
 *
 * @param item The item object
 *
 * @returns {boolean}
 */
ManagerShoppingCartClass.prototype.validateItem = function (item) {

    if (item !== undefined && typeof  item === "object") {
        if (item.itemId === undefined) {
            return false;
        }
        if (item.title === undefined) {
            return false;
        }
        if (item.price === undefined) {
            return false;
        }
        if (item.taxes === undefined) {
            return false;
        }
        if (item.units === undefined) {
            return false;
        }
        if (item.url === undefined) {
            return false;
        }
        return true;
    }
    return false;
};


/**
 * Convert an object to an item to be used on the shopping cart
 *
 * @param objects The received objects list from the systemDisk
 * @param objectId The objectId to be converted
 * @param reiation [OPTIONAL] object that relation the shopping cart item with the system disk object.
 *
 * @returns item
 */
ManagerShoppingCartClass.prototype.utilSystemDiskObjectToItem = function (objects, objectId, relation) {

    var item = {};

    if (relation === undefined) {
        relation = {
            itemId: "objectId",
            title: "title",
            price: "price",
            taxes: "taxes",
            units: "units",
            url: "url"
        }
    }

    $(objects).each(function (k, v) {
        if (v[relation.itemId] == objectId) {
            item = {
                itemId: v[relation.itemId],
                title: v[relation.title] === undefined ? "" : v[relation.title].substring(0, 100),
                price: v[relation.price] === undefined ? 0 : parseFloat(v[relation.price]),
                taxes: v[relation.taxes] === undefined ? 0 : parseFloat(v[relation.taxes]),
                units: v[relation.units] === undefined ? 1 : parseFloat(v[relation.units]),
                url: v[relation.url] === undefined ? "" : parseFloat(v[relation.url])
            };
            return false;
        }
    });

    return item;
};


/**
 * Generates the custom data for the PayPal. It only includes a base64 JSON array with all item ids and units. If no items, it will return an empty string.
 *
 * [[itemId, units], [itemId, units], ...]
 */
ManagerShoppingCartClass.prototype.payPalGenerateCustom = function () {
    // Define this manager
    var manager = this;

    // Define the ids array
    var ids = [];

    for (i in manager._cart) {
        if (manager.validateItem(manager._cart[i])) {
            ids.push([manager._cart[i].itemId, manager._cart[i].units]);
        }
    }
    return ids.length > 0 ? UtilsConversion.base64Encode(UtilsConversion.objectToJson(ids)) : '';
};


/**
 * Generate the PayPal item name through the list, showing all item titles and units. Example: product 1 (3), Product 2 (1)
 * @returns {string}
 */
ManagerShoppingCartClass.prototype.payPalGenerateItemName = function () {
    // Define this manager
    var manager = this;

    // Define the names string
    var names = "";

    for (i in manager._cart) {
        if (manager.validateItem(manager._cart[i])) {
            names += manager._cart[i].title + " (" + manager._cart[i].units + "), ";
        }
    }

    if (names != "") {
        names = names.substring(0, names.length - 2);
    }

    return names;
};