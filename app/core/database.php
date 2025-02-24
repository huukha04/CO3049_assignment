<?php
trait Database {


    private function connect() {
        $string = DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME;
        try {
            $pdo = new PDO($string, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
            echo "Connection successful!";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function PDOquery($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);
        
        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }
        return false;
    }

    public function get_first($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result[0];
            }
        }
        return false;
    }
}