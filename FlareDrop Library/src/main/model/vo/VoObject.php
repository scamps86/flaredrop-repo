<?php

class VoObject
{

    public $objectId = '';
    public $type = '';
    public $folderIds = '';
    public $privilegeId = '';
    public $creationDate = '';
    public $files = '';
    public $pictures = '';
    public $properties = ''; //JSON encoded properties
    public $literals = [];


    /**
     * Get a non localized property. Empty if not exists
     *
     * @param string $property The property to get
     *
     * @return string
     */
    public function propertyGet($property)
    {
        return self::_jsonPropertyGet($this->properties, $property);
    }


    /**
     * Get a localized property. Empty if not exists
     *
     * @param string $property The property to get
     * @param string $lanTag The lan tag. Selected one by default
     *
     * @return string
     */
    public function localizedPropertyGet($property, $lanTag = '')
    {
        $lanTag = $lanTag == '' ? WebConstants::getLanTag() : $lanTag;
        foreach ($this->literals as $l) {
            if ($l->tag == $lanTag) {
                return self::_jsonPropertyGet($l->properties, $property);
            }
        }
        return '';
    }


    /**
     * Set or update a property for the object. If we don't save it, the changes won't be affect the database
     *
     * @param string $property The property name
     * @param string $value The property value
     */
    public function propertySet($property, $value)
    {
        $properties = json_decode($this->properties, true);
        $properties[$property] = $value;
        $this->properties = json_encode($properties);
    }


    /**
     * Get an array of file objects through the resulting files / pictures concatenated string. Empty array if no pictures found
     *
     * @param boolean $usePictures Get files or pictures (pictures by default)
     *
     * @return array
     */
    public function filesArrayGet($usePictures = true)
    {
        $result = [];
        $files = [];

        if ($usePictures) {
            if ($this->pictures != '') {
                $files = explode(';', $this->pictures);
            }
        } else if ($this->files != '') {
            $files = explode(';', $this->files);
        }

        foreach ($files as $f) {
            $p = explode(',', $f);
            $file = new VoFile();
            $file->fileId = $p[0];
            $file->filename = $p[1];
            $file->private = $p[2];
            array_push($result, $file);
        }
        return $result;
    }


    /**
     * Get the first file only if exists. If not exists it return a null object
     *
     * @param boolean $usePictures Get files or pictures (pictures by default)
     *
     * @return VoFile
     */
    public function firstFileGet($usePictures = true)
    {
        $files = $this->filesArrayGet($usePictures);
        return count($files) > 0 ? $files[0] : null;
    }


    /**
     * Get the folder ids inside an array. It will return null object if no folders found
     *
     * @return array The folder ids array
     */
    public function folderIdsGet()
    {
        $result = explode(';', $this->folderIds);
        return $result === false ? null : $result;
    }


    /**
     * Get the first object folder id. If no folders found it will return an empty string
     *
     * @return string The folder id
     */
    public function firstFolderIdGet()
    {
        $folders = $this->folderIdsGet();

        if ($folders != null && count($folders) > 0) {
            return $folders[0];
        } else {
            return '';
        }
    }


    /**
     * Get a property from a json content. Empty if not exists
     *
     * @param string $jsonContent The json content
     * @param string $property The property name
     *
     * @return string
     */
    private function _jsonPropertyGet($jsonContent, $property)
    {
        $properties = json_decode($jsonContent, true);
        foreach ($properties as $k => $v) {
            if ($k == $property) {
                return $v;
            }
        }
        return '';
    }
}