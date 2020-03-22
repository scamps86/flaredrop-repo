<?php

/** Entity filter. Please note that after every set, we have to define a contition (AND, OR or parenthesis) */
class VoSystemFilter
{

    /** Array containing the filter data */
    private $_filterData = [];


    /**
     * Get only the objects containing this disk id
     *
     * @param int $diskId
     */
    public function setDiskId($diskId)
    {
        array_push($this->_filterData, ['diskId', $diskId]);
    }


    /**
     * Get only the objects that are in this root id
     *
     * @param int $rootId
     */
    public function setRootId($rootId)
    {
        array_push($this->_filterData, ['rootId', $rootId]);
    }


    /**
     * Get only the objects containing this folder
     *
     * @param int $folderId
     */
    public function setFolderId($folderId)
    {
        array_push($this->_filterData, ['folderId', $folderId]);
    }


    /**
     * Set the language for the objects list
     *
     * @param string $lanTag
     */
    public function setLanTag($lanTag)
    {
        array_push($this->_filterData, ['lanTag', $lanTag]);
    }


    /**
     * Search a text on a property. It's not case sensitive and it won't consider the accents
     *
     * @param string $property The object property where we have to do the search
     * @param string $search The text to be searched on the corresponding property
     */
    public function setPropertySearch($property, $search)
    {
        array_push($this->_filterData, ['propertySearch', [$property, $search]]);
    }


    /**
     * Get only the objects that matches a property
     *
     * @param string $property The object property where we have to do the match
     * @param string $value The value to match
     */
    public function setPropertyMatch($property, $value)
    {
        array_push($this->_filterData, ['propertyMatch', [$property, $value]]);
    }


    /**
     * Get only the objects that have a property value between two values (min and max) (not logical accumulative)
     *
     * @param string $property The object property where we have to do the validation
     * @param string $min The minimum value
     * @param string $max The maximum value
     * @param string $type The value type to apply. It can be: "TEXT", "NUMBER" or "DATE". Text by default. Date values must be in mysql format
     */
    public function setPropertyInner($property, $min, $max, $type = 'TEXT')
    {
        array_push($this->_filterData, ['propertyInner', [$property, $min, $max, $type]]);
    }


    /**
     * Set which property is used to sort the list (not logical accumulative)
     *
     * @param string $property The object property to consider to apply the sorting
     * @param string $direction The sorting direction. It can be "ASC" or "DESC". "ASC" by default
     **/
    public function setSortFields($property, $direction = 'ASC')
    {
        array_push($this->_filterData, ['sortField', [$property, $direction]]);
    }


    /**
     * Set the current page when we are getting a paginated list. (not logical accumulative)
     *
     * @param int $pageIndex The page index. An empty string means that it is the first page
     */
    public function setPageCurrent($pageIndex)
    {
        if ($pageIndex == '') {
            $pageIndex = 0;
        }
        array_push($this->_filterData, ['pageCurrent', $pageIndex]);
    }


    /**
     * Set the number of items by page when we are getting a paginated list. (not logical accumulative)
     *
     * @param int $numItems The number of items for each page
     */
    public function setPageNumItems($numItems)
    {
        array_push($this->_filterData, ['pageNumItems', $numItems]);
    }


    /**
     * Randomize the resulting list. (not logical accumulative)
     */
    public function setRandom()
    {
        array_push($this->_filterData, ['random']);
    }


    /**
     * Set AND logical condition operation
     */
    public function setAND()
    {
        array_push($this->_filterData, ['logical', 'AND']);
    }


    /**
     * Set OR logical condition operation
     */
    public function setOR()
    {
        array_push($this->_filterData, ['logical', 'OR']);
    }


    /**
     * Set open parenthesis for the logical operations
     */
    public function setOpenParenthesis()
    {
        array_push($this->_filterData, ['logical', '(']);
    }


    /**
     * Set close parenthesis for the logical operations
     */
    public function setCloseParenthesis()
    {
        array_push($this->_filterData, ['logical', ')']);
    }


    /**
     * Get the defined filter data
     *
     * @return array Array of arrays containing the filter data like: [['filter type', 'value'], ...]
     */
    public function getData()
    {
        return $this->_filterData;
    }


    /**
     * Override the current filter data
     *
     * @param array $filterData The filter data like: [['filter type', 'value'], ...]
     */
    public function setData($filterData)
    {
        $this->_filterData = $filterData;
    }


    /**
     * Validate if the filter configuration has a mistake or it's correct
     *
     * @return boolean
     */
    public function validate()
    {
        $prev = ['', '']; // Last condition
        $par = 0; // Opened parenthesis

        foreach ($this->_filterData as $f) {
            // Only the WHERE filters. Not the order by, from and limit
            if ($f[0] != 'sortField' && $f[0] != 'random' && $f[0] != 'pageCurrent' && $f[0] != 'pageNumItems' && $f[0] != 'propertyInner') {
                if ($f[0] == 'logical') {

                    // Open parenthesis can only be used when filter starting and after a logical condition except the close parenthesis
                    if ($f[1] == '(') {
                        if ($prev[0] == 'logical' && $prev[1] == ')') {
                            return false;
                        }
                        if ($prev[0] != 'logical' && $prev[0] != '') {
                            return false;
                        }

                        $par++;
                    }

                    // Close parenthesis can only be used after a non logical condition and an opened parenthesis before
                    if ($f[1] == ')') {
                        if ($par <= 0 || $prev[0] == '' || $prev[0] == 'logical') {
                            return false;
                        }

                        $par--;
                    }

                    // AND and OR logicals can only be used after a close parenthesis or any other non logical condition
                    if ($f[1] == 'AND' || $f[1] == 'OR') {
                        if ($prev[0] == 'logical' && $prev[1] != ')') {
                            return false;
                        }
                    }
                } else {
                    // The other conditions can only be used on filter starting and after a logical condition except the close parenthesis
                    if ($prev[0] == 'logical' && $prev[1] == ')') {
                        return false;
                    }
                    if ($prev[0] != 'logical' && $prev[0] != '') {
                        return false;
                    }
                }

                $prev = $f;
            } else {
                // The not WHERE filters can be applied after all filters except the logicals AND, OR, and (
                if ($prev[0] == 'logical' && $prev[1] != ')') {
                    return false;
                }
            }

        }
        return $par == 0;
    }


    /**
     * Check if the filter has a filter defined
     *
     * @param string $filterName The filter name: diskId, folderId, lanTag, propertySearch, propertyMatch, propertyInner, sortField, pageCurrent, pageNumItems, random
     *
     * @return boolean
     */
    public function hasDefinedFilter($filterName)
    {
        foreach ($this->_filterData as $f) {
            if ($f[0] == $filterName) {
                return true;
            }
        }

        return false;
    }
}