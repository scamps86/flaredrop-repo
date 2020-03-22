<?php

/*
 * FlareDrop Manager System
 */

class SystemManager
{


    /**
     * Get the FlareDrop system configuration
     *
     * @param int $rootId The root id
     *
     * @return Array
     */
    public static function configurationGet($rootId)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Define the query to get the main configuration
        $q = new VoSelectQuery();
        $q->select = 'r.rootId, r.selectedSkin, r.domainExpirationDate, p.type as planType, p.price as planPrice, p.allowedSpace';
        $q->from = 'root r, plan p';
        $q->where = 'r.planId = p.planId AND rootId=' . UtilsString::sqlQuote($rootId);

        // Get and save the data to the configuration array
        $systemConfiguration['global'] = $connection->getNextRow($connection->query($q->generateQuery()));

        // Define the query to get the menu configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'menu_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $systemConfiguration['menu'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the objects configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'object_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $systemConfiguration['objects'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the filters configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'filter_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $systemConfiguration['filters'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the properties configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'properties_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);
        $q->orderBy = 'objectType ASC, type ASC, localized DESC';

        // Save the data to the configuration vo
        $systemConfiguration['properties'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the list configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'list_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);
        $q->orderBy = 'objectType ASC';

        // Save the data to the configuration vo
        $systemConfiguration['list'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the CSS configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'css_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $systemConfiguration['css'] = $connection->queryToArray($q->generateQuery());

        // Define the query to get the global vars configuration
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'var_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $systemConfiguration['vars'] = $connection->queryToArray($q->generateQuery());

        // Return the configuration
        return $systemConfiguration;
    }


    /**
     * Save the menu configuration
     *
     * @param string $objectType The object type name
     * @param int $rootId The root id
     * @param string $literalKey The locale key
     * @param string $iconClassName The icon CSS class name
     *
     * @return VoResult The final result
     */
    public static function configurationMenuSet($objectType, $rootId, $literalKey, $iconClassName)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'objectType';
        $q->from = 'menu_configuration';
        $q->where = 'objectType=' . UtilsString::sqlQuote($objectType);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['objectType', 'rootId', 'literalKey', 'iconClassName'];

            // Define the data to be inserted
            $data = [[$objectType, $rootId, $literalKey, $iconClassName]];

            if (!$connection->insert('menu_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert menu configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['objectType'] = $objectType;
            $data['rootId'] = $rootId;
            $data['literalKey'] = $literalKey;
            $data['iconClassName'] = $iconClassName;

            if (!$connection->update('menu_configuration', $data, 'objectType=' . UtilsString::sqlQuote($objectType))) {
                return UtilsResult::GenerateErrorResult('Could not update menu configuration. ' . $connection->lastError);
            }
        }
        return UtilsResult::generateSuccessResult('Menu configuration created/updated');
    }


    /**
     * Remove the menu configuration
     *
     * @param string $objectType The menu configuration object type
     *
     * @return VoResult The final result
     */
    public static function configurationMenuRemove($objectType)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM menu_configuration WHERE objectType=' . UtilsString::sqlQuote($objectType))) {
            return UtilsResult::GenerateErrorResult('Error removing the menu configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('Menu configuration removed');
    }


    /**
     * Save the object configuration
     *
     * @param string $objectType The object type name
     * @param int $rootId The root id
     * @param string $bundle The bundle file name
     * @param boolean $foldersShow Show the folders container or not
     * @param boolean $foldersLink Enable the folders linking or not
     * @param boolean $folderOptionsShow Show the folders options or not
     * @param int $folderLevels The allowed folder levels
     * @param boolean $folderFilesEnabled If the object folders have files
     * @param boolean $filesEnabled If the object files are enabled
     * @param boolean $folderPicturesEnabled If the object folders have images
     * @param boolean $picturesEnabled If the object pictures are enabled
     * @param string $pictureDimensions The picture dimensions like 200x300;400x500..
     * @param int $pictureQuality The picture quality from 0 to 100
     *
     * @return VoResult The final result
     */
    public static function configurationObjectSet($objectType, $rootId, $bundle, $foldersLink, $foldersShow, $folderOptionsShow, $folderLevels, $folderFilesEnabled, $filesEnabled, $folderPicturesEnabled, $picturesEnabled, $pictureDimensions, $pictureQuality)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'objectType';
        $q->from = 'object_configuration';
        $q->where = 'objectType=' . UtilsString::sqlQuote($objectType);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['objectType', 'rootId', 'bundle', 'foldersLink', 'foldersShow', 'folderOptionsShow', 'folderLevels', 'folderFilesEnabled', 'filesEnabled', 'folderPicturesEnabled', 'picturesEnabled', 'pictureDimensions', 'pictureQuality'];

            // Define the data to be inserted
            $data = [[$objectType, $rootId, $bundle, $foldersLink, $foldersShow, $folderOptionsShow, $folderLevels, $folderFilesEnabled, $filesEnabled, $folderPicturesEnabled, $picturesEnabled, $pictureDimensions, $pictureQuality]];

            if (!$connection->insert('object_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert object configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['objectType'] = $objectType;
            $data['rootId'] = $rootId;
            $data['bundle'] = $bundle;
            $data['foldersLink'] = $foldersLink;
            $data['foldersShow'] = $foldersShow;
            $data['folderOptionsShow'] = $folderOptionsShow;
            $data['folderLevels'] = $folderLevels;
            $data['folderFilesEnabled'] = $folderFilesEnabled;
            $data['filesEnabled'] = $filesEnabled;
            $data['folderPicturesEnabled'] = $folderPicturesEnabled;
            $data['picturesEnabled'] = $picturesEnabled;
            $data['pictureDimensions'] = $pictureDimensions;
            $data['pictureQuality'] = $pictureQuality;

            if (!$connection->update('object_configuration', $data, 'objectType=' . UtilsString::sqlQuote($objectType))) {
                return UtilsResult::GenerateErrorResult('Could not update object configuration. ' . $connection->lastError);
            }
        }
        return UtilsResult::generateSuccessResult('Object configuration created/updated');
    }


    /**
     * Remove the object configuration
     *
     * @param string $objectType The object configuration object type
     *
     * @return VoResult The final result
     */
    public static function configurationObjectRemove($objectType)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM object_configuration WHERE objectType=' . UtilsString::sqlQuote($objectType))) {
            return UtilsResult::GenerateErrorResult('Error removing the object configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('Object configuration removed');
    }


    /**
     * Save the filter configuration
     *
     * @param string $objectType The object type name
     * @param int $rootId The root id
     * @param boolean $showDisk Show the disk filter
     * @param int $diskDefault Default disk to apply on the module
     * @param int $showTextProperties Show the text filter with the properties to apply like: property1;property2;...
     * @param boolean $showPeriod Show the period filter
     *
     * @return VoResult The final result
     */
    public static function configurationFilterSet($objectType, $rootId, $showDisk, $diskDefault, $showTextProperties, $showPeriod)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'objectType';
        $q->from = 'filter_configuration';
        $q->where = 'objectType=' . UtilsString::sqlQuote($objectType);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['objectType', 'rootId', 'showDisk', 'diskDefault', 'showTextProperties', 'showPeriod'];

            // Define the data to be inserted
            $data = [[$objectType, $rootId, $showDisk, $diskDefault, $showTextProperties, $showPeriod]];

            if (!$connection->insert('filter_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert filter configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['objectType'] = $objectType;
            $data['rootId'] = $rootId;
            $data['showDisk'] = $showDisk;
            $data['diskDefault'] = $diskDefault;
            $data['showTextProperties'] = $showTextProperties;
            $data['showPeriod'] = $showPeriod;

            if (!$connection->update('filter_configuration', $data, 'objectType=' . UtilsString::sqlQuote($objectType))) {
                return UtilsResult::GenerateErrorResult('Could not update filter configuration. ' . $connection->lastError);
            }
        }
        return UtilsResult::generateSuccessResult('Filter configuration created/updated');
    }


    /**
     * Remove the filter configuration
     *
     * @param string $objectType The object configuration object type
     *
     * @return VoResult The final result
     */
    public static function configurationFilterRemove($objectType)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM filter_configuration WHERE objectType=' . UtilsString::sqlQuote($objectType))) {
            return UtilsResult::GenerateErrorResult('Error removing the filter configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('Filter configuration removed');
    }


    /**
     * Save the properties configuration
     *
     * @param int $propertiesConfigurationId The property configuration id
     * @param int $rootId The root id
     * @param string $objectType The object type
     * @param string $property The property name
     * @param string $defaultValue The default value. An empty string by default
     * @param string $literalKey The locale key
     * @param string $type The property input type
     * @param int $localized Tells if the property is localized or not
     * @param int $base64Encode Tells if the property must be encoded before sending it to the service
     * @param string $validate Validation
     * @param string $validateCondition Validation logical condition
     * @param string $validateErrorliteralKey Validation error locale key
     *
     * @return VoResult The final result
     */
    public static function configurationPropertySet($propertiesConfigurationId, $rootId, $objectType, $property, $defaultValue = '', $literalKey, $type, $localized, $base64Encode, $validate, $validateCondition, $validateErrorliteralKey)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'propertiesConfigurationId';
        $q->from = 'properties_configuration';
        $q->where = 'propertiesConfigurationId=' . UtilsString::sqlQuote($propertiesConfigurationId);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['propertiesConfigurationId', 'rootId', 'objectType', 'property', 'defaultValue', 'literalKey', 'type', 'localized', 'base64Encode', 'validate', 'validateCondition', 'validateErrorliteralKey'];

            // Define the data to be inserted
            $data = [[$propertiesConfigurationId, $rootId, $objectType, $property, $defaultValue, $literalKey, $type, $localized, $base64Encode, $validate, $validateCondition, $validateErrorliteralKey]];

            if (!$connection->insert('properties_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert property configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['propertiesConfigurationId'] = $propertiesConfigurationId;
            $data['rootId'] = $rootId;
            $data['objectType'] = $objectType;
            $data['property'] = $property;
            $data['defaultValue'] = $defaultValue;
            $data['literalKey'] = $literalKey;
            $data['type'] = $type;
            $data['localized'] = $localized;
            $data['base64Encode'] = $base64Encode;
            $data['validate'] = $validate;
            $data['validateCondition'] = $validateCondition;
            $data['validateErrorliteralKey'] = $validateErrorliteralKey;

            if (!$connection->update('properties_configuration', $data, 'propertiesConfigurationId=' . UtilsString::sqlQuote($propertiesConfigurationId))) {
                return UtilsResult::GenerateErrorResult('Could not update property configuration. ' . $connection->lastError);
            }
        }
        return UtilsResult::generateSuccessResult('Property configuration created/updated');
    }


    /**
     * Remove the property configuration
     *
     * @param int $propertiesConfigurationId The properties configuration id
     *
     * @return VoResult The final result
     */
    public static function configurationPropertyRemove($propertiesConfigurationId)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM properties_configuration WHERE propertiesConfigurationId=' . UtilsString::sqlQuote($propertiesConfigurationId))) {
            return UtilsResult::GenerateErrorResult('Error removing the property configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('Property configuration removed');
    }


    /**
     * Save the list configuration
     *
     * @param int $listConfigurationId The list configuration id
     * @param int $rootId The root id
     * @param string $objectType The object type
     * @param string $property The property name
     * @param string $literalKey The locale key
     * @param string $formatType The list format type
     * @param int $width The column percent width
     *
     * @return VoResult The final result
     */
    public static function configurationListSet($listConfigurationId, $rootId, $objectType, $property, $literalKey, $formatType, $width)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'listConfigurationId';
        $q->from = 'list_configuration';
        $q->where = 'listConfigurationId=' . UtilsString::sqlQuote($listConfigurationId);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['listConfigurationId', 'rootId', 'objectType', 'property', 'literalKey', 'formatType', 'width'];

            // Define the data to be inserted
            $data = [[$listConfigurationId, $rootId, $objectType, $property, $literalKey, $formatType, $width]];

            if (!$connection->insert('list_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert list configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['listConfigurationId'] = $listConfigurationId;
            $data['rootId'] = $rootId;
            $data['objectType'] = $objectType;
            $data['property'] = $property;
            $data['literalKey'] = $literalKey;
            $data['formatType'] = $formatType;
            $data['width'] = $width;

            if (!$connection->update('list_configuration', $data, 'listConfigurationId=' . UtilsString::sqlQuote($listConfigurationId))) {
                return UtilsResult::GenerateErrorResult('Could not update list configuration. ' . $connection->lastError);
            }
        }
        return UtilsResult::generateSuccessResult('List configuration created/updated');
    }


    /**
     * Remove the list configuration
     *
     * @param int $listConfigurationId The list configuration id
     *
     * @return VoResult The final result
     */
    public static function configurationListRemove($listConfigurationId)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM list_configuration WHERE listConfigurationId=' . UtilsString::sqlQuote($listConfigurationId))) {
            return UtilsResult::GenerateErrorResult('Error removing the list configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('List configuration removed');
    }


    /**
     * Save the CSS configuration
     *
     * @param int $cssConfigurationId The CSS configuration id
     * @param int $rootId The root id
     * @param string $name The name that the customer will read
     * @param string $selector The CSS selector
     * @param string $styles The CSS styles (no {} needed)
     *
     * @return VoResult The final result
     */
    public static function configurationCssSet($cssConfigurationId, $rootId, $name, $selector, $styles = '')
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'cssConfigurationId';
        $q->from = 'css_configuration';
        $q->where = 'cssConfigurationId=' . UtilsString::sqlQuote($cssConfigurationId);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['cssConfigurationId', 'rootId', 'name', 'selector', 'styles'];

            // Define the data to be inserted
            $data = [[$cssConfigurationId, $rootId, $name, $selector, $styles]];

            if (!$connection->insert('css_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert CSS configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['cssConfigurationId'] = $cssConfigurationId;
            $data['rootId'] = $rootId;
            $data['name'] = $name;
            $data['selector'] = $selector;
            $data['styles'] = $styles;
            if (!$connection->update('css_configuration', $data, 'cssConfigurationId=' . UtilsString::sqlQuote($cssConfigurationId))) {
                return UtilsResult::GenerateErrorResult('Could not update CSS configuration. ' . $connection->lastError);
            }
        }

        return UtilsResult::generateSuccessResult('CSS configuration created/updated');
    }


    /**
     * Remove the CSS configuration
     *
     * @param int $cssConfigurationId The CSS configuration id
     *
     * @return VoResult The final result
     */
    public static function configurationCssRemove($cssConfigurationId)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM css_configuration WHERE cssConfigurationId=' . UtilsString::sqlQuote($cssConfigurationId))) {
            return UtilsResult::GenerateErrorResult('Error removing the CSS configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('CSS configuration removed');
    }


    /**
     * Get the manager configured css styles as CSS HTML tag. An empty string if no CSS configured
     *
     * @param int $rootId The CSS configuration root id
     *
     * @return string
     */
    public static function configurationCssGetAsCss($rootId)
    {
        //Define a public connection
        $connection = Managers::mySQL(false);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = 'selector, styles';
        $q->from = 'css_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $q->result = $connection->queryToArray($q->generateQuery());

        // Generate the output CSS
        $result = '';

        foreach ($q->result as $r) {
            if ($r['selector'] != '' && $r['styles'] != '') {
                $result .= $r['selector'] . '{' . $r['styles'] . '}';
            }
        }

        $result = str_replace(' ', '', str_replace("\n", '', $result));

        return $result == '' ? $result : '<style>' . $result . '</style>';
    }


    /**
     * Save the global variables configuration
     *
     * @param string $variable The name for the variable
     * @param int $rootId The root id
     * @param string $name The name that the customer will read
     * @param string $value The value for the variable
     *
     * @return VoResult The final result
     */
    public static function configurationVarSet($variable, $rootId, $name, $value = '')
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Get the configuration
        $q = new VoSelectQuery();
        $q->select = 'variable';
        $q->from = 'var_configuration';
        $q->where = 'variable=' . UtilsString::sqlQuote($variable);
        $q->result = $connection->count($q->generateQuery());

        if ($q->result < 1) {
            // Define the columns to be inserted
            $columns = ['variable', 'rootId', 'name', 'value'];

            // Define the data to be inserted
            $data = [[$variable, $rootId, $name, $value]];

            if (!$connection->insert('var_configuration', $columns, $data)) {
                return UtilsResult::GenerateErrorResult('Could not insert global variables configuration. ' . $connection->lastError);
            }
        } else {
            // Define the data to be updated
            $data = [];
            $data['variable'] = $variable;
            $data['rootId'] = $rootId;
            $data['name'] = $name;
            $data['value'] = $value;
            if (!$connection->update('var_configuration', $data, 'variable=' . UtilsString::sqlQuote($variable))) {
                return UtilsResult::GenerateErrorResult('Could not update global variables configuration. ' . $connection->lastError);
            }
        }

        return UtilsResult::generateSuccessResult('Global variables configuration created/updated');
    }


    /**
     * Remove the global variables configuration
     *
     * @param string $variable The variable
     *
     * @return VoResult The final result
     */
    public static function configurationVarRemove($variable)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Do the deletion
        if (!$connection->query('DELETE FROM var_configuration WHERE variable=' . UtilsString::sqlQuote($variable))) {
            return UtilsResult::GenerateErrorResult('Error removing the global variables configuration. ' . $connection->lastError);
        }
        return UtilsResult::generateSuccessResult('Global variables configuration removed');
    }


    /**
     * Get the manager configured global variables as a map. If no global variables defined, it will return an empty array
     *
     * @param int $rootId The CSS configuration root id
     *
     * @return array of arrays [[variableName => value], ...]
     */
    public static function configurationVarGet($rootId)
    {
        //Define a public connection
        $connection = Managers::mySQL(false);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = 'variable, value';
        $q->from = 'var_configuration';
        $q->where = 'rootId = ' . UtilsString::sqlQuote($rootId);

        // Save the data to the configuration vo
        $q->result = $connection->queryToArray($q->generateQuery());

        // Format the result
        $result = [];

        foreach ($q->result as $v) {
            $result[$v['variable']] = $v['value'];
        }

        return $result;
    }


    /**
     * Set a CSS skin name for the backoffice
     *
     * @param int $rootId The company id that we want to modify the skin
     * @param string $selectedSkin The CSS file name to use as skin on the backoffice
     *
     * @return VoResult
     */
    public static function skinSet($rootId, $selectedSkin)
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        if (!$connection->update('root', ['selectedSkin' => $selectedSkin], 'rootId = ' . UtilsString::sqlQuote($rootId))) {
            return UtilsResult::GenerateErrorResult('Could not update the selected skin. ' . $connection->lastError, null, false);
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Selected skin updated.');
    }


    /**
     * Renew a plan expiration date for a year
     *
     * @param int $rootId The root id
     *
     * @return VoResult
     */
    public static function planRenew($rootId)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Get the main configuration
        $configuration = self::configurationGet($rootId);

        // Generate the new domain expiration date
        $newDomainExpirationDate = UtilsDate::operate('YEAR', $configuration['global']['domainExpirationDate'], 1);

        if (!$connection->update('root', ['domainExpirationDate' => $newDomainExpirationDate], 'rootId = ' . UtilsString::sqlQuote($rootId))) {
            return UtilsResult::GenerateErrorResult('Could not update the domain expiration date. ' . $connection->lastError, null, false);
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Domain expiration date renewed.');
    }


    /**
     * Get the db files used space for all roots
     *
     * @param string $fileType The file type. If not defined, it will return the all files used space
     *
     * @return int
     */
    public static function usedSpaceGet($fileType = '')
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        $q = new VoSelectQuery();
        $q->select = 'SUM(size) as space';
        $q->from = 'file';

        if ($fileType != '') {
            $q->where = 'type=' . UtilsString::sqlQuote($fileType);
        }

        // Get the file used space
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Return the used space
        return $q->result['space'] == '' ? 0 : intval($q->result['space']);
    }
}
 