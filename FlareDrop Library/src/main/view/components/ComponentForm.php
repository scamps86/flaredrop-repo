<?php

/**
 * Component that creates a form
 * The component is a FORM element and the class name is: <b>componentForm</b> and each input container have the class <b>componentFormInputContainer</b>.
 * Please use the ManagerForm.js file to check the reference and to process the form
 */
class ComponentForm extends ComponentBase
{

    /**
     *  Initialize the component
     *
     * @param string $serviceUrl The form service relative URL
     * @param string $id The component's id (not mandatory)
     */
    function componentForm($serviceUrl, $id = '')
    {
        // Define the component's container
        $this->_defineComponentContainer('form', 'componentForm', $id, 'serviceUrl="' . $serviceUrl . '"');
    }


    /**
     * Add a form input
     *
     * @param string $type The input type (HTML input types)
     * @param string $name The input name that will be sent as post. If not defined, this input data wont be sent
     * @param string $validate The input validate condition (please check the ManagerForm.js)
     * @param string $validateErrorMessage The input validation error message and title separated by a semicolon
     * @param string $label The input label (optional)
     * @param string $validateCondition The input validate condition (AND by default)
     * @param string $id The input id (optional)
     * @param string $value The default input value
     * @param string $placeholder The default input placeholder
     * @param string $validateRepeatGroup The validate repeat group
     */
    public function addInput($type, $name = '', $validate = '', $validateErrorMessage = '', $label = '', $validateCondition = '', $id = '', $value = '', $placeholder = '', $validateRepeatGroup = '')
    {
        $validateCondition = $validateCondition == '' ? 'AND' : $validateCondition;

        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<input type="' . $type . '" validate="' . $validate . '" validateCondition="' . $validateCondition . '" ';

        if ($validateRepeatGroup != '') {
            $this->_htmlContent .= 'validateRepeatGroup="' . $validateRepeatGroup . '" ';
        }

        if ($name != '') {
            $this->_htmlContent .= 'name="' . $name . '" ';
        }

        $this->_htmlContent .= 'validateErrorMessage="' . $validateErrorMessage . '" value="' . $value . '"';

        if ($placeholder != '') {
            $this->_htmlContent .= ' placeholder="' . $placeholder . '"';
        }

        $this->_htmlContent .= '></div>';
    }


    /**
     * Add a form text area
     *
     * @param string $name The input name that will be sent as post. If not defined, this input data wont be sent
     * @param string $validate The input validate condition (please check the ManagerForm.js)
     * @param string $validateErrorMessage The input validation error message and title separated by a semicolon
     * @param string $label The input label (optional)
     * @param string $validateCondition The input validate condition (AND by default)
     * @param string $id The input id (optional)
     * @param string $value The default input value
     * @param string $placeholder The default input placeholder
     */
    public function addTextArea($name, $validate = '', $validateErrorMessage = '', $label = '', $validateCondition = '', $id = '', $value = '', $placeholder = '')
    {
        $validateCondition = $validateCondition == '' ? 'AND' : $validateCondition;

        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<textarea validate="' . $validate . '" validateCondition="' . $validateCondition . '" ';

        if ($name != '') {
            $this->_htmlContent .= 'name="' . $name . '" ';
        }

        $this->_htmlContent .= 'validateErrorMessage="' . $validateErrorMessage . '" value="' . $value . '" placeholder="' . $placeholder . '"></textarea></div>';
    }


    /**
     * Add a form selector
     *
     * @param string $name The selector name that will be sent as post. If not defined, this selector data wont be sent
     * @param array $options The selector options array. Each value must be an associative array with the option value and the label: [['value' => 'x', 'label' => 'y'], [...]]
     * @param string $label The selector label (optional)
     * @param int $selectedIndex The selected index. (first one by default)
     * @param string $id The selector id (optional)
     */
    public function addSelector($name, array $options, $label = '', $selectedIndex = 0, $id = '')
    {
        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<select ';

        if ($name != '') {
            $this->_htmlContent .= 'name="' . $name . '" ';
        }

        $this->_htmlContent .= '>';

        for ($i = 0; $i < count($options); $i++) {
            $this->_htmlContent .= '<option value="' . $options[$i]['value'] . '"' . ($i == $selectedIndex ? ' selected' : '') . '>' . $options[$i]['label'] . '</option>';
        }

        $this->_htmlContent .= '</select></div>';
    }


    /**
     * Add a form switch component
     *
     * @param string $name The component's name that will be sent as post. If not defined, this component data wont be sent
     * @param string $validate The component validate condition. The component's values are 1 and -1. (please check the ManagerForm.js)
     * @param string $validateErrorMessage The component validation error message and title separated by a semicolon
     * @param string $label The component label (optional)
     * @param string $validateCondition The component validate condition (AND by default)
     * @param string $id The component id (optional)
     * @param boolean $opened Define if the component is switched. (false by default)
     */
    public function addSwitchComponent($name = '', $validate = '', $validateErrorMessage = '', $label = '', $validateCondition = '', $id = '', $opened = false)
    {
        $validateCondition = $validateCondition == '' ? 'AND' : $validateCondition;

        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<div class="componentFormSwitchComponentContainer" opened="' . ($opened ? 1 : -1) . '"></div>';
        $this->_htmlContent .= '<input type="hidden" validate="' . $validate . '" validateCondition="' . $validateCondition . '" ';

        if ($name != '') {
            $this->_htmlContent .= 'name="' . $name . '" ';
        }

        $this->_htmlContent .= 'validateErrorMessage="' . $validateErrorMessage . '" value="' . ($opened ? 1 : -1) . '"></div>';
    }


    /**
     * Add a form option bar component
     *
     * @param string $name The component name that will be sent as post. If not defined, this component data wont be sent
     * @param array $options The component options array. Each value must be an associative array with the option value and the label: [['value' => 'x', 'label' => 'y'], [...]]
     * @param string $label The component label (optional)
     * @param int $selectedIndex The component index. (first one by default)
     * @param string $id The component id (optional)
     */
    public function addOptionBarComponent($name, array $options, $label = '', $selectedIndex = 0, $id = '')
    {
        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<div class="componentFormOptionBarComponentContainer" selectedIndex="' . $selectedIndex . '" data="' . base64_encode(json_encode($options)) . '"></div>';
        $this->_htmlContent .= '<input type="hidden" ';

        if ($name != '') {
            $this->_htmlContent .= 'name="' . $name . '" ';
        }

        $this->_htmlContent .= 'value="' . $options[$selectedIndex]['value'] . '"></div>';
    }


    /**
     * Add a datepicker component
     *
     * @param array $componentOptions The component's options. Please check (ComponentDatePicker.js)
     * @param array $componentLiterals The component's literals. Please check (ComponentDatePicker.js)
     * @param string $validate The component validate condition.
     * @param string $validateErrorMessage The component validation error message and title separated by a semicolon
     * @param string $label The component label (optional)
     * @param string $validateCondition The component validate condition (AND by default)
     * @param string $id The component id (optional)
     */
    public function addDatePickerComponent(array $componentOptions = null, array $componentLiterals = null, $validate = '', $validateErrorMessage = '', $label = '', $validateCondition = '', $id = '')
    {
        $validateCondition = $validateCondition == '' ? 'AND' : $validateCondition;

        $this->_htmlContent .= $this->_addBaseInput($label, $id);
        $this->_htmlContent .= '<input type="text" class="componentFormDatePickerComponentBaseInput" ';
        $this->_htmlContent .= 'options="' . base64_encode(json_encode($componentOptions)) . '" ';
        $this->_htmlContent .= 'literals="' . base64_encode(json_encode($componentLiterals)) . '" ';
        $this->_htmlContent .= 'validate="' . $validate . '" validateCondition="' . $validateCondition . '" ';
        $this->_htmlContent .= 'validateErrorMessage="' . $validateErrorMessage . '"></div>';
    }


    /**
     * Add extra content to the form
     *
     * @param string $html
     */
    public function addContent($html = '')
    {
        $this->_htmlContent .= $html;
    }


    /**
     * Add the base input to the form. The container and the label
     *
     * @param string $label The label for the input
     * @param string $id The id for the input container
     *
     * @return string
     */
    private function _addBaseInput($label, $id)
    {

        $result = '<div class="componentFormInputContainer"';

        if ($id != '') {
            $result .= ' id="' . $id . '"';
        }

        $result .= '>';

        if ($label != '') {
            $result .= '<p>' . $label . '</p>';
        }

        return $result;
    }
}