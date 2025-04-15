<?php

class Database {
    private $db;

    public function __construct($path) {
        $this->db = new PDO("sqlite:" . $path);
    }

    public function Execute($sql) {
        return $this->db->exec($sql);
    }

    public function Fetch($sql) {
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($table, $data) {
        $keys = implode(", ", array_keys($data));
        $values = implode("', '", array_values($data));
        $this->Execute("INSERT INTO $table ($keys) VALUES ('$values')");
        return $this->db->lastInsertId();
    }

    public function Read($table, $id) {
        $result = $this->Fetch("SELECT * FROM $table WHERE id=$id");
        return $result ? $result[0] : null;
    }

    public function Update($table, $id, $data) {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key='$value', ";
        }
        $set = rtrim($set, ", ");
        return $this->Execute("UPDATE $table SET $set WHERE id=$id");
    }

    public function Delete($table, $id) {
        return $this->Execute("DELETE FROM $table WHERE id=$id");
    }

    public function Count($table) {
        $result = $this->Fetch("SELECT COUNT(*) as cnt FROM $table");
        return $result[0]['cnt'];
    }
}
