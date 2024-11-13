<?php

include "db.php";
class DynamicMigration {

    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function up($className) {
        $tableName = strtolower($className);
        $reflection = new ReflectionClass($className);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        

        foreach ($properties as $property) {
            $columnName = $property->getName();
            $columnType = $this->getColumnType($property);
            $columns[] = "{$columnName} {$columnType}";
        }

        $columns[] = "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $columns[] = "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        
        $columnsSql = implode(", ", $columns);
        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} ({$columnsSql})";

        try {
            $this->db->exec($sql);
            echo "{$tableName} table created successfully.\n";
        } catch (PDOException $e) {
            echo "Error creating table: " . $e->getMessage();
        }
    }

    public function down($className) {
        $tableName = strtolower($className);
        $sql = "DROP TABLE IF EXISTS {$tableName}";

        try {
            $this->db->exec($sql);
            echo "{$tableName} table dropped successfully.\n";
        } catch (PDOException $e) {
            echo "Error dropping table: " . $e->getMessage();
        }
    }

    private function getColumnType(ReflectionProperty $property) {
        $type = $property->getType();
        if (!$type) {
            return 'VARCHAR(255)';
        }
        $typeName = $type->getName();

        switch ($typeName) {
            case 'string':
                return 'VARCHAR(255)';
            case 'int':
                return 'INT';
            case 'bool':
                return 'TINYINT(1)';
            case 'float':
                return 'FLOAT';
            case 'DateTime':
                return 'DATETIME';
            default:
                return 'VARCHAR(255)';
        }
    }
}