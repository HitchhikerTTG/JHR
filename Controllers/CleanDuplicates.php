
<?php

namespace App\Controllers;

class CleanDuplicates extends BaseController
{
    public function removeDuplicateWindows()
    {
        $db = \Config\Database::connect();
        
        // Znajdź duplikaty (okna z tym samym hashem)
        $query = $db->query("
            SELECT hash, COUNT(*) as count, MIN(id) as keep_id 
            FROM okna 
            GROUP BY hash 
            HAVING COUNT(*) > 1
        ");
        
        $duplicates = $query->getResultArray();
        $removed = 0;
        
        foreach ($duplicates as $duplicate) {
            $hash = $duplicate['hash'];
            $keepId = $duplicate['keep_id'];
            
            // Usuń wszystkie oprócz najstarszego (o najmniejszym ID)
            $deleteQuery = $db->query("
                DELETE FROM okna 
                WHERE hash = ? AND id > ?
            ", [$hash, $keepId]);
            
            $deletedRows = $db->affectedRows();
            $removed += $deletedRows;
            
            log_message('info', "Usunięto {$deletedRows} duplikatów dla hash: {$hash}");
        }
        
        echo "Usunięto łącznie {$removed} duplikatów okien.<br>";
        echo "Zostały tylko najstarsze wersje każdego okna.";
    }
}
