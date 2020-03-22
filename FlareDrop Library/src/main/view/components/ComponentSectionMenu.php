<?php

/**
 * Component that creates a section menu
 * The component is an UL list and the class name is: <b>componentSectionMenu</b> and each option have the class <b>componentSectionMenuOption</b>.
 * The selected option have the class <b>componentSectionMenuOptionSelected</b>
 *
 */
class ComponentSectionMenu extends ComponentBase
{

    /**
     *  Initialize the component
     * @param string $id The component's id (not mandatory)
     */
    function componentSectionMenu($id = '')
    {
        // Define the component's container
        $this->_defineComponentContainer('ul', 'componentSectionMenu', $id);
    }


    /**
     * Add a menu section
     *
     * @param string $label The section label
     * @param array $sectionNames The section names that highlights this section when the user is navigating in one of them
     * @param string $anchor The html anchor to scroll. (Not necessary)
     */
    public function addSection($label, array $sectionNames, $anchor = '', $target = '_self')
    {
        $this->_htmlContent .= '<li class="componentSectionMenuOption';

        if (in_array(WebConstants::getSectionName(), $sectionNames) || in_array(WebConstants::getSectionName(false), $sectionNames)) {
            $this->_htmlContent .= ' componentSectionMenuOptionSelected';
        }

        $this->_htmlContent .= '"><a href="' . UtilsHttp::getSectionUrl($sectionNames[0]) . $anchor . '" target="' . $target . '">' . $label . '</a></li>';
    }


    /**
     * Add a link option to the menu
     *
     * @param string $label The section label
     * @param string $url The link url
     * @param string $target The link target (not necessary)
     */
    public function addLink($label, $url, $target = '_blank')
    {
        $this->_htmlContent .= '<li class="componentSectionMenuOption';
        $this->_htmlContent .= '"><a href="' . $url . '" target="' . $target . '">' . $label . '</a></li>';
    }
}