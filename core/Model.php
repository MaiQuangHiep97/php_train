<?php
abstract class Model extends Database
{
    protected $db;
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
}
