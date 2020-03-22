/**
 * IMPORTANT! Initialize the manager by getting the bundle data by AJAX
 *
 * @param literalsBundles The literals bundles as an object
 */
function ManagerLiterals(literalsBundles) {
    this._bundles = literalsBundles;
}


/**
 * Get a literal value defined on the properties file. If the key doesn't exist, it will return the key like this: {KEY}
 *
 * @param key The literal key
 * @param bundle The literals resource bundle name
 * @param literal The current literal. If not defined, it will use the default one
 *
 * @return string
 */
ManagerLiterals.prototype.get = function (key, bundle, literal) {
    var bData = this.getBundle(bundle, literal);

    if (bData != null) {
        for (k in bData) {
            if (k == key) {
                return bData[k];
            }
        }
    }
    return "{" + key + "}";
};


/**
 * Get the literals resource bundle as an object. If it doesn't exist, it will return a null object
 *
 * @param bundle The literals resource bundle name
 * @param literal The current literal. If not defined, it will use the default one
 *
 * @returns A full literal list of this resource bundle as an object
 */
ManagerLiterals.prototype.getBundle = function (bundle, literal) {
    // Get the default literal if it's not defined
    literal = literal == undefined ? this._bundles["default"] : literal;


    if (this._bundles[literal] !== undefined) {
        if (this._bundles[literal][bundle] !== undefined) {
            return this._bundles[literal][bundle];
        }
    }
    return null;
};


/**
 * Get all literal bundle files inside an object using this structure: [xx_XX] => [bundle] => [data]
 *
 * @returns Object
 */
ManagerLiterals.prototype.getBundles = function () {
    return this._bundles;
};


/**
 * Get the defined literal tags
 * @returns {Array}
 */
ManagerLiterals.prototype.getLanTags = function () {
    var literals = [];
    $(Object.keys(this._bundles)).each(function (k, v) {
        if (v != "default") {
            literals.push(v);
        }
    });
    return literals;
};