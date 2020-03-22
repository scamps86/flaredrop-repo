<?php

/**
 * Component that allows to change the web language
 *
 * The component is an UL list and the class name is: <b>componentLanguageChanger</b> and each option have the class <b>componentLanguageChangerOption</b>, each glue have the class <b>componentLanguageChangerOptionGlue</b>.
 * The selected option have the class <b>componentLanguageChangerOptionSelected</b>
 */
class ComponentLanguageChanger extends ComponentBase
{
    private $_glue = '';

    /**
     * Initialize the component.
     *
     * @param string $glue The option separation content
     * @param string $id The component's id (not mandatory)
     */
    function componentLanguageChanger($glue = '-', $id = '')
    {
        $this->_glue = $glue;

        // Define the component's container
        $this->_defineComponentContainer('ul', 'componentLanguageChanger', $id);
    }


    /**
     * Set the component options
     *
     * @param array $options The different options that will be shown. Be sure that each option is arranged like WebConfiguration LOCALES
     * @param bool $isLabel Defines if the options are labels or image urls. By default are labels
     */
    public function setOptions(array $options, $isLabel = true)
    {

        // Generate the default options
        $this->_generateOptions($options, $isLabel);
    }


    /**
     * Generate the language chooser options
     *
     * @param array $options An array containing the data to be shown. Can be labels or image urls
     * @param boolean $isLabel Defines if each option is a label or an image URL
     */
    private function _generateOptions(array $options, $isLabel)
    {
        $this->_htmlContent = '';

        for ($i = 0; $i < count($options); $i++) {

            if ($i > 0) {
                $this->_htmlContent .= '<li class="componentLanguageChangerOptionGlue"><p>' . $this->_glue . '</p></li>';
            }

            $selectedClass = WebConstants::getLanTag() == WebConfigurationBase::$LOCALES[$i] ? ' componentLanguageChangerOptionSelected' : '';

            if ($isLabel) {
                $label = '<p>' . $options[$i] . '</p>';
            } else {
                $label = '<img src="' . $options[$i] . '">';
            }

            // Get the language
            $lan = substr(WebConfigurationBase::$LOCALES[$i], 0, 2);

            $this->_htmlContent .= '<li class="componentLanguageChangerOption' . $selectedClass . '" ';
            $this->_htmlContent .= 'locale="' . $lan . '">';
            $this->_htmlContent .= '<a href="' . UtilsHttp::getSectionUrl(WebConstants::getSectionName(), UtilsHttp::getEncodedParamsArray(), UtilsHttp::getDummy(), substr(WebConfigurationBase::$LOCALES[$i], 0, 2)) . '">' . $label . '</a></li>';
        }
    }
}