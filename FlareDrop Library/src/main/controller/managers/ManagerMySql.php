<?php

/**
 * MySQL manager
 */
class ManagerMySql
{
    /** Variable that contains the last error that happened on the database (if any). Only works if the methods of this class are used to query and operate. */
    public $lastError = '';

    /** Array containing the queries history list */
    public $queryList = [];

    /** Variable that stores the MySQL connection id */
    private $_id = '';

    /** Count the transactions */
    private $_transactionCounter = 0;


    /**
     * Initialize the MySQL connection
     *
     * @return void
     */
    function __construct()
    {
        $this->_id = mysqli_connect(WebConfigurationBase::$MYSQL_HOST, WebConfigurationBase::$MYSQL_USER, WebConfigurationBase::$MYSQL_PASSWORD);

        // Verify the MySQL connection id
        if ($this->_id == '') {
            echo 'MySQL connection error 2';
            die();
        }

        // Try to get the current data base
        if (!mysqli_select_db($this->_id, WebConfigurationBase::$MYSQL_DATABASE)) {
            echo 'MySQL connection error 3';
            die();
        }

        // Force MYSQL and PHP to speak each other in unicode UTF8 format.
        mysqli_query($this->_id, "SET NAMES 'utf8'");
    }


    /**
     * Get the last insert id
     *
     * @return int The last insert id
     */
    public function lastInsertIdGet()
    {
        return mysqli_insert_id($this->_id);
    }


    /**
     * Get the result for the specified SQL query in php result format.
     *
     * @param string $query The SQL query to execute
     *
     * @return resource The result of the query. On error it will return false
     */
    public function query($query)
    {
        // Add the query to the history
        array_push($this->queryList, $query);

        // Do the query
        $result = mysqli_query($this->_id, $query);

        // Analize the query result
        if (!$result) {
            $this->lastError = mysqli_error($this->_id);
            UtilsResult::GenerateErrorResult('Could not execute the query. ' . $this->lastError);
        }

        return $result;
    }


    /**
     * Do an insertion to the database
     *
     * @param string $table Target table name
     * @param array $columns The table columns to insert
     * @param array $data Array containing arrays of data for each row
     *
     * @return resource The SQL query result
     **/
    public function insert($table, array $columns, array $data)
    {
        $query = 'INSERT INTO ' . $table . ' ';

        // Define the columns
        $query .= '(`' . implode('`,`', $columns) . '`) ';

        // Define the values
        $query .= 'VALUES ';

        foreach ($data as $values) {
            $vList = '';
            foreach ($values as $v) {
                $vList .= UtilsString::sqlQuote($v) . ',';
            }
            $query .= '(' . substr($vList, 0, -1) . '),';
        }

        // Return the insert query result
        return self::query(substr($query, 0, -1) . ';');
    }


    /**
     * Do a table update on the database
     *
     * @param string $table The target table name
     * @param array $values An associative array containing the column name as a key, and the value
     * @param string $condition The condition as an SQL code
     *
     * @return resource The SQL query result
     **/
    public function update($table, array $values, $condition = '')
    {
        $query = 'UPDATE ' . $table . ' SET ';
        if (is_string($values)) {
            $query .= $values;
        } else {
            foreach ($values as $k => $v) {
                $query .= '`' . $k . '` = ' . UtilsString::sqlQuote($v) . ',';
            }
            $query = substr($query, 0, -1);
        }
        if ($condition != '') {
            $query .= ' WHERE ' . $condition;
        }

        // Return the update query result
        return self::query($query . ';');
    }


    /**
     * Do a deletion on the database
     *
     * @param string $tableName The table name
     * @param string $condition SQL Condition
     *
     * @return resource The SQL query result
     **/
    public function delete($tableName, $condition = '')
    {
        $query = 'DELETE FROM ' . $tableName;
        if ($condition != '') {
            $query .= ' WHERE ' . $condition;
        }
        $query .= ';';

        // Return the delete query result
        return self::query($query);
    }


    /**
     * Do an insert / update from a class on the database
     *
     * @param mixed $class The object class
     * @param string $primaryKey The table primary key field
     * @param string $table Table name to do the update or insertion
     * @param string $propertiesFilter The properties filter
     *
     * @return resource The SQL query result
     */
    public function insertUpdateFromClass($class, $primaryKey, $table, $propertiesFilter = '')
    {
        $filter = explode(',', str_replace(' ', '', $propertiesFilter));
        $properties = get_object_vars($class);
        $primaryKeyValue = $class->{$primaryKey};
        $data = [];

        // Generate an array with the properties we want to use on the insert / update
        foreach ($properties as $k => $v) {
            if (count($filter) <= 0 || in_array($k, $filter)) {
                if (!is_array($class->{$k})) {
                    $data[$k] = is_callable($class->{$k}) ? $v . ' ' : $v;
                }
            }
        }

        if ($primaryKeyValue != '') {
            return self::update($table, $data, $primaryKey . ' = ' . $primaryKeyValue);
        } else {
            $columns = [];
            $values = [];

            foreach ($data as $k => $v) {
                array_push($columns, $k);
                array_push($values, $v);
            }
            return self::insert($table, $columns, [$values]);
        }
    }


    /**
     * Get the result for the specified SQL query in array format. If no results found, it will return an empty array
     *
     * @param string $query The SQL query to execute
     *
     * @return array The result of the query as a php array
     */
    public function queryToArray($query)
    {

        $array = [];

        $result = self::query($query);

        if (!$result) {
            return null;
        }

        while ($line = mysqli_fetch_assoc($result))
            array_push($array, $line);

        return $array;

    }


    /**
     * Gets the next line for a query result, in the form of an array.
     *
     * @param resource $result Previously generated result.
     *
     * @return array
     */
    public function getNextRow($result)
    {
        if (!$result) {
            return false;
        }
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }


    /**
     * Count the query resulting rows
     *
     * @param string $query The query to count
     *
     * @return integer The number of rows
     */
    public function count($query)
    {
        $result = self::query($query);

        if (!$result) {
            $this->lastError = mysqli_error($this->_id);
            return false;
        }

        return mysqli_num_rows($result);
    }


    /**
     * Start a database transaction
     *
     * @return void
     */
    public function transactionStart()
    {
        if ($this->_transactionCounter < 1) {
            self::query('START TRANSACTION');
        }
        $this->_transactionCounter++;
    }


    /**
     * Rollback a database transaction
     *
     * @return void
     */
    public function transactionRollback()
    {
        $this->_transactionCounter = 0;
        self::query('ROLLBACK');
    }


    /**
     * Commit a database transaction
     *
     * @return void
     */
    public function transactionCommit()
    {
        $this->_transactionCounter--;
        if ($this->_transactionCounter < 1) {
            self::query('COMMIT');
        }
    }


    /**
     * Get the last insert id
     *
     * @return int|string
     */
    public function getLastInsertId()
    {
        return mysqli_insert_id($this->_id);
    }
}