<?php

/** SQL select query */
class VoSelectQuery
{
    public $select = '';
    public $from = '';
    public $where = '';
    public $orderBy = '';
    public $groupBy = '';
    public $limit = '';
    public $result = null;


    /** Generate the string of this current query object
     *
     * @param boolean $selectDistinct Set if the select is distinct or not. Not by default
     *
     * @return string
     *
     **/
    public function generateQuery($selectDistinct = false)
    {
        $query = '';
        $query .= $this->select != '' ? ($selectDistinct ? 'SELECT DISTINCT ' . $this->select . ' ' : 'SELECT ' . $this->select . ' ') : '';
        $query .= $this->from != '' ? 'FROM ' . $this->from . ' ' : '';
        $query .= $this->where != '' ? 'WHERE ' . $this->where . ' ' : '';
        $query .= $this->groupBy != '' ? 'GROUP BY ' . $this->groupBy . ' ' : '';
        $query .= $this->orderBy != '' ? 'ORDER BY ' . $this->orderBy . ' ' : '';
        $query .= $this->limit != '' ? 'LIMIT ' . $this->limit . ' ' : '';
        return $query;
    }
}