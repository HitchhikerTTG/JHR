<?php
namespace App\Controllers;

class Backup extends \CodeIgniter\Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get all tables
        $tables = $db->listTables();
        
        $output = '';
        
        // Loop through tables
        foreach ($tables as $table) {
            // Get create table syntax
            $query = $db->query("SHOW CREATE TABLE $table");
            $row = $query->getRow();
            $output .= "\n\n" . $row->{'Create Table'} . ";\n\n";
            
            // Get table data
            $query = $db->query("SELECT * FROM $table");
            foreach ($query->getResultArray() as $row) {
                $fields = '';
                $values = '';
                foreach ($row as $field => $value) {
                    $fields .= "`$field`,";
                    $values .= $db->escape($value) . ",";
                }
                $fields = rtrim($fields, ',');
                $values = rtrim($values, ',');
                $output .= "INSERT INTO $table ($fields) VALUES ($values);\n";
            }
        }
        
        // Set headers for download
        $response = service('response');
        $response->setHeader('Content-Type', 'application/octet-stream');
        $response->setHeader('Content-Disposition', 'attachment; filename="backup_' . date('Y-m-d_H-i-s') . '.sql"');
        
        return $output;
    }
}
