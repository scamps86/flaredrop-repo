<?php


/**
 * General user operation class
 */
class SystemUsers
{

    /**
     * Set or update an user on the database
     *
     * @param VoUser $userData The filled user object data to save
     * @param boolean $needValidation Define if the user email must be validated or not. (False by default)
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult The setting result. If it success, it will attach the user Entity
     */
    public static function set(VoUser $userData, $needValidation = false, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        if ($userData->userId != '') {
            // Verify that the user exists by its id
            if (!self::exists($userData->userId, '', $securityEnabled, $securityUserDiskId)) {
                return UtilsResult::GenerateErrorResult('Could not update user ' . $userData->userId . ' because not exists.', null, false);
            }
        } else {
            // Verify that the user exists by its name
            if (self::exists(-1, $userData->name, $securityEnabled, $securityUserDiskId)) {
                return UtilsResult::GenerateErrorResult('Could not create user because its name already exists on the database.', null, false);
            }
        }

        // Set default values if not defined
        if ($userData->privilegeId === '') {
            $userData->privilegeId = WebConfigurationBase::$PRIVILEGE_WRITE_ID;
        }

        // Set the user's creation date if not dfefined
        if ($userData->creationDate == '') {
            $userData->creationDate = UtilsDate::create();
        }

        // Encode the password to md5
        $updatePassword = true;

        if ($userData->password != '') {
            $userData->password = md5($userData->password);
        } else if ($userData->userId != '') {
            // Update password only if it's defined and  the user already exists
            $updatePassword = false;
        }

        // Start the transaction
        $connection->transactionStart();

        // Save or update the user on the database
        if (!$connection->insertUpdateFromClass($userData, 'userId', 'user', 'creationDate, privilegeId, name, ' . ($updatePassword ? 'password, ' : '') . 'email, data, firstName, middleName, lastName, location, city, region, country, cp, phone1, phone2')) {
            $connection->transactionRollback();
            return UtilsResult::GenerateErrorResult('Could not insert/update user. ' . $connection->lastError);
        }

        // Get the user's id if it's not an update
        if ($userData->userId == '') {
            $userData->userId = $connection->lastInsertIdGet();
        }

        // Link the user to the specified folder
        foreach (explode(';', $userData->folderIds) as $fid) {
            if (!self::link([$userData->userId], $fid, $securityEnabled, $securityUserDiskId)->state) {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('Could not insert/update user because of a folder link problem.' . $connection->lastError);
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Auto validate the user according the parameter
        if (!$needValidation) {
            self::validate(self::generateValidationKey($userData->userId, $securityEnabled, $securityUserDiskId), $securityEnabled, $securityUserDiskId);
        }

        // Return the result
        return UtilsResult::generateSuccessResult('User created.', $userData);
    }


    /**
     * Link users to folders
     *
     * @param array $userIds The user ids array
     * @param int $folderId The folder id to link
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult The result
     */
    public static function link(array $userIds, $folderId, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folders exists
        if (!SystemDisk::folderExists([$folderId], 'user')) {
            return UtilsResult::generateErrorResult('Error linking the users to the folder because not exists.');
        }

        // Initialize the transaction
        $connection->transactionStart();

        foreach ($userIds as $uid) {
            // Validate if the user exists
            if (self::exists($uid, '', $securityEnabled, $securityUserDiskId)) {
                // Verify if the users already are linked to the specified folder
                if ($connection->count('SELECT userId FROM user_folder WHERE userId=' . UtilsString::sqlQuote($uid) . ' AND folderId=' . UtilsString::sqlQuote($folderId)) == 0) {
                    if (!$connection->insert('user_folder', ['userId', 'folderId'], [[$uid, $folderId]])) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not link the user ' . $uid . ' to the folder ' . $folderId . '.' . $connection->lastError);
                    }
                }
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Users linked.');
    }


    /**
     * Unlink users to folders
     *
     * @param array $userIds Array containing all user ids to unlink
     * @param int $folderId The folder id to unlink
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function unlink(array $userIds, $folderId, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the destination folders exists
        if (!SystemDisk::folderExists([$folderId], 'user')) {
            return UtilsResult::generateErrorResult('Error unlinking the users from the folder because the folder not exists.');
        }

        // Initialize the transaction
        $connection->transactionStart();

        foreach ($userIds as $uid) {
            // Validate if the user exists
            if (self::exists($uid, '', $securityEnabled, $securityUserDiskId)) {
                // Verify if the users have more than i linked folder and remove them if only have one. Nothing to do if no folders linked
                $folderLinksCount = $connection->count('SELECT userId FROM user_folder WHERE userId=' . UtilsString::sqlQuote($uid));

                if ($folderLinksCount > 1) {
                    // Unlink the user from the folder
                    if (!$connection->delete('user_folder', 'userId=' . UtilsString::sqlQuote($uid) . ' AND folderId=' . UtilsString::sqlQuote($folderId))) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not unlink the user ' . $uid . ' from the folder ' . $folderId . '.' . $connection->lastError);
                    }
                } else {
                    // Verify if the folder to unlink is really linked with the user
                    $folderLinkOk = $connection->count('SELECT userId FROM user_folder WHERE userId=' . UtilsString::sqlQuote($uid) . ' AND folderId=' . UtilsString::sqlQuote($folderId)) > 0;

                    if ($folderLinksCount == 1 && $folderLinkOk && !self::remove([$uid], $securityEnabled, $securityUserDiskId)->state) {
                        $connection->transactionRollback();
                        return UtilsResult::GenerateErrorResult('Could not unlink the user ' . $uid . ' from the folder ' . $folderId . ' because we cannot remove the source one.' . $connection->lastError);
                    }
                }
            }
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('Users unlinked.');
    }


    /**
     * Get the user object from its validation key
     *
     * @param string $validationKey The validation key
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoUser    The user object
     */
    public static function getUserFromValidationKey($validationKey, $securityEnabled = true, $securityUserDiskId = 1)
    {
        if (strlen($validationKey) < 35) {
            return null;
        }

        $code = base64_decode(urldecode($validationKey));
        $i = strlen($code) - 33;

        $userId = substr($code, 1, $i) / 83064469;

        if (is_numeric($userId)) {
            if ($userId >= 0) {
                return self::get($userId, '', $securityEnabled, $securityUserDiskId);
            }
        }

        return null;
    }


    /**
     * Validate an user through its validation key.
     *
     * @param string $validationKey The user's validation key
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult    The result with the user object if the validation success
     */
    public static function validate($validationKey, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Extract the user id from the validation key
        $code = base64_decode(urldecode($validationKey));

        // Extract the user id from the validation key
        $userData = self::getUserFromValidationKey($validationKey, $securityEnabled, $securityUserDiskId);

        if ($userData == null) {

            return UtilsResult::generateErrorResult('User cannot be validated (error 1)', null, false);
        }

        // Validate initial character
        $chars = 'abcde';

        if ($chars[$userData->userId % 5] != $code[0]) {

            return UtilsResult::generateErrorResult('User cannot be validated (error 2)', null, false);
        }

        // Validate the key core
        if (substr($code, strlen($code) - 32) != md5(($userData->userId . $userData->creationDate))) {

            return UtilsResult::generateErrorResult('User cannot be validated (error 3)', null, false);
        }

        // This means than the validation key is valid. Now we have to validate the user
        $connection->update('user', ['validated' => 1], 'userId=' . $userData->userId);

        // Return the OK result
        return UtilsResult::generateSuccessResult('User successfully validated.', $userData);
    }


    /**
     * Verify if a user is validated
     *
     * @param int $userId The user id that we want to verify
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return boolean
     */
    public static function isValidated($userId, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Verify if the user exists
        if (!self::exists($userId, '', $securityEnabled, $securityUserDiskId)) {
            return false;
        }

        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Get the user validation date from database
        $q = new VoSelectQuery();
        $q->select = 'validated';
        $q->from = 'user';
        $q->where = 'userId=' . UtilsString::sqlQuote($userId);

        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Test if the user is currently validated
        return $q->result['validated'] != null;
    }


    /**
     * Generate a user validation key that will be used to validate an user. The validation key is generated using this structure in base64:<br>
     *
     * [a|b|c|d|e] + [userId * 83064469] + [md5(userId + creationDate)]
     *
     * @param int $userId The user id
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return string    The validation key
     */
    public static function generateValidationKey($userId, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get the user
        $userData = self::get($userId, '', $securityEnabled, $securityUserDiskId);

        // Define possible initial code char
        $chars = 'abcde';

        // ENCODE
        return urlencode(base64_encode($chars[$userId % 5] . ($userId * 83064469) . md5($userId . $userData->creationDate)));
    }


    /**
     * Verify if an user exists
     *
     * @param int $userId The user id to verify
     * @param string $name The user name to verify
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return boolean
     */
    public static function exists($userId = -1, $name = '', $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Count the query results
        $q = new VoSelectQuery();
        $q->select = 'userId';
        $q->from = 'user';
        $q->where = '';

        if ($userId != -1) {
            $q->where .= 'userId=' . UtilsString::sqlQuote($userId);
        }
        if ($userId != -1 && $name != '') {
            $q->where .= ' AND ';
        }
        if ($name != '') {
            $q->where .= 'name=' . UtilsString::sqlQuote($name);
        }

        return $connection->count($q->generateQuery()) > 0;
    }


    /**
     * Get the user object through the userId or the user name. If the user does not exist, it will return a NULL object
     *
     * @param int $userId The user id that we want to get
     * @param string $name The user name that we want to get
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoUser
     */
    public static function get($userId = '', $name = '', $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Define the query
        $q = new VoSelectQuery();
        $q->select = "u.userId, u.privilegeId, u.creationDate, u.name, u.email, GROUP_CONCAT(uf.folderId SEPARATOR ';') as folderIds, u.firstName, u.middleName, u.lastName, u.validated, u.city, u.cp, u.location, u.phone1, u.phone2, u.region, u.country, u.data";
        $q->from = 'user u, folder f, user_folder uf';

        if ($userId != '') {
            $q->where = 'u.userId = ' . UtilsString::sqlQuote($userId);
        } else if ($name != '') {
            $q->where = 'u.name = ' . UtilsString::sqlQuote($name);
        } else {
            return null;
        }

        $q->where .= ' AND uf.userId = u.userId AND f.objectType=' . UtilsString::sqlQuote('user');

        // Get the user main data
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Validate if the user exists
        if (!isset($q->result['userId'])) {
            return null;
        }

        // Return the user object
        return UtilsArray::arrayToClass($q->result, new VoUser());
    }


    /**
     * Get a list of users
     *
     * @param VoSystemFilter $filter The filter to consider when getting the users. It can be used using the following options:<br>
     *
     * <i>diskId:</i> Get only the users of the specified disk<br>
     * <i>rootId:</i> Get only this root users<br>
     * <i>folderIds:</i> Get only the users containing this folders <br>
     * <i>propertySearch:</i> Search a text on a property. It's not case sensitive and it won't consider the accents <br>
     * <i>propertyMatch:</i> Get only the users that matches a property <br>
     * <i>propertyInner:</i> Get only the users that have a property value between two values (min and max) <br>
     * <i>sortFields:</i> Set which property is used to sort the list <br>
     * <i>pageCurrent:</i> Set the current page when we are getting a paginated list <br>
     * <i>pageNumItems:</i> Set the number of users by page when we are getting a paginated list <br>
     * <i>random:</i> Randomize the resulting list
     *
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoList
     */
    public static function getList(VoSystemFilter $filter, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Validate the filter
        if (!$filter->validate()) {
            UtilsResult::generateErrorResult('User getList filter is not valid.');
            die();
        }

        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // DEFINE THE QUERY
        $q = new VoSelectQuery();
        $q->select = "u.userId, u.privilegeId, u.creationDate, u.name, u.email, u.validated, u.firstName, u.middleName, u.lastName, u.data, u.location, u.city, u.country, u.region, u.cp, u.phone1, u.phone2, (SELECT GROUP_CONCAT(folderId SEPARATOR ';') FROM user_folder WHERE userId = u.userId) as folderIds";
        $q->from = 'user u, folder f, user_folder uf';
        $q->where = 'u.userId = uf.userId AND uf.folderId = f.folderId AND f.objectType=' . UtilsString::sqlQuote('user');
        $q->groupBy = 'u.userId';

        // Filter variables
        $itemsByPage = 0;
        $currentPage = 0;
        $propertyInner = null;
        $filterOperationIndex = 0;

        // APPLY THE FILTER
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

            // Filter by folder id. The children are considered only if no folder defined
            if ($c[0] == 'folderId') {
                $fq = new VoSelectQuery();
                $fq->select = 'folderId, parentFolderId';
                $fq->from = 'folder';
                $fq->where = 'objectType=' . UtilsString::sqlQuote('user');
                $folderIds = UtilsArray::extractProperty(SystemDisk::foldersChildrenGet(Managers::mySQL(false)->queryToArray($fq->generateQuery()), $c[1]), 'folderId');
                array_push($folderIds, $c[1]);
                $q->where .= UtilsArray::sqlArrayToCondition($folderIds, 'f.folderId=');
            }

            // Filter by property search
            if ($c[0] == 'propertySearch') {
                $q->where .= 'u.' . $c[1][0] . ' LIKE ' . UtilsString::sqlQuote('%' . $c[1][1] . '%');
            }

            // Filter by property propertyMatch
            if ($c[0] == 'propertyMatch') {
                $q->where .= 'u.' . $c[1][0] . '=' . UtilsString::sqlQuote($c[1][1]);
            }

            // Filter by property propertyInner
            if ($c[0] == 'propertyInner') {
                $propertyInner = [];
                $propertyInner['property'] = $c[1][0];
                $propertyInner['from'] = $c[1][1];
                $propertyInner['to'] = $c[1][2];
                $propertyInner['type'] = $c[1][3];
            }

            // Sorting
            if ($c[0] == 'sortField' && $q->orderBy != 'RAND()') {
                $q->orderBy = 'u.' . $c[1][0] . ' ' . $c[1][1] . ', ';
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
            $q->orderBy .= 'u.creationDate DESC';
        }

        // Set limit if the pagination is enabled
        if ($itemsByPage != 0) {
            $q->limit = ($itemsByPage * $currentPage) . ', ' . $itemsByPage;
        }

        // Get the user list
        $list = new VoList();
        $usersList = $connection->queryToArray($q->generateQuery());

        foreach ($usersList as $u) {
            $propertyInnerDone = true;

            // Filter by property inner
            if ($propertyInner != null) {
                $propertyInnerDone = false;
                $valueProperty = isset($u[$propertyInner['property']]) ? strtolower($u[$propertyInner['property']]) : '';

                if ($propertyInner['type'] == 'DATE') {
                    $valueProperty = date($valueProperty);
                }
                if ($propertyInner['type'] == 'TEXT' || $propertyInner['type'] == 'NUMBER' || $propertyInner['type'] == 'DATE') {
                    $propertyInnerDone = $propertyInner['from'] < $valueProperty && $valueProperty < $propertyInner['to'];
                }
            }

            if ($propertyInnerDone) {
                array_push($list->list, $u);
            }
        }

        // Get the total items
        $list->totalItems = count($list->list);

        // Get the total and current page
        $list->totalPages = $itemsByPage != 0 ? ceil($list->totalItems / $itemsByPage) : 0;
        $list->currentPage = $currentPage;

        // Return the list
        return $list;
    }


    /**
     * Remove one or more users  from the database, if possible
     *
     * @param array $userIds Array containing the list of user ids that will be removed
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function remove(array $userIds, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Generate the required sql query fragments
        $q = new VoSelectQuery();
        $q->select = 'userId, privilegeId';
        $q->from = 'user';
        $q->where = UtilsArray::sqlArrayToCondition($userIds, 'userId=');

        // Get all the users that must be deleted
        $q->result = $connection->query($q->generateQuery());

        // Initialize transaction
        $connection->transactionStart();

        // Loop all the received users and remove them if allowed
        while ($line = $connection->getNextRow($q->result)) {
            $q->where = 'userId = ' . $line['userId'];

            if ($line['privilegeId'] == WebConfigurationBase::$PRIVILEGE_WRITE_ID) {
                if (!$connection->query('DELETE FROM ' . $q->from . ' WHERE ' . $q->where)) {
                    $connection->transactionRollback();
                    return UtilsResult::GenerateErrorResult('Error removing user ' . $line['userId'] . '. ' . $connection->lastError);
                }
            } else {
                $connection->transactionRollback();
                return UtilsResult::GenerateErrorResult('User ' . $line['userId'] . ' remove is not allowed. ' . $connection->lastError, null, false);
            }
        }

        // Commit the transaction
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('User/s remove done.');
    }


    /**
     * Move one or more users from a folder to another one
     *
     * @param array $userIds Array containing the list of user ids that will be moved
     * @param int $folderIdFrom The folder from we are moving the users
     * @param int $folderIdTo The folder id that the users will be moved
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return VoResult
     */
    public static function move(array $userIds, $folderIdFrom, $folderIdTo, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL($securityEnabled, $securityUserDiskId);

        // Validate if the source and destination folder exists
        if (!SystemDisk::folderExists([$folderIdFrom, $folderIdTo], 'user')) {
            return UtilsResult::generateErrorResult('Error moving the users to the folder ' . $folderIdTo . ' because it does not exist.');
        }

        // Validate if the user exists
        foreach ($userIds as $id) {
            if (!self::exists($id, '', $securityEnabled, $securityUserDiskId)) {
                $connection->transactionRollback();
                return UtilsResult::generateErrorResult('Error moving the users because the user ' . $id . ' not exists.', null, false);
            }
        }

        // Do the link
        if (!self::link($userIds, $folderIdTo, $securityEnabled, $securityUserDiskId)->state) {
            $connection->transactionRollback();
            return UtilsResult::generateErrorResult('Error moving the users because of a problem when linking them to the folder.', null, false);
        }

        // Unlink the current one
        if (!self::unlink($userIds, $folderIdFrom, $securityEnabled, $securityUserDiskId)->state) {
            $connection->transactionRollback();
            return UtilsResult::generateErrorResult('Error moving the users because of a problem when unlinking them to the folder.', null, false);
        }

        // Do the transaction commit
        $connection->transactionCommit();

        // Return the result
        return UtilsResult::generateSuccessResult('User/s move done.');
    }


    /**
     * Executes a user login. It will return all the user data on success. The login will fail if the user is not validated.
     *
     * IMPORTANT! We have to set the userName and password parameters only the first login time, so the session will be stored
     * in a php session variables and they will be used to future session logins.
     *
     * @param string $name The username for the login
     * @param string $password The password for the login (base 64 encoded)
     * @param int $diskId [1 by default] The id for the disk where we want to log in
     * @param int $sessionExpires [86400 by default (1 day)] The session expiration time in minutes
     *
     * @return VoResult The user object if the login is correct
     */
    public static function login($name = '', $password = '', $diskId = 1)
    {
        // Get global server database connection
        $connection = Managers::mySQL(false);

        // Start a session if it's not already started
        if (session_id() == '') {
            session_start();
        }

        // Encode the password to MD5
        $password = $password == '' ? '' : md5($password);

        // Try to find them on the current server session
        if (isset($_SESSION[$diskId . '_userId'])) {
            if ($name == '' && $password == '') {
                $name = $_SESSION[$diskId . '_name'];
                $password = $_SESSION[$diskId . '_password'];
            }
        } else {
            // Set the values to the PHP session array
            $_SESSION[$diskId . '_name'] = $name;
            $_SESSION[$diskId . '_password'] = $password;
        }

        // Define the SQL query
        $q = new VoSelectQuery();

        $q->select = "u.userId, u.validated";
        $q->from = 'user u, folder f, user_folder uf';
        $q->where = 'BINARY u.name = ' . UtilsString::sqlQuote($name) . ' AND u.password = ' . UtilsString::sqlQuote($password) . ' AND uf.userId = u.userId AND uf.folderId = f.folderId ';
        $q->where .= 'AND f.diskId = ' . UtilsString::sqlQuote($diskId) . ' AND f.objectType=' . UtilsString::sqlQuote('user');

        // Get the requested user from the database
        $q->result = $connection->getNextRow($connection->query($q->generateQuery()));

        // Empty result, userId, name or password not defined, or user not validated
        if ($name == '' || $password == '' || !isset($q->result['userId']) || $q->result['validated'] != 1) {
            self::logout($diskId);
            return UtilsResult::generateErrorResult('User login failed 2. ' . $connection->lastError, null, false);
        }

        // Set the user id to the PHP session array
        $_SESSION[$diskId . '_userId'] = $q->result['userId'];

        // Get the user object
        $userData = self::get($q->result['userId'], '', false, $diskId);

        // Return the OK result and the logged userId
        return UtilsResult::generateSuccessResult('User login OK.', $userData);
    }


    /**
     * Get the logged user. Null if no logged user found
     *
     * @param int $diskId The user disk id (1 by default)
     *
     * @return VoUser The user object
     */
    public static function getLogged($diskId = 1)
    {
        if (isset($_SESSION[$diskId . '_userId'])) {
            return self::get($_SESSION[$diskId . '_userId'], '', true, $diskId);
        }
        return null;
    }


    /**
     * Destroy an user session
     *
     * @param int $diskId the user disk id (1 by default)
     */
    public static function logout($diskId = 1)
    {
        // Start a session if it's not already started
        if (session_id() == '') {
            session_start();
        }

        // Unset session parameters and destroy it
        unset($_SESSION[$diskId . '_userId']);
        unset($_SESSION[$diskId . '_name']);
        unset($_SESSION[$diskId . '_password']);

        // If no another session found, unset session parameters and destroy it
        if (count($_SESSION) == 0) {
            session_unset();
            session_destroy();
        }
    }


    /**
     * Generate a random password
     *
     * @param int $length The password length. (minimum 6 characters)
     *
     * @return string The generated password
     */
    public static function passwordGenerate($length = 6)
    {
        $length = $length < 8 ? 8 : $length;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';

        // Sure that we insert a lower case letter, a upper case letter and a number
        $result .= $chars[rand(0, 25)];
        $result .= $chars[rand(26, 51)];
        $result .= $chars[rand(52, 61)];

        for ($i = 0; $i < $length - 3; $i++) {
            $result .= $chars[rand(0, 61)];
        }
        return $result;
    }


    /**
     * Reset an user password and send it to its email
     *
     * @param string $name The user login name
     * @param string $senderEmail The sender email address
     * @param string $userEmail The user email to validate
     * @param string $emailSubject The subject for the email
     * @param string $emailMessage The message for the email. {USER_NAME} and {USER_PASSWORD} strings will be replaced with the user's name and password respectively
     * @param boolean $securityEnabled The mysql security enabled (needs a logged user)
     * @param int $securityUserDiskId The security user disk id. 1 by default
     *
     * @return boolean If the email is correctly sent or not
     */
    public static function passwordReset($name, $userEmail, $senderEmail, $emailSubject, $emailMessage, $securityEnabled = true, $securityUserDiskId = 1)
    {
        // Get the user through the name
        $userData = self::get('', $name, $securityEnabled, $securityUserDiskId);

        // Return false if the email is not defined
        if ($userData == null || $userData->email == '' || $userData->email != $userEmail) {
            return false;
        }

        // Generate a random password
        $pwd = self::passwordGenerate();
        $userData->password = base64_encode($pwd);

        // Save the user
        $result = self::set($userData, false, $securityEnabled, $securityUserDiskId);

        if (!$result->state) {
            return false;
        }

        // Generate the email message
        $emailMessage = str_replace('{USER_NAME}', $name, $emailMessage);
        $emailMessage = str_replace('{USER_PASSWORD}', $pwd, $emailMessage);

        return Managers::mailing()->send($senderEmail, $userData->email, $emailSubject, $emailMessage);
    }
}