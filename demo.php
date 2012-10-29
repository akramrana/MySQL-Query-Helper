<?php

require_once 'query.php';

class demo {

    public function __construct() {
        $this->query = new query();
    }

    public function getUserInfo() {
        $query = $this->query->get('tbl_user_info');
        $result = $this->query->result_array();

        return $result;
    }

    public function insertUserdata() {
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['phone'] = $_POST['phone'];
        $data['address'] = $_POST['address'];
        $insert = $this->query->insert('tbl_user_info', $data);
        if ($insert) {
            return '1';
        }
    }

    public function delete($data='') {
        $this->query->where("id", $data['0']);
        $delete = $this->query->delete("tbl_user_info");
        //echo $this->query->last_query();
        if ($delete) {
            return '1';
        }
    }

    public function login() {

        $this->query->where("fullname", $_POST['username']);
        $this->query->where("password", base64_encode($_POST['password']));
        $query = $this->query->get('tbl_user');

        //echo $this->query->last_query();
        if ($this->query->num_rows() > '0') {
            $result = $this->query->row_array();
            return $result;
        } else {
            return '0';
        }
    }

    public function testUpdate() {
        $data['fullname'] = 'rana';
        $data['password'] = '123123';
        $this->query->where("id", "1");
        $this->query->where("fullname", "rana");
        $update = $this->query->update("tbl_user", $data);
        if ($update) {
            return '1';
        }
    }

    public function testSelect() {
        $this->query->select("username");
        $this->query->select("email");
        $this->query->where("id", "1");//you can use multiple where condition
        $query = $this->query->get('tbl_user_info');
        $result = $this->query->row_array();
        return $result;
    }

    public function testDelete() {
        $this->load->query->where("id", "1");
        $delete = $this->load->query->delete("tbl_user_info");
        if ($delete) {
            return '1';
        }
    }

    public function getProductInfo() {
        $sql = 'SELECT * FROM ' . configproducts::TABLE_POS_PRODUCT . '
                WHERE ' . configproducts::TABLE_POS_PRODUCT_ATT_PRODUCT_ID . ' = ' . $_POST['productId'] . '';
        $query = $this->load->query->runsql($sql);
        $result = $this->load->query->row_array();
        return $result;
    }

}

?>
