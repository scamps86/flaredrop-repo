<?php

/**
 * Component that creates a folder menu
 * The component is an UL list and the class name is: <b>componentFolderMenu</b> and each option have the class <b>componentFolderMenuOption</b>.
 * It also can have a subfolder menu with a class named: <b>componentFolderSubMenu</b>
 * The selected option have the class <b>componentFolderMenuOptionSelected</b>
 * The used parameter is <b>folderId</b>
 *
 */
class ComponentFolderMenu extends ComponentBase
{

    /**
     *  Initialize the component
     * @param string $id The component's id (not mandatory)
     */
    function componentFolderMenu($id = '')
    {
        // Define the component's container
        $this->_defineComponentContainer('ul', 'componentFolderMenu', $id);
    }


    /**
     * Generate a folders menu
     *
     * @param array $tree The received folder tree
     * @param string $sectionName The section name where to link when selecting this option
     * @param boolean $includeChilds Tells if the folder childs must be included
     */
    public function addFolderTree(array $tree, $sectionName, $includeChilds = true)
    {
        if (isset($tree)) {
            foreach ($tree as $c) {
                $this->_htmlContent .= '<li class="componentFolderMenuOption';

                if (UtilsHttp::getEncodedParam('folderId') == $c['folderId']) {
                    $this->_htmlContent .= ' componentFolderMenuOptionSelected';
                }
                $this->_htmlContent .= '"><a href="' . UtilsHttp::getSectionUrl($sectionName, ['folderId' => $c['folderId']], $c['name']) . '">' . $c['name'] . '</a>';

                if ($includeChilds && count($c['child']) > 0) {
                    $this->_htmlContent .= '<ul class="componentFolderSubMenu">';
                    self::addFolderTree($c['child'], $sectionName);
                    $this->_htmlContent .= '</ul>';
                }

                $this->_htmlContent .= '</li>';
            }
        }
    }


    /**
     * Add a folder menu extra option
     *
     * @param string $label The option label
     * @param string $sectionName The section name where to link when selecting this option
     * @param array $parameter The custom parameter that will be placed on the URL as folderId when clicking this option
     */
    public function addOption($label, $sectionName, $parameter = '')
    {
        $this->_htmlContent .= '<li class="componentFolderMenuOption';

        if (UtilsHttp::getEncodedParam('folderId') == $parameter) {
            $this->_htmlContent .= ' componentFolderMenuOptionSelected';
        }

        $params = null;

        if ($parameter != '') {
            $params = [];
            $params['folderId'] = $parameter;
        }

        $this->_htmlContent .= '"><a href="' . UtilsHttp::getSectionUrl($sectionName, $params, $label) . '">' . $label . '</a></li>';
    }
}