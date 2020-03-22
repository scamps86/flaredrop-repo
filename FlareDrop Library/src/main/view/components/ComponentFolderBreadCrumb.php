<?php

/**
 * Component that creates a folder breadcrumb
 * The component is an P and the class name is: <b>componentFolderBreadCrumb</b> and each option is an A and have the class <b>componentFolderBreadCrumbOption</b>.
 * The used parameter is <b>folderId</b>
 *
 */
class ComponentFolderBreadCrumb extends ComponentBase
{

    /**
     *  Initialize the component
     * @param string $id The component's id (not mandatory)
     */
    function componentFolderBreadCrumb($id = '')
    {
        // Define the component's container
        $this->_defineComponentContainer('p', 'componentFolderBreadCrumb', $id);
    }


    /**
     * Generate the breadcrumb
     *
     * @param array $tree The received folder tree
     * @param string $sectionName The section name where to link when selecting this option
     * @param string $_content The recursive base. It should be empty when calling the function
     */
    public function addFolderTree(array $tree, $sectionName, $_content = '')
    {
        if (isset($tree)) {
            foreach ($tree as $c) {
                $content = $_content . '<a class="componentFolderBreadCrumbOption" href="' . UtilsHttp::getSectionUrl($sectionName, ['folderId' => $c['folderId']], $c['name']) . '">' . $c['name'] . '</a>';

                if (UtilsHttp::getEncodedParam('folderId') == $c['folderId']) {
                    $this->_htmlContent = $content;
                } else if (isset($c['child'])) {
                    $this->addFolderTree($c['child'], $sectionName, $content);
                }
            }
        }
    }


    /**
     * Add a breadcrumb extra option at the end
     *
     * @param string $label The option label
     * @param string $sectionName The section name where to link when selecting this option
     * @param array $params The custom parameters
     */
    public function addOption($label, $sectionName, array $params = null)
    {
        $this->_htmlContent .= '<a class="componentFolderBreadCrumbOption" href="' . UtilsHttp::getSectionUrl($sectionName, $params, $label) . '">' . $label . '</a>';
    }
}