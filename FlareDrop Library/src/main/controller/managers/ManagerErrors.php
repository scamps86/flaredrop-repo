<?php

/*
 * Error manager
 */

class ManagerErrors
{
    private static $_sendMailNotification = true;


    public function initialize()
    {
        // Enable mail notification
        if (WebConfigurationBase::$ERROR_NOTIFY_MAIL != '') {

            // For fatal errors
            register_shutdown_function(function () {

                $error = error_get_last();

                if ($error != null) {
                    $errorData = [];
                    $errorData['type'] = 'PHP FATAL';
                    $errorData['fullUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $errorData['filePath'] = $error['file'];
                    $errorData['line'] = $error['line'];
                    $errorData['message'] = $error['message'];

                    if (count($_GET) > 0) {
                        $errorData['getParams'] = $_GET;
                    }

                    if (count($_POST) > 0) {
                        $errorData['postParams'] = $_POST;
                    }

                    if (count($_FILES) > 0) {
                        $errorData['files'] = $_FILES;
                    }

                    if (WebConfigurationBase::$MYSQL_HOST != '') {
                        if (count(Managers::mySQL(false)->queryList) > 0) {
                            $errorData['queries'] = Managers::mySQL(false)->queryList;
                        }
                    }

                    self::_sendMailNotification($errorData, WebConfigurationBase::$ERROR_NOTIFY_MAIL);
                }
            });

            // For errors and warnings
            set_error_handler(function ($errno, $message, $file, $line, $context) {

                $errorData = [];
                $errorData['type'] = 'PHP';
                $errorData['fullUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $errorData['filePath'] = $file;
                $errorData['line'] = $line;
                $errorData['message'] = $message;

                if (count($_GET) > 0) {
                    $errorData['getParams'] = $_GET;
                }

                if (count($_POST) > 0) {
                    $errorData['postParams'] = $_POST;
                }

                if (count($_FILES) > 0) {
                    $errorData['files'] = $_FILES;
                }

                if (WebConfigurationBase::$MYSQL_HOST != '') {
                    if (count(Managers::mySQL(false)->queryList) > 0) {
                        $errorData['queries'] = Managers::mySQL(false)->queryList;
                    }
                }

                $errorData['context'] = $context;
                $errorData['trace'] = '';

                self::_sendMailNotification($errorData, WebConfigurationBase::$ERROR_NOTIFY_MAIL);
            });
        }
    }


    /**
     * Send an error notification email with all error data
     *
     * @param array $errorData The full error data stored in an associative array containing the following params:<br>
     * <i>-type:</i> The error type (PHP, JAVASCRIPT...)<br>
     * <i>-fullUrl:</i> The full URL when the error is generated<br>
     * <i>-filePath:</i> The script file path where the error is generated<br>
     * <i>-line:</i> The script line where the error is generated<br>
     * <i>-message:</i> The error message<br>
     * <i>-usedMemory:</i> The script used memory<br>
     * <i>-getParams:</i> The GET params when the error is generated<br>
     * <i>-postParams:</i> The POST params when the error is generated<br>
     * <i>-files:</i> The files when the error is generated<br>
     * <i>-context:</i> The error context<br>
     * <i>-trace:</i> The error debug trace<br>
     *
     * @param string $email The destination email where the notification will be sent
     */
    private function _sendMailNotification(array $errorData, $email)
    {
        $errorMessage = '<b>Error type:</b> ' . (isset($errorData['type']) ? $errorData['type'] : 'Unknown') . '<br>';
        $errorMessage .= '<b>Full URL:</b> ' . (isset($errorData['fullUrl']) ? $errorData['fullUrl'] : 'Unknown') . '<br>';
        $errorMessage .= '<b>File path:</b> ' . (isset($errorData['filePath']) ? $errorData['filePath'] : 'Unknown') . '<br>';
        $errorMessage .= '<b>Line:</b> ' . (isset($errorData['line']) ? $errorData['line'] : 'Unknown') . '<br><br>';
        $errorMessage .= '<b>Message:</b> ' . (isset($errorData['message']) ? $errorData['message'] : 'Unknown') . '<br><br>';

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $errorMessage .= '<b>Browser:</b> ' . $_SERVER['HTTP_USER_AGENT'] . '<br><br>';
        }

        $errorMessage .= '<b>Cookies:</b><br>' . self::_extractParams($_COOKIE) . '<br><br>';

        if (isset($errorData['usedMemory'])) {
            $errorMessage .= '<b>Used memory:</b> ' . $errorData['usedMemory'] . ' of ' . ini_get('memory_limit') . '<br><br>';
        }

        if (isset($errorData['getParams'])) {
            $errorMessage .= '<b>GET params:</b><br>' . self::_extractParams($errorData['getParams']) . '<br><br>';
        }

        if (isset($errorData['postParams'])) {
            $errorMessage .= '<b>POST params:</b><br>' . self::_extractParams($errorData['postParams']) . '<br><br>';
        }

        if (isset($errorData['files'])) {
            $errorMessage .= '<b>Files:</b><br>' . self::_extractParams($errorData['files']) . '<br><br>';
        }

        if (isset($errorData['queries'])) {
            $errorMessage .= '<b>Queries:</b><br>' . self::_extractParams($errorData['queries']) . '<br><br>';
        }

        $errorMessage .= '<b>Server:</b><br>' . self::_extractParams($_SERVER) . '<br><br>';

        if (isset($errorData['context'])) {
            $errorMessage .= '<b>Context:</b><br>' . self::_extractParams($errorData['context']) . '<br><br>';
        }

        if (isset($errorData['trace'])) {
            $errorMessage .= '<b>Trace:</b> ' . self::_debugBacktraceGenerate() . '<br><br>';
        }

        // Define the email subject
        $subject = isset($errorData['type']) ? $errorData['type'] : 'UNKNOWN';
        $subject .= ' error notification in ' . $_SERVER['HTTP_HOST'];

        // Send the email
        if (self::$_sendMailNotification) {
            Managers::mailing()->send(WebConfigurationBase::$MAIL_NOREPLY, $email, $subject, $errorMessage);
        }

        // Prevent sending more mail notifications caused for this error
        self::$_sendMailNotification = false;
    }


    /**
     * Extract params from an array / object and format it as an HTML code like:<br> <i>-KEY:</i> <b>VALUE</b>
     *
     * @param mixed $params The array or object containing the params
     * @return string
     */
    private function _extractParams($params)
    {
        $result = '';
        foreach ($params as $k => $v) {
            $result .= '<i>-' . $k . ':</i> ' . (is_array($v) || is_object($v) ? nl2br(str_replace(' ', '&nbsp;', print_r($v, true))) : '<b>' . $v . '</b>') . '<br>';
        }
        return $result;
    }


    /**
     * Generate PHP error backtrace
     *
     * @return string
     */
    private function _debugBacktraceGenerate()
    {
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_contents();
        ob_end_clean();

        // Renumber backtrace items.
        $trace = nl2br(preg_replace('/^#(\d+)/me', '\'<br>#\' . ($1 - 1)', $trace));
        return $trace;
    }
}
 