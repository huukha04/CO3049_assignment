<?php
trait Model {
    use Database;

    public $message = [];
    protected $allowedColumns = [];
    protected $banned = [];
    protected $table = '';



    public function insert($data) {
        
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(", ", $keys) . ") values (:" . implode(", :", $keys) . ")";
        $result = $this->PDOquery($query, $data);
        if ($result) {
            return true;
        }
        return false;
    }

    public function update($id, $data, $id_column = 'id') {
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . ", ";
        }

        $query = trim($query, ", ");

        $query .= " WHERE $id_column = :$id_column ";

        $data[$id_column] = $id;
        $result = $this->PDOquery($query, $data);
        if ($result) {
            return true;
        }
        return false;
    }

    public function delete($id, $id_column = 'id') {
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

        $result = $this->PDOquery($query, $data);
        return $result !== false;
    }
    
    public function where($data = [], $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table";

        // Chỉ thêm WHERE nếu có điều kiện
        if (!empty($keys) || !empty($keys_not)) {
            $query .= " WHERE ";
        
            foreach ($keys as $key) {
                $query .= "$key = :$key AND ";
            }

            foreach ($keys_not as $key) {
                $query .= "$key != :$key AND ";
            }

            $query = rtrim($query, " AND "); // Xóa "AND" cuối nếu có
        }

        $data = array_merge($data, $data_not);

        return $this->PDOquery($query, $data);
    }

    public function all() {
        $query = "SELECT * FROM $this->table";
        return $this->PDOquery($query);
    }

}