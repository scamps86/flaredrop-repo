<?php

/** Array utils */
class UtilsDiskObject
{


    /**
     * Get an array of file objects through the resulting files / pictures concatenated string. Empty array if no pictures found
     *
     * @param string $files The files or pictures to get
     *
     * @return array
     */
    public static function filesArrayGet($files)
    {
        $result = [];

        if ($files != '') {
            $files = explode(';', $files);

            foreach ($files as $f) {
                $p = explode(',', $f);
                $file = new VoFile();
                $file->fileId = $p[0];
                $file->filename = $p[1];
                $file->private = $p[2];
                array_push($result, $file);
            }
        }
        return $result;
    }


    /**
     * Get the first file only if exists. If not exists it return a null object
     *
     * @param string $files The files or pictures to get
     *
     * @return VoFile
     */
    public static function firstFileGet($files)
    {
        $files = self::filesArrayGet($files);
        return count($files) > 0 ? $files[0] : null;
    }


    /**
     * Get the folder ids inside an array. It will return null if no folders found
     *
     * @param string $folders The concatenated folder ids string
     *
     * @return array The folder ids array
     */
    public static function folderIdsGet($folders)
    {
        $result = explode(';', $folders);
        return $result === false ? null : $result;
    }


    /**
     * Get the first object folder id. If no folders found it will return an empty string
     *
     * @param string $folders The concatenated folder ids string
     *
     * @return string The folder id
     */
    public static function firstFolderIdGet($folders)
    {
        $folders = self::folderIdsGet($folders);

        if ($folders != null && count($folders) > 0) {
            return $folders[0];
        } else {
            return '';
        }
    }

}