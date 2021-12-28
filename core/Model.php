<?php
abstract class Model extends Database
{
    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    abstract public function tableFill();
    abstract public function fieldFill();
    abstract public function primaryKey();
    
    public function all()
    {
        $tableName = $this->tableFill();
        $fieldSelect = $this->fieldFill();
        if (empty($fieldSelect)) {
            $fieldSelect = '*';
        }
        $sql = "SELECT $fieldSelect FROM $tableName";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function find($id)
    {
        $tableName = $this->tableFill();
        $fieldSelect = $this->fieldFill();
        $primaryKey = $this->primaryKey();
        if (empty($fieldSelect)) {
            $fieldSelect = '*';
        }
        $sql = "SELECT $fieldSelect FROM $tableName WHERE $primaryKey = $id";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function insertModel($data)
    {
        $tableName = $this->tableFill();
        if (!empty($data)) {
            $fieldStr = '';
            $valueStr = '';
            foreach ($data as $key=>$value) {
                $fieldStr.=$key.',';
                $valueStr.="'".$value."',";
            }
            $fieldStr = rtrim($fieldStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $tableName($fieldStr) VALUES ($valueStr)";

            $status = $this->db->query($sql);

            if ($status) {
                return true;
            }
        }

        return false;
    }
    public function updateModel($data, $id)
    {
        $tableName = $this->tableFill();
        $primaryKey = $this->primaryKey();
        if (!empty($data)) {
            $updateStr = [];
            foreach ($data as $key=>$value) {
                $updateStr[] = "`{$key}` = '{$value}'";
            }
            $dataUpdate = implode(',', $updateStr);

            if (!empty($id)) {
                $sql = "UPDATE $tableName SET $dataUpdate WHERE $primaryKey = $id";
            }

            $status = $this->db->query($sql);

            if ($status) {
                return true;
            }
        }

        return false;
    }
    public function deleteModel($id)
    {
        $tableName = $this->tableFill();
        $primaryKey = $this->primaryKey();
        if (!empty($id)) {
            $sql = "DELETE FROM $tableName WHERE $primaryKey = $id";
        } else {
            $sql = 'DELETE FROM '.$tableName;
        }

        $status = $this->db->query($sql);

        if ($status) {
            return true;
        }

        return false;
    }
}
