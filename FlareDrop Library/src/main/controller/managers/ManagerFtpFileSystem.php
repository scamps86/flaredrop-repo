<?php

/**
 * FTP filesystem manager
 */
class ManagerFtpFileSystem
{

    /**
     * Get the directory items
     *
     * @param string $directoryPath The directory path
     *
     * @return array The list
     */
    public static function dirList($directoryPath)
    {
        $list = [];
        if (self::fileExists($directoryPath)) {
            $list = scandir($directoryPath, SCANDIR_SORT_ASCENDING);
        }
        return $list;
    }


    /**
     * Creates a directory only if it doesn't exist
     *
     * @param string $directoryPath The directory path
     * @param int $mode The mode
     *
     * @return bool
     */
    public static function dirCreate($directoryPath, $mode = 0777)
    {
        if (!self::fileExists($directoryPath)) {
            return mkdir($directoryPath, $mode, true);
        }
        return true;
    }


    /**
     * Print the file data contents on the browser
     *
     * @param string $filePath The file path or HTTP URL
     * @param boolean $print Tells if the file is printed or is returned as a binary data
     *
     * @return string File data if print is disabled
     */
    public static function fileData($filePath, $print = false)
    {
        $handle = fopen($filePath, 'r');
        $buffer = '';
        ob_start();

        while (!feof($handle)) {
            $d = fread($handle, UtilsUnits::megabytesToBytes(1));

            if ($print) {
                echo $d;
            } else {
                $buffer .= $d;
            }

            ob_flush();
            flush();
        }
        fclose($handle);
        return $buffer;
    }


    /**
     * Get the file content type
     *
     * @param string $filePath The file path
     * @param string $binaryData The file binary
     *
     * @return string The file content type
     */
    public static function fileContentType($filePath = '', $binaryData = '')
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if ($filePath != '') {
            return $contentType = $finfo->file($filePath);
        }
        if ($binaryData != '') {
            return $finfo->buffer($binaryData);
        }
        return 'unknown';
    }


    /**
     * Get file size from a path or a binary data
     *
     * @param string $filePath The file path
     * @param string $binaryData The file binary data
     *
     * @return int the size of the file in bytes, or false (and generates an error of level E_WARNING) in case of an error.
     */
    public static function fileSize($filePath = '', $binaryData = '')
    {
        return $filePath != '' ? filesize($filePath) : strlen($binaryData);
    }


    /**
     * Check if a file exists or not
     *
     * @param string $filePath The file path
     */
    public static function fileExists($filePath)
    {
        return file_exists($filePath);
    }


    /**
     * Remove a file
     *
     * @param string $filePath The file path
     *
     * @return boolean Returns true on success or false on failure. If not exists returns true.
     */
    public static function fileRemove($filePath)
    {
        return unlink($filePath);
    }


    /**
     * Saves a file
     *
     * @param string $filePath The full path where the file will be stored, including the full file name
     * @param string $binaryData Binary data that will be stored to the file
     * @param int $mode The file permisions. 0644 by default
     *
     * @return bool If the file is created or not
     */
    public static function fileSave($filePath, $binaryData = '', $mode = 0644)
    {
        $fopen = fopen($filePath, 'wb');

        if ($fopen === false) {
            return false;
        }

        $fwrite = fwrite($fopen, $binaryData);

        if ($fwrite === false) {
            return false;
        }

        if (!fclose($fopen)) {
            return false;
        }

        if (!chmod($filePath, $mode)) {
            return false;
        }
        return true;
    }


    /**
     * Get the file extension from its file name
     *
     * @param string $fileName The file name
     *
     * @return string
     */
    public static function fileExtension($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }
}