<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_All extends Model
{
    public function resetIncrement(string $table, int $value, string $column = 'id'): bool
    {
        $sql = "ALTER TABLE $table AUTO_INCREMENT = $value";

        try {
            $this->db->query($sql);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error resetting auto-increment: ' . $e->getMessage());
            return false;
        }
    }
}
