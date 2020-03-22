<?php

/**
 * File utilities
 */
class UtilsFile
{

    /**
     * Converts a simple blob to a file object
     *
     * @param $blob string
     * @param $name string
     * @param $type 'image/jpeg', etc
     * @param $extension string
     *
     * @return array the file info
     */
    public static function blobToFile($blob, $name, $type, $extension)
    {
        return [
            'data' => $blob,
            'size' => strlen($blob),
            'name' => $name,
            'type' => $type,
            'extension' => $extension
        ];
    }


}