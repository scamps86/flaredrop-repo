<?php

class ComponentBase
{
    private $_htmlInit = '';
    private $_htmlClose = '';
    public $_htmlContent = '';


    /**
     * Echoes the current component's HTML code
     */
    public function echoComponent()
    {
        echo $this->_htmlInit . $this->_htmlContent . $this->_htmlClose;
    }


    /**
     * Define the component's container
     *
     * @param string $tag The container tag (normally are div or ul)
     * @param string $className The component's class name
     * @param string $id The component's id (not mandatory)
     * @param string $attributes The component's optional attributes
     */
    public function _defineComponentContainer($tag, $className, $id = '', $attributes = '')
    {
        $this->_htmlInit .= '<' . $tag . ' class="' . $className . '" ' . $attributes;

        if ($id != '') {
            $this->_htmlInit .= ' id="' . $id . '"';
        }

        $this->_htmlInit .= '>';

        $this->_htmlClose = '</' . $tag . '>';
    }

}