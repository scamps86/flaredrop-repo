<?php

/** Server result utils */
class UtilsResult
{
    /**
     * Generate an OK result
     *
     * @param string $description [OPTIONAL] The result description message
     * @param mixed $data [NULL by default] The data to be returned. It can be any type of data.
     *
     * @return VoResult
     */
    public static function generateSuccessResult($description = '', $data = null)
    {
        // Create new result object
        $result = new VoResult();

        // Fill the result object
        $result->state = true;
        $result->description = $description;
        $result->data = $data;

        return $result;
    }


    /**
     * Generate an error resul
     *
     * @param string $description [OPTIONAL] The result description message
     * @param mixed $data [NULL by default] The data to be returned. It can be any type of data
     * @param boolean $triggerError [TRUE by default] Trigger error or not
     *
     * @return VoResult
     */
    public static function generateErrorResult($description = '', $data = null, $triggerError = true)
    {
        // Trigger the error
        if ($triggerError) {
            trigger_error($description, E_USER_WARNING);
        }

        // Create new result object
        $result = new VoResult();

        // Fill the result object
        $result->state = false;
        $result->description = $description;
        $result->data = $data;

        return $result;
    }
}