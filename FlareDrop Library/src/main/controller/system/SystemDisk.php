<?php

class SystemDisk
{

    /**
     * Get the FlareDrop system disks
     *
     * @return array
     */
    public static function getDisks()
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        // Define the query
        $q = new VoSelectQuery();
        $q->select = '*';
        $q->from = 'disk';

        // Do the query
        return $connection->queryToArray($q->generateQuery());
    }


    /**
     * Get a folder. Null if it doesn't exist
     *
     * @param int $folderId The folder id
     * @param string $objectType The folder object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user) (false by default)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoFolder
     */
    public static function folderGet($folderId, $objectType, $securityEnabled = false, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = '*, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE ff.folderId = f.folderId AND fi.fileId = ff.fileId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE ff.folderId = f.folderId AND fi.fileId = ff.fileId AND fi.type = 'picture') as pictures";
        $q->from = 'folder f';
        $q->where = 'f.folderId=' . UtilsString::sqlQuote($folderId) . ' AND f.objectType=' . UtilsString::sqlQuote($objectType);

        // Get the folder data
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Validate if the folder exists
        if (!isset($q->result['folderId'])) {
            return null;
        }

        // Define the folder class
        $folder = new VoFolder();
        $folder = UtilsArray::arrayToClass($q->result, $folder);

        // Define a new MySQL query to get all folder literals
        $q = new VoSelectQuery();
        $q->select = 'lanId, tag, name, description';
        $q->from = 'folder_lan';
        $q->where = 'folderId = ' . UtilsString::sqlQuote($folderId);

        // Get the folder literals from the database
        $q->result = $connection->queryToArray($q->generateQuery());

        // Set the literals
        $folder->literals = [];

        foreach ($q->result as $l) {
            // Define the folder lan class
            $folderLan = new VoFolderLan();

            // Fill the folder lan class
            $folderLan = UtilsArray::arrayToClass($l, $folderLan);

            // Add the locale to the object's locales array
            array_push($folder->literals, $folderLan);
        }

        return $folder;
    }


    /**
     * Set the specified folder to the database
     *
     * @param VoFolder $folder The folder class to save
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult The setting result. If it success, it will attach the folder class
     */
    public static function folderSet(VoFolder $folder, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Set default values if not defined
        if ($folder->privilegeId === '') {
            $folder->privilegeId = WebConfigurationBase::$PRIVILEGE_WRITE_ID;
        }

        if ($folder->visible === '') {
            $folder->visible = 1;
        }

        if ($folder->index === '') {
            $folder->index = 0;
        }

        // Start the transaction
        $connection->transactionStart();

        // Save or update the base folder
        if (!$connection->insertUpdateFromClass($folder, 'folderId', 'folder', 'rootId, visible, diskId, objectType, privilegeId, index, data' . ($folder->parentFolderId == null ? '' : ', parentFolderId'))) {
            $connection->transactionRollback();
            return UtilsResult::GenerateErrorResult('Could not insert/update folder base. ' . $connection->lastError);
        }

        // If the folder id is not defined, we have to get it from the database
        if ($folder->folderId == '') {
            $folder->folderId = $connection->lastInsertIdGet();
        }

        // Insert or update the current specified locales
        foreach ($folder->literals as $l) {

            // Set the folder id to its locale class
            $l->folderId = $folder->folderId;

            // Do the insert or update
            if (!$connection->insertUpdateFromClass($l, 'lanId', 'folder_lan', 'folderId, tag, name, description, data')) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Could not insert/update folder literals ' . $folder->folderId . ' (' . $l->tag . '). ' . $connection->lastError);
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Folder created.', $folder);
    }


    /**
     * Get a folders list
     *
     * @param int $rootId The system root id
     * @param string $objectType The object type of the folder
     * @param int $diskId The disk id where the folders are
     * @param boolean $getVisible Get only the visible folders or not
     * @param string $lanTag The literal tag
     * @param int $parentFolderId The parent folder id (not mandatory)
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user) (false by default)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return array The folders list as a tree associative array. Each children on the children key of the level
     */
    public static function foldersGet($rootId, $objectType, $diskId, $getVisible, $lanTag, $parentFolderId = null, $securityEnabled = false, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query to get the folders
        $q = new VoSelectQuery();
        $q->select = 'f.*, fl.tag, fl.name, fl.description, fl.data, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE ff.folderId = f.folderId AND fi.fileId = ff.fileId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE ff.folderId = f.folderId AND fi.fileId = ff.fileId AND fi.type = 'picture') as pictures";
        $q->from = 'folder f, folder_lan fl';
        $q->where = 'f.objectType=' . UtilsString::sqlQuote($objectType) . ' AND f.rootId=' . UtilsString::sqlQuote($rootId);
        $q->where .= ' AND fl.tag=' . UtilsString::sqlQuote($lanTag) . ' AND f.diskId=' . UtilsString::sqlQuote($diskId);
        $q->where .= ' AND fl.folderId=f.folderId';

        if ($getVisible) {
            $q->where .= ' AND f.visible=1';
        }

        $q->orderBy = 'f.index ASC';

        // Execute the query on database
        $q->result = $connection->queryToArray($q->generateQuery());

        // Generate and return the tree
        return self::_foldersTreeGenerate($q->result, $parentFolderId);
    }


    /**
     * Remove a set of folders
     *
     * @param int $folderId
     * @param string $objectType
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function folderRemove($folderId, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query to get the folders
        $q = new VoSelectQuery();
        $q->select = 'f.folderId, f.privilegeId, f.parentFolderId, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE fi.fileId = ff.fileId AND ff.folderId = f.folderId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId SEPARATOR ';'), '') FROM folder_file ff, file fi WHERE fi.fileId = ff.fileId AND ff.folderId = f.folderId AND fi.type = 'picture') as pictures";
        $q->from = 'folder f';
        $q->where = 'objectType=' . UtilsString::sqlQuote($objectType);

        // Get the folder children as a list
        $q->result = $connection->queryToArray($q->generateQuery());
        $folders = self::foldersChildrenGet($q->result, $folderId);

        // Also add the folder that we are removing
        foreach ($q->result as $folder) {
            if ($folder['folderId'] == $folderId) {
                array_push($folders, $folder);
            }
        }

        // Define array to store linked file ids to be removed
        $filesToRemove = [];

        // Loop all the received folders and remove them if allowed
        foreach ($folders as $folder) {
            if ($folder['privilegeId'] == WebConfigurationBase::$PRIVILEGE_WRITE_ID) {
                // Push the pictures and files to remove
                if ($folder['pictures'] != '') {
                    $filesToRemove = array_merge($filesToRemove, explode(';', $folder['pictures']));
                }
                if ($folder['files'] != '') {
                    $filesToRemove = array_merge($filesToRemove, explode(';', $folder['files']));
                }
            } else {
                return UtilsResult::GenerateErrorResult('Folder ' . $folder['folderId'] . ' remove is not allowed', null, false);
            }
        }

        // Get the objects that are inside the folder to remove the linked pictures
        $filter = new VoSystemFilter();
        $filter->setFolderId($folderId);

        $list = $objectType == 'user' ? SystemUsers::getList($filter) : self::objectsGet($filter, $objectType);
        $objectsToRemove = [];

        foreach ($list->list as $o) {
            if ($objectType == 'user') {
                array_push($objectsToRemove, $o['userId']);
            } else {
                array_push($objectsToRemove, $o['objectId']);
            }
        }

        // Loop all folders and unlink the objects from them
        foreach ($folders as $f) {
            $deleteResult = $objectType == 'user' ? SystemUsers::unlink($objectsToRemove, $f{'folderId'}) : self::objectsUnlink($objectsToRemove, $f{'folderId'}, $objectType, $securityEnabled, $securityUserDiskId);

            if (!$deleteResult->state) {
                return UtilsResult::GenerateErrorResult('Folder ' . $folderId . ' remove failed because has an object that cannot be removed or there is a problem when unlinking the objects.', null, false);
            }
        }

        // Remove the folder and its children
        if (!$connection->query('DELETE FROM folder WHERE folderId=' . UtilsString::sqlQuote($folderId) . ' AND objectType=' . UtilsString::sqlQuote($objectType))) {
            return UtilsResult::GenerateErrorResult('Error removing folder ' . $folderId . '. ' . $connection->lastError);
        }

        // Remove the linked files and pictures
        $result = self::filesRemove($filesToRemove, $securityEnabled, $securityUserDiskId);

        if (!$result->state) {
            return UtilsResult::GenerateErrorResult('There was an error removing the linked files from the file system.');
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Folders remove ok');
    }


    /**
     * Sort a list of folders
     *
     * @param array $sortData An associative array containing [folderId, index] for each folder
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function foldersSort(array $sortData, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Initialize transaction
        $connection->transactionStart();

        // Do the sorting updates
        foreach ($sortData as $k => $v) {
            if (!$connection->update('folder', ['index' => $v], 'folderId=' . $k)) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Error sorting the folder ' . $k . '. ' . $connection->lastError);
            }
        }

        // Commit the transaction
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Sort ok');
    }


    /**
     * Move a folder to another one
     *
     * @param int $sourceFolderId The folder id that will be moved
     * @param int $destinationFolderId The destination folder id where the source folder will be moved. Null means that the folder must be moved to the root
     * @param string $objectType The folders object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function folderMove($sourceFolderId, $destinationFolderId, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query to get the folders
        $q = new VoSelectQuery();
        $q->select = 'folderId, parentFolderId, rootId, diskId, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(f.fileId SEPARATOR ';'), '') FROM folder_file ff, file f WHERE f.fileId = ff.fileId) as pictures, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(f.fileId SEPARATOR ';'), '') FROM folder_file ff, file f WHERE f.fileId = ff.fileId) as files";
        $q->from = 'folder';
        $q->where = 'objectType=' . UtilsString::sqlQuote($objectType);

        // Get the folder children as a list to be moved
        $q->result = $connection->queryToArray($q->generateQuery());
        $sourceFolders = self::foldersChildrenGet($q->result, $sourceFolderId);

        // Define the destination folder
        $destinationFolder = $destinationFolderId != null ? self::folderGet($destinationFolderId, $objectType) : new VoFolder();

        // Validate if the folder disk id and root id matches the destination folder
        foreach ($sourceFolders as $s) {
            if ($destinationFolderId != null) {
                if ($s['diskId'] != $destinationFolder->diskId) {
                    return UtilsResult::GenerateErrorResult('The disk id for the folder ' . $s['folderId'] . ' not match to the destination folder.');
                }

                if ($s['rootId'] != $destinationFolder->rootId) {
                    return UtilsResult::GenerateErrorResult('The root id for the folder ' . $s['folderId'] . ' not match to the destination folder.');
                }
            }
        }

        // Update the folder path
        $destinationValue = $destinationFolderId == null ? 'NULL' : $destinationFolderId;

        if (!$connection->query('UPDATE folder SET parentFolderId=' . $destinationValue . ' WHERE folderId=' . UtilsString::sqlQuote($sourceFolderId))) {
            return UtilsResult::GenerateErrorResult('Error moving the folder ' . $sourceFolderId . '. ' . $connection->lastError);
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Folder move ok');
    }


    /**
     * Link a set of files to a folder or an object
     *
     * @param int $folderId The folder id (needed to link the file to a folder)
     * @param int $objectId The object id (needed to link the file to an object)
     * @param string $fileType File type (file or picture) ['data' (optional), 'size', 'name', 'type','extension', 'tmp_name' (if not, it gets the data blob)]
     * @param array $files The received files info array from the PHP
     * @param string $pictureDimensions Needed if the file type is a picture. It defines all the thumbnail dimensions that will be generated: 100x50;200x100;...
     * @param int $pictureQuality The 0-100 picture quality only used if the file type is an image
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function filesSet($folderId = -1, $objectId = -1, $fileType, array $files, $pictureDimensions = '', $pictureQuality = 0, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Validate the files size
        $toAddSize = 0;

        foreach ($files as $f) {
            $toAddSize += $f['size'];
        }

        $usedSpace = self::fileUsedSpaceGet();
        $configuration = SystemManager::configurationGet(WebConfigurationBase::$ROOT_ID);

        if ($usedSpace + $toAddSize > UtilsUnits::megabytesToBytes($configuration['global']['allowedSpace'])) {
            $freeSpace = UtilsFormatter::setDecimals((int)$configuration['global']['allowedSpace'] - UtilsUnits::bytesToMegabytes($usedSpace), 2);
            echo 'There is no more rate space. Free space: ' . $freeSpace . ' MB. To add: ' . UtilsUnits::bytesToMegabytes($toAddSize) . ' MB.';
            die();
        }

        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Initialize the transaction
        $connection->transactionStart();

        // Insert the files info to the database and file system
        $fieldsMain = ['type', 'name', 'extension', 'size', 'private', 'data'];
        $fieldsCustom = ['fileId'];

        // Operations if the file is for a folder or for an object
        if ($folderId != -1) {
            array_push($fieldsCustom, 'folderId');
        } else if ($objectId != -1) {
            array_push($fieldsCustom, 'objectId');
        }

        for ($i = 0; $i < count($files); $i++) {
            // Do the inserts
            $data = [$fileType, $files[$i]['name'], $files[$i]['extension'], $files[$i]['size'], 0, $files[$i]['data']];

            if (!$connection->insert('file', $fieldsMain, [$data])) {
                $connection->transactionRollback();
                return UtilsResult::generateErrorResult('Error saving the main file info on the database: ' . $files[$i]['name'] . '. ' . $connection->lastError);
            }

            $files[$i]['fileId'] = $connection->getLastInsertId();
            $tableName = '';

            if ($folderId != -1) {
                $data = [$files[$i]['fileId'], $folderId];
                $tableName = 'folder_file';
            } else if ($objectId != -1) {
                $data = [$files[$i]['fileId'], $objectId];
                $tableName = 'object_file';
            }

            if (!$connection->insert($tableName, $fieldsCustom, [$data])) {
                $connection->transactionRollback();
                return UtilsResult::generateErrorResult('Error saving the custom file info on the database: ' . $files[$i]['name'] . '. ' . $connection->lastError);
            }
        }

        // Save the files data to the database files folder, and create the folder if it doesn't exist
        if (!Managers::ftpFileSystem()->dirCreate(PATH_MODEL . 'db_files/')) {
            $connection->transactionRollback();
            return UtilsResult::generateErrorResult('Error creating the db_files folder. ' . PATH_MODEL . 'db_files/');
        }

        $addedFileIds = [];

        // For NORMAL files
        if ($fileType == 'file') {
            foreach ($files as $f) {
                $binaryData = isset($f['tmp_name']) ? Managers::ftpFileSystem()->fileData($f['tmp_name']) : $f['data'];

                if (!Managers::ftpFileSystem()->fileSave(PATH_MODEL . 'db_files/' . $fileType . '-' . $f['fileId'] . '_', $binaryData)) {
                    // If it fails, cancel the database changes and delete saved files from the file system
                    $connection->transactionRollback();

                    foreach ($addedFileIds as $addedFileId) {
                        Managers::ftpFileSystem()->fileRemove(PATH_MODEL . 'db_files/' . $fileType . '-' . $addedFileId . '_');
                    }

                    return UtilsResult::generateErrorResult('Error saving the file to the file system: ' . $f['name']);
                }
                array_push($addedFileIds, $f['fileId']);
            }
        }

        // For PICTURE files
        if ($fileType == 'picture') {
            // Generate the dimensions array
            $dimensions = $pictureDimensions == '' ? null : explode(';', strtolower($pictureDimensions));

            // Save the pictures data to the database pictures folder
            $addedPictures = [];

            foreach ($files as $f) {

                // The picture total size
                $totalSize = 0;

                // Create the thumbnails array
                $thumbnails = [];

                // Add the main picture to the thumbnails array
                $thumbnail = [];
                $picBinary = isset($f['tmp_name']) ? Managers::ftpFileSystem()->fileData($f['tmp_name']) : $f['data'];
                $picDimensions = UtilsPicture::getDimensions($picBinary);
                $thumbnail['dimensions'] = '';
                $thumbnail['data'] = UtilsPicture::fit($picBinary, $picDimensions[0], $picDimensions[1], 1000); // Limit to 1000x1000 to prevent compression overflows
                $totalSize += Managers::ftpFileSystem()->fileSize('', $thumbnail['data']);;
                array_push($thumbnails, $thumbnail);

                // Fill all image thumbnails
                if ($dimensions != null) {
                    foreach ($dimensions as $d) {
                        $thumbnail = [];
                        $dim = explode('x', $d);
                        $thumbnail['dimensions'] = $d;
                        $thumbnail['data'] = UtilsPicture::crop($thumbnails[0]['data'], $dim[0], $dim[1]);
                        $thumbnail['data'] = UtilsPicture::setQuality($thumbnail['data'], $pictureQuality);
                        $totalSize += Managers::ftpFileSystem()->fileSize('', $thumbnail['data']);
                        array_push($thumbnails, $thumbnail);
                    }
                }

                // Save each thumbnail to the db files folder
                foreach ($thumbnails as $t) {
                    $pictureFileName = $fileType . '-' . $f['fileId'] . '_' . ($t['dimensions'] == '' ? '' : $t['dimensions']);

                    if (!Managers::ftpFileSystem()->fileSave(PATH_MODEL . 'db_files/' . $pictureFileName, $t['data'])) {
                        // If it fails, cancel the database changes and delete saved pictures from the file system
                        $connection->transactionRollback();

                        foreach ($addedPictures as $addedPictureFileName) {
                            Managers::ftpFileSystem()->fileRemove(PATH_MODEL . 'db_files/' . $addedPictureFileName);
                        }
                        return UtilsResult::generateErrorResult('Error saving the picture to the file system: ' . $f['name']);
                    }
                    array_push($addedPictures, $pictureFileName);
                }

                // Update the total picture size considering each own thumbnails on the database
                if (!$connection->update('file', ['size' => $totalSize], 'fileId = ' . $f['fileId'])) {
                    $connection->transactionRollback();
                    return UtilsResult::generateErrorResult('Error updating the picture size on the database: ' . $f['name']);
                }
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Files added.', $addedFileIds);
    }


    /**
     * Prints a file
     *
     * @param int $fileId The file id to print
     * @param string $validationKey The private file validation key (necessary only to get a private file)
     * @param string $pictureDimensions The picture dimensions like 100x200 (necessary only for picture files. If not defined, it will print the large one)
     * @param boolean $getBlob just get the blob data and don't generate the headers
     *
     * @return string The blob data if requested
     */
    public static function filePrint($fileId, $validationKey = '', $pictureDimensions = '', $getBlob = false)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = 'name, private, type';
        $q->from = 'file';
        $q->where = 'fileId=' . UtilsString::sqlQuote($fileId);

        // Get the file name and if it's private or not
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Validate if the picture exists on the database
        if (!isset($q->result['name'])) {
            UtilsHttp::error404();
            die();
        }

        // Check if the file is private and the validation key
        if ($q->result['private'] == 1) {
            // Get the session user
            $session = SystemUsers::login();
            $userData = $session->data;

            if (!self::fileValidatePrivateKey($validationKey, $fileId, $userData->userId)) {
                UtilsHttp::error404();
                die();
            }
        }

        $filePath = PATH_MODEL . 'db_files/' . $q->result['type'] . '-' . $fileId . '_';

        if ($pictureDimensions != '') {
            $filePath .= $pictureDimensions;
        }

        if (!Managers::ftpFileSystem()->fileExists($filePath)) {
            UtilsHttp::error404();
            die();
        }

        // Get the file necessary headers info
        $contentType = Managers::ftpFileSystem()->fileContentType($filePath);
        $fileSize = Managers::ftpFileSystem()->fileSize($filePath);

        // Generate the file headers
        if (!$getBlob) {
            UtilsHttp::fileGenerateHeaders($contentType, $fileSize, $q->result['name'], false);
            Managers::ftpFileSystem()->fileData($filePath, true);
        } else {
            return Managers::ftpFileSystem()->fileData($filePath);
        }
    }


    /**
     * Remove one or more files from the database and the file system
     *
     * @param array $fileIds An array containing all file ids to be removed
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function filesRemove(array $fileIds, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Validate the ids array
        if (count($fileIds) > 0) {
            // Get global server database connection
            $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

            // Initialize transaction
            $connection->transactionStart();

            // Remove all requested files from the database
            if (!$connection->query('DELETE FROM file WHERE ' . UtilsArray::sqlArrayToCondition($fileIds, 'fileId='))) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Error removing the files. ' . $connection->lastError);
            }

            // Remove all requested files from the file system
            $files = Managers::ftpFileSystem()->dirList(PATH_MODEL . 'db_files/');

            foreach ($fileIds as $id) {
                foreach ($files as $f) {
                    if (preg_match('/-' . $id . '_/', $f)) {
                        if (Managers::ftpFileSystem()->fileExists(PATH_MODEL . 'db_files/' . $f)) {
                            if (!Managers::ftpFileSystem()->fileRemove(PATH_MODEL . 'db_files/' . $f)) {
                                $connection->transactionRollback();
                                return UtilsResult::GenerateErrorResult('Error removing the files from the file system: ' . $id . '.');
                            }
                        }
                    }
                }
            }
            // Commit the transaction
            $connection->transactionCommit();
        }
        // Return the success result
        return UtilsResult::generateSuccessResult('File/s remove done.');
    }


    /**
     * Generate a validation key to allow the user getting the files marked as private
     *
     * @param int $fileId The file id for this validation key
     * @param int $userId The user id to allow using this validation code
     * @param string $mysqlExpirationDate The key expiration date
     *
     * @return string The generated validation key
     */
    public static function filePrivateKeyGenerate($fileId, $userId, $mysqlExpirationDate)
    {
        $timestamp = UtilsDate::toTimestamp($mysqlExpirationDate);
        $encodedDate = (intval($timestamp) + $userId) * 1714;
        $baseKey = md5('FlareDrop_' . $_SERVER['HTTP_HOST'] . ($fileId * $userId * $timestamp));

        return substr($baseKey, 0, 12) . $encodedDate . substr($baseKey, 12);
    }


    /**
     * Check if a validation key is valid or not
     *
     * @param string $validationKey The validation key to validate
     * @param int $userId The user id for this validation key
     * @param int $fileId The file id for this validation key
     *
     * @return Boolean
     */
    public static function fileValidatePrivateKey($validationKey, $fileId, $userId)
    {
        // Validate if the initial validation key has more than 35 digits
        if (strlen($validationKey) < 35) {
            return false;
        }

        // Retrieve the base key from the validation key
        $baseKey = substr($validationKey, 0, 12) . substr($validationKey, strlen($validationKey) - 20);

        // Validate if the base key is a valid md5
        if (strlen($baseKey) != 32 && !ctype_xdigit($baseKey)) {
            return false;
        }

        // Retrieve the encoded date from the validation key
        $encodedDateCharsCount = strlen($validationKey) - strlen($baseKey);
        $encodedDate = substr($validationKey, 12, $encodedDateCharsCount);

        // Retrieve the timestamp from the encoded date
        $timestamp = ($encodedDate / 1714) - $userId;

        // Validate the retrieved timestamp
        if (!UtilsDate::isValidTimestamp($timestamp)) {
            return false;
        }

        // Generate the attempted base key
        $attemptedBaseKey = md5('FlareDrop_' . $_SERVER['HTTP_HOST'] . ($fileId * $userId * $timestamp));

        // Validate the attempted base key
        if ($baseKey != $attemptedBaseKey) {
            return false;
        }

        // Validate if the retrieved timestamp is expired
        $actualTimestamp = UtilsDate::toTimestamp(UtilsDate::create());

        if ($timestamp < $actualTimestamp) {
            return false;
        }
        return true;
    }


    /**
     * Set a file as private or as public
     *
     * @param int $fileId The file id to operate
     * @param boolean $isPrivate Private or not
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function filePrivateSet($fileId, $isPrivate, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Do the update
        if (!$connection->update('file', ['private' => $isPrivate ? 1 : 0], 'fileId = ' . UtilsString::sqlQuote($fileId))) {
            return UtilsResult::GenerateErrorResult('Error setting the file private/public. ' . $connection->lastError);
        }

        // Return the success result
        return UtilsResult::generateSuccessResult('File private/public done.');
    }


    /**
     * Get the object. It will return a NULL if not exists
     *
     * @param int $objectId The object id that we want to get
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user) (false by default)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoObject
     */
    public static function objectGet($objectId, $objectType, $securityEnabled = false, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = 'o.*, f.folderId, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'picture') as pictures, ";
        $q->select .= "(SELECT GROUP_CONCAT(folderId SEPARATOR ';') FROM object_folder WHERE objectId = o.objectId) as folderIds";
        $q->from = 'object o, folder f, object_folder of';
        $q->where = 'o.objectId=' . UtilsString::sqlQuote($objectId) . ' AND o.type=' . UtilsString::sqlQuote($objectType) . ' AND f.objectType=o.type AND o.objectId = of.objectId';

        // Get the object main data
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Validate if the generic exists
        if (!isset($q->result['objectId'])) {
            return null;
        }

        // Build the main object class
        $object = new VoObject();
        $object = UtilsArray::arrayToClass($q->result, $object);

        // Generate a query to get the literals
        $q = new VoSelectQuery();
        $q->select = 'ol.*';
        $q->from = 'object o, object_lan ol';
        $q->where = 'ol.objectId = o.objectId AND o.objectId = ' . UtilsString::sqlQuote($object->objectId);

        // Get all object literals
        $q->result = $connection->query($q->generateQuery());

        // Loop all the received literals and add it to the object
        while ($row = $connection->getNextRow($q->result)) {

            $literal = new VoObjectLan();

            // Set the literal data to the literal class
            $literal = UtilsArray::arrayToClass($row, $literal);

            // Push the literal class to the literals array on the main object
            array_push($object->literals, $literal);
        }

        // Return the object
        return $object;
    }


    /**
     * Verify if an object exists
     *
     * @param int $objectId The object id to verify
     * @param string $objectType The object type
     *
     * @return boolean
     */
    public static function objectExists($objectId, $objectType)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Count the query results
        $q = new VoSelectQuery();
        $q->select = 'objectId';
        $q->from = 'object';
        $q->where = '';

        if ($objectId != '') {
            $q->where .= 'objectId=' . UtilsString::sqlQuote($objectId) . ' AND type=' . UtilsString::sqlQuote($objectType);
        }

        return $connection->count($q->generateQuery()) > 0;
    }


    /**
     * Set or update an object on the disk
     *
     * @param VoObject $objectData The object data
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult The setting result. If it success, the object will be attached
     */
    public static function objectSet(VoObject $objectData, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        if ($objectData->objectId != '') {
            // Verify that the object exists
            if (!self::objectExists($objectData->objectId, $objectType)) {
                return UtilsResult::GenerateErrorResult('Could not update object: ' . $objectData->objectId . ' because not exists.', null, false);
            }
        }

        // Set default values if not defined
        if ($objectData->privilegeId === '') {
            $objectData->privilegeId = WebConfigurationBase::$PRIVILEGE_WRITE_ID;
        }

        $objectData->type = $objectType;

        // Set the object's creation date if not defined
        if ($objectData->creationDate == '') {
            $objectData->creationDate = UtilsDate::create();
        }

        // Start the transaction
        $connection->transactionStart();

        // Save or update the object on the database
        if (!$connection->insertUpdateFromClass($objectData, 'objectId', 'object', 'privilegeId, type, creationDate, properties')) {
            $connection->transactionRollback();
            return UtilsResult::GenerateErrorResult('Could not insert/update object. ' . $connection->lastError);
        }

        // Get the object's id if it's not an update
        if ($objectData->objectId == '') {
            $objectData->objectId = $connection->lastInsertIdGet();
        }

        // Also add the localized properties on the object's language table
        foreach ($objectData->literals as $l) {
            // Set the object id on its literal class
            $l->objectId = $objectData->objectId;

            // Do the insert or update
            if (!$connection->insertUpdateFromClass($l, 'objectLanId', 'object_lan', 'tag, objectId, properties')) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Could not insert/update object literals: ' . $l->objectLanId . '. ' . $connection->lastError);
            }
        }

        // Link the object to the specified folder
        foreach (explode(';', $objectData->folderIds) as $fid) {
            if (!self::objectsLink([$objectData->objectId], $fid, $objectType, $securityEnabled, $securityUserDiskId)->state) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Could not insert/update object because of a folder link problem.' . $connection->lastError);
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Object created.', $objectData);
    }


    /**
     * Get a list of objects
     *
     * @param VoSystemFilter $filter The filter to consider when getting the objects. It can be used using the following options:<br>
     *
     * <i>diskId:</i> Get only the objects of the specified disk<br>
     * <i>rootId:</i> Get only the objects that are from this root<br>
     * <i>folderId:</i> Get only the objects containing this folder <br>
     * <i>lanTag:</i> Get the object localized properties in this language<br>
     * <i>propertySearch:</i> Search a text on a property. It's not case sensitive and it won't consider the accents <br>
     * <i>propertyMatch:</i> Get only the objects that matches a property <br>
     * <i>propertyInner:</i> Get only the objects that have a property value between two values (min and max) <br>
     * <i>sortFields:</i> Set which property is used to sort the list <br>
     * <i>pageCurrent:</i> Set the current page when we are getting a paginated list <br>
     * <i>pageNumItems:</i> Set the number of objects by page when we are getting a paginated list <br>
     * <i>random:</i> Randomize the resulting list
     *
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user) (false by default)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoList
     */
    public static function objectsGet(VoSystemFilter $filter, $objectType, $securityEnabled = false, $securityUserDiskId = 1)
    {
        // Validate the filter
        if (!$filter->validate()) {
            UtilsResult::generateErrorResult('Objects get, filter is not valid.');
            die();
        }

        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query to get the global object info
        $q = new VoSelectQuery();
        $q->select = 'o.*, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId, ',', fi.name, ',', fi.private SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'picture') as pictures, ";
        $q->select .= "(SELECT GROUP_CONCAT(folderId SEPARATOR ';') FROM object_folder WHERE objectId = o.objectId) as folderIds";
        $q->from = 'object o, folder f, object_folder of';
        $q->where = 'o.type=' . UtilsString::sqlQuote($objectType) . ' AND f.objectType = ' . UtilsString::sqlQuote($objectType) . ' AND o.objectId = of.objectId AND f.folderId = of.folderId';
        $q->groupBy = 'o.objectId';

        // Filter variables
        $itemsByPage = 0;
        $currentPage = 0;
        $propertyInner = null;
        $orderBy = null;
        $filterOperationIndex = 0;

        // APPLY THE FILTER
        $useLan = false;

        foreach ($filter->getData() as $c) {

            // Add the AND for the filter
            if ($filterOperationIndex == 0) {
                $q->where .= ' AND ';
            }

            // Add the logical operations
            if ($c[0] == 'logical') {
                $q->where .= ' ' . $c[1] . ' ';
            }

            // Filter by disk id
            if ($c[0] == 'diskId') {
                $q->where .= 'f.diskId=' . UtilsString::sqlQuote($c[1]);
            }

            // Filter by root id
            if ($c[0] == 'rootId') {
                $q->where .= 'f.rootId=' . UtilsString::sqlQuote($c[1]);
            }

            // Filter by folder id
            if ($c[0] == 'folderId') {
                $fq = new VoSelectQuery();
                $fq->select = 'folderId, parentFolderId';
                $fq->from = 'folder';
                $fq->where = 'objectType=' . UtilsString::sqlQuote($objectType);
                $folderIds = UtilsArray::extractProperty(self::foldersChildrenGet(Managers::mySQL(false)->queryToArray($fq->generateQuery()), $c[1]), 'folderId');
                array_push($folderIds, $c[1]);
                $q->where .= UtilsArray::sqlArrayToCondition($folderIds, 'f.folderId=');
            }

            // Filter by literal tag
            if ($c[0] == 'lanTag') {
                if (Managers::mySQL(false)->count('SELECT o.objectId FROM object_lan ol, object o WHERE ol.objectId = o.objectId AND o.type=' . UtilsString::sqlQuote($objectType)) > 0) {
                    $useLan = true;
                    $q->select .= ', ol.properties as lanProperties';
                    $q->from .= ', object_lan ol';
                    $q->where .= 'ol.objectId=o.objectId AND ol.tag=' . UtilsString::sqlQuote($c[1]);
                } else {
                    if (substr($q->where, -5) == ' AND ') {
                        $q->where = substr($q->where, 0, -5);
                    }
                }
            }

            // Filter by property search
            if ($c[0] == 'propertySearch') {
                $regexp = UtilsString::sqlQuote('{((.*)"' . UtilsString::regexEncode(UtilsString::jsonEncode($c[1][0])) . '":"){1}(.*)(' . UtilsString::regexEncode(UtilsString::jsonEncode($c[1][1])) . ')(.*)("}|","(.*)})');
                if ($useLan) {
                    $q->where .= '(o.properties REGEXP ' . $regexp;
                    $q->where .= ' OR ol.properties REGEXP ' . $regexp . ')';
                } else {
                    $q->where .= 'o.properties REGEXP ' . $regexp;
                }
            }

            // Filter by property propertyMatch
            if ($c[0] == 'propertyMatch') {
                $regexp = UtilsString::sqlQuote('{((.*)"' . UtilsString::regexEncode(UtilsString::jsonEncode($c[1][0])) . '":"){1}(' . UtilsString::regexEncode(UtilsString::jsonEncode($c[1][1])) . ')("}|","(.*)})');
                if ($useLan) {
                    $q->where .= '(o.properties REGEXP ' . $regexp;
                    $q->where .= ' OR ol.properties REGEXP ' . $regexp . ')';
                } else {
                    $q->where .= 'o.properties REGEXP ' . $regexp;
                }
            }

            // Filter by property propertyInner
            if ($c[0] == 'propertyInner') {
                $propertyInner = [];
                $propertyInner['property'] = $c[1][0];
                $propertyInner['from'] = $c[1][1];
                $propertyInner['to'] = $c[1][2];
                $propertyInner['type'] = $c[1][3];
            }

            // Sorting by a property
            if ($c[0] == 'sortField' && $q->orderBy != 'RAND()') {
                $orderBy = [];
                $orderBy['property'] = $c[1][0];
                $orderBy['type'] = $c[1][1];
            }

            if ($c[0] == 'random') {
                $q->orderBy = 'RAND()';
            }

            // Filter by page
            if ($c[0] == 'pageCurrent') {
                $currentPage = $c[1];
            }

            // Filter by the number of items by page
            if ($c[0] == 'pageNumItems') {
                $itemsByPage = $c[1];
            }

            // Increase process index
            $filterOperationIndex++;
        }

        // Set default sorting only if it's not in random mode
        if ($q->orderBy != 'RAND()') {
            $q->orderBy .= 'o.creationDate DESC';
        }

        // Generate the objects list
        $filteredList = [];
        $objectsList = $connection->queryToArray($q->generateQuery(true));

        foreach ($objectsList as $o) {
            // Extract custom properties and merge it to the object's associative array
            $p = $o['properties'] == '' ? [] : json_decode($o['properties'], true);
            $lp = [];

            if (isset($o['lanProperties'])) {
                $lp = $o['lanProperties'] == '' ? $lp : json_decode($o['lanProperties'], true);
            }

            unset($o['properties'], $o['lanProperties']);

            // Merge the object
            $object = array_merge($o, $p, $lp);

            // Filter by property inner
            $propertyInnerDone = true;

            if ($propertyInner != null) {
                $propertyInnerDone = false;
                $valueProperty = isset($object[$propertyInner['property']]) ? strtolower($object[$propertyInner['property']]) : '';

                if ($propertyInner['type'] == 'DATE') {
                    $valueProperty = date($valueProperty);
                }
                if ($propertyInner['type'] == 'TEXT' || $propertyInner['type'] == 'NUMBER' || $propertyInner['type'] == 'DATE') {
                    $propertyInnerDone = $propertyInner['from'] < $valueProperty && $valueProperty < $propertyInner['to'];
                }
            }

            if ($propertyInnerDone) {
                array_push($filteredList, $object);
            }
        }

        // Order the list
        if ($orderBy != null) {
            $type = $orderBy['type'] == 'ASC' ? SORT_ASC : SORT_DESC;
            $filteredList = UtilsArray::arrayOfAssociativeArraysSort($filteredList, $orderBy['property'], $type);
        }

        // Create the list
        $list = new VoList();
        $list->totalItems = count($filteredList);

        // Apply the pagination
        if ($itemsByPage != 0) {
            $currentPageItemStartIndex = $currentPage * $itemsByPage;
            $currentPageItemEndIndex = $currentPageItemStartIndex + $itemsByPage;

            foreach ($filteredList as $k => $v) {
                if ($k >= $currentPageItemStartIndex && $k < $currentPageItemEndIndex) {
                    array_push($list->list, $v);
                }
            }
        } else {
            $list->list = $filteredList;
        }

        // Get the total and current page
        $list->totalPages = $itemsByPage != 0 ? ceil($list->totalItems / $itemsByPage) : 1;
        $list->currentPage = $currentPage;

        // Return the list
        return $list;
    }


    /**
     * Generate a CSV of a set of objects. The properties bellow wont be considered: 'objectId', 'type', 'files', 'pictures', 'folderIds', 'privilegeId'
     *
     * @param VoSystemFilter $filter The filter to consider when getting the objects. It can be used using the following options:<br>
     *
     * <i>diskId:</i> Get only the objects of the specified disk<br>
     * <i>rootId:</i> Get only the objects that are from this root<br>
     * <i>folderId:</i> Get only the objects containing this folder <br>
     * <i>lanTag:</i> Get the object localized properties in this language<br>
     * <i>propertySearch:</i> Search a text on a property. It's not case sensitive and it won't consider the accents <br>
     * <i>propertyMatch:</i> Get only the objects that matches a property <br>
     * <i>propertyInner:</i> Get only the objects that have a property value between two values (min and max) <br>
     * <i>sortFields:</i> Set which property is used to sort the list <br>
     * <i>pageCurrent:</i> Set the current page when we are getting a paginated list <br>
     * <i>pageNumItems:</i> Set the number of objects by page when we are getting a paginated list <br>
     * <i>random:</i> Randomize the resulting list
     *
     * @param string $objectType The object type
     * @param array $csvColumns The csv columns. If not defined it will catch the objects ones
     * @param string $csvDelimiter The csv delimiter. ";" by default
     * @param string $csvEnclosure The csv enclosure. " by default
     *
     * @return string The generated CSV
     */
    public static function objectsGetCsv(VoSystemFilter $filter, $objectType, array $csvColumns = null, $csvDelimiter = ';', $csvEnclosure = '"')
    {
        $objects = self::objectsGet($filter, $objectType);

        // Generate default columns
        if ($csvColumns == null) {
            $csvColumns = self::objectsGetColumns($filter, $objectType);
        }

        // Generate the CSV
        return UtilsArray::arrayToCsv($csvColumns, $objects->list, $csvDelimiter, $csvEnclosure);
    }


    /**
     * @param VoSystemFilter $filter The filter to consider when getting the objects. It can be used using the following options:<br>
     *
     * <i>diskId:</i> Get only the objects of the specified disk<br>
     * <i>rootId:</i> Get only the objects that are from this root<br>
     * <i>folderId:</i> Get only the objects containing this folder <br>
     * <i>lanTag:</i> Get the object localized properties in this language<br>
     * <i>propertySearch:</i> Search a text on a property. It's not case sensitive and it won't consider the accents <br>
     * <i>propertyMatch:</i> Get only the objects that matches a property <br>
     * <i>propertyInner:</i> Get only the objects that have a property value between two values (min and max) <br>
     * <i>sortFields:</i> Set which property is used to sort the list <br>
     * <i>pageCurrent:</i> Set the current page when we are getting a paginated list <br>
     * <i>pageNumItems:</i> Set the number of objects by page when we are getting a paginated list <br>
     * <i>random:</i> Randomize the resulting list
     *
     * @param string $objectType The object type
     *
     * @return array An array containing each column
     */
    public static function objectsGetColumns(VoSystemFilter $filter, $objectType)
    {
        $columns = [];
        $objects = self::objectsGet($filter, $objectType);

        // Generate default columns
        foreach ($objects->list as $o) {
            $columns = array_unique(array_merge($columns, array_keys($o)));
        }

        // Remove the not necessary columns
        return array_values(array_diff($columns, ['type', 'files', 'pictures', 'folderIds', 'privilegeId']));
    }


    /**
     * Remove one or more objects from the database
     *
     * @param array $objectIds Array containing the list of object ids that will be removed
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function objectsRemove(array $objectIds, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Validate if there are objects
        if (count($objectIds) == 0) {
            return UtilsResult::generateSuccessResult('No objects to remove.');
        }

        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Generate the required sql query fragments
        $q = new VoSelectQuery();
        $q->select = 'o.objectId, o.privilegeId, ';
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'file') as files, ";
        $q->select .= "(SELECT IFNULL(GROUP_CONCAT(fi.fileId SEPARATOR ';'), '') FROM object_file of, file fi WHERE of.objectId = o.objectId AND fi.fileId = of.fileId AND fi.type = 'picture') as pictures";
        $q->from = 'object o';
        $q->where = 'o.type=' . UtilsString::sqlQuote($objectType) . ' AND ' . UtilsArray::sqlArrayToCondition($objectIds, 'o.objectId=');

        // Get all the objects that must be deleted
        $q->result = $connection->query($q->generateQuery());

        // Initialize transaction
        $connection->transactionStart();

        // Define an array to store linked file ids to be removed
        $filesToRemove = [];

        // Loop all the received objects and remove them if allowed
        while ($object = $connection->getNextRow($q->result)) {
            $q->where = 'objectId = ' . $object['objectId'];

            if ($object['privilegeId'] == WebConfigurationBase::$PRIVILEGE_WRITE_ID) {
                if (!$connection->query('DELETE FROM object WHERE ' . $q->where)) {
                    $connection->transactionRollback();
                    return UtilsResult::GenerateErrorResult('Error removing object ' . $objectType . ': ' . $object['objectId'] . '. ' . $connection->lastError);
                }
                // Push the pictures and files to remove
                if ($object['pictures'] != '') {
                    $filesToRemove = array_merge($filesToRemove, explode(';', $object['pictures']));
                }
                if ($object['files'] != '') {
                    $filesToRemove = array_merge($filesToRemove, explode(';', $object['files']));
                }
            } else {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Object ' . $objectType . ': ' . $object['objectId'] . ' remove is not allowed. ' . $connection->lastError, null, false);
            }
        }

        // Commit the transaction
        $connection->transactionCommit();

        // Remove the linked files and pictures
        $result = self::filesRemove($filesToRemove, $securityEnabled, $securityUserDiskId);

        if (!$result->state) {
            return UtilsResult::GenerateErrorResult('There was an error removing the linked files from the file system.');
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Object/s remove done.');
    }


    /**
     * Duplicate the specified objects to the destination folder. The associated files wont be processed
     *
     * @param array $objectIds The object ids to be duplicated
     * @param int $folderId The destination folder id
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function objectsDuplicate(array $objectIds, $folderId, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global secure server database connection
        Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folder exists
        if (!self::folderExists([$folderId], $objectType)) {
            return UtilsResult::generateErrorResult('Error duplicating the objects because the destination folder does not exist.');
        }

        // Loop for every requested object
        foreach ($objectIds as $id) {
            $objectData = self::objectGet($id, $objectType);

            if ($objectData != null) {

                // Reset the unnecessary data
                $objectData->objectId = '';
                $objectData->creationDate = '';
                $objectData->folderIds = $folderId;
                $objectData->pictures = '';
                $objectData->files = '';

                // The same for the literals
                foreach ($objectData->literals as $l) {
                    $l->objectLanId = '';
                }

                // Duplicate the object data
                $result = self::objectSet($objectData, $objectType, $securityEnabled, $securityUserDiskId);

                if (!$result->state) {
                    return UtilsResult::generateErrorResult('Error duplicating the object. ' . $result->description);
                }
            }
        }

        // Return the result
        return UtilsResult::generateSuccessResult('Object/s duplicate done.');
    }


    /**
     * Move one or more objects from a folder to another one
     *
     * @param array $objectIds Array containing the list of object ids that will be moved
     * @param int $folderIdFrom The folder from we are moving the objects
     * @param int $folderIdTo The folder id that the objects will be moved
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function objectsMove(array $objectIds, $folderIdFrom, $folderIdTo, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folder exists
        if (!self::folderExists([$folderIdFrom, $folderIdTo], $objectType)) {
            return UtilsResult::generateErrorResult('Error moving the objects to the folder because the source or destination one does not exist.');
        }

        // Initialize the transaction
        $connection->transactionStart();

        foreach ($objectIds as $id) {
            // Validate if the object exists
            if (!self::objectExists($id, $objectType)) {
                $connection->transactionRollback();
                return UtilsResult::generateErrorResult('Error moving the objects because the object ' . $id . ' not exists.', null, false);
            }
        }

        // Do the link
        if (!self::objectsLink($objectIds, $folderIdTo, $objectType, $securityEnabled, $securityUserDiskId)->state) {
            $connection->transactionRollback();
            return UtilsResult::generateErrorResult('Error moving the objects because of a problem when linking them to the folder.', null, false);
        }

        // Unlink the current one
        if (!self::objectsUnlink($objectIds, $folderIdFrom, $objectType, $securityEnabled, $securityUserDiskId)->state) {
            $connection->transactionRollback();
            return UtilsResult::generateErrorResult('Error moving the objects because of a problem when unlinking them to the folder.', null, false);
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Object/s move done.');
    }


    /**
     * Link objects to folders
     *
     * @param array $objectIds The object ids array
     * @param int $folderId The folder id to link
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult The result
     */
    public static function objectsLink(array $objectIds, $folderId, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folders exists
        if (!self::folderExists([$folderId], $objectType)) {
            return UtilsResult::generateErrorResult('Error linking the objects to the folder because not exists.');
        }

        // Initialize the transaction
        $connection->transactionStart();

        foreach ($objectIds as $oid) {
            // Validate if the object exists
            if (self::objectExists($oid, $objectType)) {
                // Verify if the objects already are linked to the specified folder
                if ($connection->count('SELECT objectId FROM object_folder WHERE objectId=' . UtilsString::sqlQuote($oid) . ' AND folderId=' . UtilsString::sqlQuote($folderId)) == 0) {
                    if (!$connection->insert('object_folder', ['objectId', 'folderId'], [[$oid, $folderId]])) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not link the object ' . $oid . ' to the folder ' . $folderId . '.' . $connection->lastError);
                    }
                }
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Objects linked.');
    }


    /**
     * Unlink users to folders
     *
     * @param array $objectIds Array containing all object ids to unlink
     * @param int $folderId The folder id to unlink
     * @param string $objectType The object type
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function objectsUnlink(array $objectIds, $folderId, $objectType, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folders exists
        if (!self::folderExists([$folderId], $objectType)) {
            return UtilsResult::generateErrorResult('Error unlinking the objects from the folder because the folder not exists.');
        }

        // Initialize the transaction
        $connection->transactionStart();

        foreach ($objectIds as $oid) {
            // Validate if the user exists
            if (self::objectExists($oid, $objectType)) {
                // Verify if the objects have more than i linked folder and remove them if only have one. Nothing to do if no folders linked
                $folderLinksCount = $connection->count('SELECT objectId FROM object_folder WHERE objectId=' . UtilsString::sqlQuote($oid));

                if ($folderLinksCount > 1) {
                    // Unlink the object from the folder
                    if (!$connection->delete('object_folder', 'objectId=' . UtilsString::sqlQuote($oid) . ' AND folderId=' . UtilsString::sqlQuote($folderId))) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not unlink the object ' . $oid . ' from the folder ' . $folderId . '.' . $connection->lastError);
                    }
                } else {
                    // Verify if the folder to unlink is really linked with the object
                    $folderLinkOk = $connection->count('SELECT objectId FROM object_folder WHERE objectId=' . UtilsString::sqlQuote($oid) . ' AND folderId=' . UtilsString::sqlQuote($folderId)) > 0;

                    if ($folderLinksCount == 1 && $folderLinkOk && !self::objectsRemove([$oid], $objectType, $securityEnabled, $securityUserDiskId)->state) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not unlink the object ' . $oid . ' from the folder ' . $folderId . ' because we cannot remove the source one.' . $connection->lastError);
                    }
                }
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Objects unlinked.');
    }


    /**
     * Get the db files used space in bytes
     *
     * @param $type string The file type
     *
     * @return int
     */
    public static function fileUsedSpaceGet($type = '')
    {
        // Get global server database connection
        $connection = Managers::mySQL();

        $q = new VoSelectQuery();
        $q->select = 'SUM(size) as used';
        $q->from = 'file';

        if (strtolower($type) != '') {
            $q->where = 'type = ' . UtilsString::sqlQuote($type);
        }

        // Get the file used space
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Return the used space
        return $q->result['used'] == '' ? 0 : intval($q->result['used']);
    }


    /**
     * Get the folder children as a list
     *
     * @param array $folders The folders array
     * @param int $parentFolderId The folder parent id
     *
     * @return array The current folders list
     */
    public static function foldersChildrenGet(array $folders, $parentFolderId)
    {
        $list = [];
        foreach ($folders as $folder) {
            if ($folder['parentFolderId'] == $parentFolderId) {
                $list = array_merge($list, self::foldersChildrenGet($folders, $folder['folderId']));
                array_push($list, $folder);
            }
        }
        return $list;
    }


    /**
     * Validate if the folders exists
     *
     * @param array $folderIds An array containing each folder ids
     * @param string $objectType The object folder type
     *
     * @return bool
     */
    public static function folderExists(array $folderIds, $objectType)
    {
        foreach ($folderIds as $id) {
            if (self::folderGet($id, $objectType) == null) {
                return false;
            }
        }
        return true;
    }


    /**
     * Generate the folders tree through its parentId
     *
     * @param array $folders The folders array
     * @param int $parentFolderId The folder parent id
     * @param int $level The folder tree level (PRIVATE!)
     *
     * @return array The folders tree
     */
    private static function _foldersTreeGenerate(array $folders, $parentFolderId, $_level = -1)
    {
        $list = [];
        $_level++;

        foreach ($folders as $folder) {
            if ($folder['parentFolderId'] == $parentFolderId) {
                $folder['child'] = self::_foldersTreeGenerate($folders, $folder['folderId'], $_level);
                $folder['level'] = $_level;
                array_push($list, $folder);
            }
        }
        return $list;
    }
}
 