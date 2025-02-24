<?php
trait Model {
    use Database;

    public $message = [];
    protected $allowedColumns = [];
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
        $this->PDOquery($query, $data);
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

        // echo $query;
        $this->PDOquery($query, $data);
        return false;
    }

    public function delete($id, $id_column = 'id') {
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";
        $this->PDOquery($query, $data);

        return false;
    }
}