<?php

/** Folder */
class VoFolder
{
    public $folderId = '';
    public $rootId = '';
    public $diskId = '';
    public $visible = '';
    public $level = '';
    public $objectType = '';
    public $parentFolderId = null;
    public $privilegeId = '';
    public $index = '';
    public $literals = [];
    public $data = '';
    public $pictures = '';
    public $files = '';


    /**
     * Get the folder localized name. Empty if not exists
     *
     * @param string $lanTag The lan tag. The actual one by default
     *
     * @return string
     */
    public function nameGet($lanTag = '')
    {
        return self::_localizedPropertyGet('name', $lanTag == '' ? WebConstants::getLanTag() : $lanTag);
    }


    /**
     * Get the folder localized description. Empty if not exists
     *
     * @param string $lanTag The lan tag. The actual one by default
     *
     * @return string
     */
    public function descriptionGet($lanTag = '')
    {
        return self::_localizedPropertyGet('description', $lanTag == '' ? WebConstants::getLanTag() : $lanTag);
    }


    /**
     * Get the folder localized extra data. Empty if not exists
     *
     * @param string $lanTag The lan tag. The actual one by default
     *
     * @return string
     */
    public function dataGet($lanTag = '')
    {
        return self::_localizedPropertyGet('data', $lanTag == '' ? WebConstants::getLanTag() : $lanTag);
    }


    /**
     * Get a localized property. Empty if not exists
     *
     * @param string $property The property to get
     * @param string $lanTag The lan tag
     *
     * @return string
     */
    private function _localizedPropertyGet($property, $lanTag)
    {
        foreach ($this->literals as $l) {
            if ($l->tag == $lanTag) {
                return $l->$property;
            }
        }
        return '';
    }
}