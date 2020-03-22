<?php

/**
 * Component that creates different tabs to navigate in. (THIS MUST BE INITIALIZED BY JAVASCRIPT!)
 *
 * The component is an UL list and the class name is: <b>componentTabNavigator</b> and each tab have the class <b>componentTabNavigatorTab</b> and a tab-index attribute. Each tab label
 * have the class <b>componentTabNavigatorLabel</b> and each tab content have the class <b>componentTabNavigatorContents</b> but each one are not visible.
 *
 * The selected tab duplicates its own contents to another container at the end of the component's list. Its class name is <b>componentTabNavigatorSelectedContainer</b>.
 *
 * The selected tab have the class <b>componentTabNavigatorTabSelected</b>
 */
class ComponentTabNavigator extends ComponentBase
{

    /**
     * Initialize the component.
     *
     * @param string $id The component's id
     */
    function componentTabNavigator($id)
    {
        // Define the component's container
        $this->_defineComponentContainer('ul', 'componentTabNavigator', $id);
    }


    /**
     * Add a tab to the component
     *
     * @param string $label The tab label
     * @param string $contents The tab contents as a plain text or HTML
     * @param string $className The optional class name for the tab
     */
    public function addTab($label, $contents, $className = '')
    {
        $this->_htmlContent .= '<li class="componentTabNavigatorTab unselectable' . ($className == '' ? '' : ' ' . $className) . '">';
        $this->_htmlContent .= '<h2 class="componentTabNavigatorLabel">' . $label . '</h2>';
        $this->_htmlContent .= '<div class="componentTabNavigatorContents">' . $contents . '</div></li>';
    }


}