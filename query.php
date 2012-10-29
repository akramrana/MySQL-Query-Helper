<?php

/**
 * Class name :: Query
 * Purpose :: helping the running mysql query smoothly,without writing raw mysql query
 * Author name :: AKRAM HOSSAIN 
 * Date :: 10-25-2012
 * End :: To Be Continue
 */
class query {

    public $select = array();
    public $where = array();
    public $query;
    public $num_rows;
    public $row_array = array();
    public $result_array = array();
    public $mysql_result = array();

    public function __construct() {
        
    }

    public function insert($tbl='', $val='') {
        $data = '';
        $column = '';
        if ($val == true) {
            foreach ($val as $key => $value) {
                $data .="'" . $value . "'" . ',';
                $column .=$key . ',';
            }
            $finalData = substr($data, 0, strlen($data) - 1);
            $finalColumn = substr($column, 0, strlen($column) - 1);
            $sql = 'insert into ' . $tbl . ' (' . $finalColumn . ') value (' . $finalData . ') ';
            $insert = $this->query_execute($sql);
            if ($insert == '1') {
                return true;
            } else {
                trigger_error(mysql_error(), E_USER_WARNING);
            }
        }
    }

    public function get($tblname='') {
        if (empty($this->select)) {
            $sql = 'SELECT * FROM ' . $tblname;
        } else {
            $select = '';
            foreach ($this->select as $key => $val) {
                $select.= $val . ",";
            }
            $costr = substr($select, 0, (strlen($select) - 1));
            $sql = ' SELECT ' . $costr . ' FROM ' . $tblname;
        }

        if (!empty($this->where)) {
            $condition = '';
            foreach ($this->where as $key => $val) {
                $condition.= $val . " AND ";
            }
            $costr = substr($condition, 0, (strlen($condition) - 4));
            $sql.= ' WHERE ' . $costr;
        }

        $fetchData = array();

        $this->mysql_result = $this->query_execute($sql);

        $result = $this->mysql_result;
        
        if (!$result) {
            trigger_error(mysql_error(), E_USER_WARNING);
        } else {
                    
            $fetchData = $this->fetchdata();

            return $fetchData;
        }
    }

    public function query_execute($query='') {
        $this->query = $query;
        return mysql_query($query);
    }

    public function count_result() {
        return mysql_num_rows($this->mysql_result);
    }
    
    public function runsql($query=''){
        $this->query = $query;
        $this->mysql_result = mysql_query($query);
        return $this->fetchdata();
    }

    public function fetchdata() {
        $data = array();
        while ($row = mysql_fetch_assoc($this->mysql_result)) {
            array_push($data, $row);
        }
        $this->result_array = $data;
        $this->row_array = $data['0'];
        $this->num_rows = mysql_num_rows($this->mysql_result);
 
        return $data;
    }
    
    public function select($param=array()) {
        return array_push($this->select, $param);
    }

    public function where($keys=array(), $values=array()) {
        return $this->where[] = $keys . "='" . $values . "'";
    }

    public function update($tblname='', $data='') {
        $sql = 'UPDATE ' . $tblname . '
                SET 
               ';
        $condition = '';
        foreach ($this->where as $key => $val) {
            $condition.= $val . " AND ";
        }
        $values = '';
        foreach ($data as $key => $value) {
            $values.=$key . "='" . $value . "',";
        }
        $covstr = substr($values, 0, (strlen($values) - 1));
        $sql.=$covstr . " ";
        $costr = substr($condition, 0, (strlen($condition) - 4));
        $sql.= 'WHERE ' . $costr;
        $update = $this->query_execute($sql);
        if ($update == '1') {
            return true;
        } else {
            trigger_error(mysql_error(), E_USER_WARNING);
        }
    }

    public function last_query() {
        return $this->query;
    }

    public function num_rows() {
        return $this->num_rows;
    }

    public function delete($tblname='') {
        $sql = 'DELETE FROM ' . $tblname . '
               ';
        $condition = '';
        foreach ($this->where as $key => $val) {
            $condition.= $val . " AND ";
        }
        $costr = substr($condition, 0, (strlen($condition) - 4));
        $sql.= 'WHERE ' . $costr;
        $delete = $this->query_execute($sql);
        if ($delete == '1') {
            return true;
        } else {
            trigger_error(mysql_error(), E_USER_WARNING);
        }
    }

    public function row_array() {
        return $this->row_array;
    }

    public function result_array() {
        return $this->result_array;
    }

}