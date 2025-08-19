<?php
#serio, to wygląda na jakieś małe upośledzenie
namespace App\Models;

use CodeIgniter\Model;

class RateLimitModel extends Model
{
    protected $table = 'rate_limits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ip_address', 'action_type', 'attempt_count', 'last_attempt', 'blocked_until'];
    protected $useTimestamps = true;

    public function checkRateLimit($ipAddress, $actionType, $maxAttempts = 5, $timeWindow = 3600)
    {
        $this->cleanExpiredBlocks();
        
        $existing = $this->where('ip_address', $ipAddress)
                         ->where('action_type', $actionType)
                         ->first();

        if (!$existing) {
            // Pierwszy raz - utwórz rekord
            $this->save([
                'ip_address' => $ipAddress,
                'action_type' => $actionType,
                'attempt_count' => 1,
                'last_attempt' => date('Y-m-d H:i:s')
            ]);
            return true;
        }

        // Sprawdź czy jest zablokowany
        if ($existing['blocked_until'] && strtotime($existing['blocked_until']) > time()) {
            return false;
        }

        // Sprawdź czy ostatnia próba była w oknie czasowym
        $lastAttempt = strtotime($existing['last_attempt']);
        $timeWindowStart = time() - $timeWindow;

        if ($lastAttempt < $timeWindowStart) {
            // Reset licznika - poza oknem czasowym
            $this->update($existing['id'], [
                'attempt_count' => 1,
                'last_attempt' => date('Y-m-d H:i:s'),
                'blocked_until' => null
            ]);
            return true;
        }

        // Zwiększ licznik
        $newCount = $existing['attempt_count'] + 1;
        $updateData = [
            'attempt_count' => $newCount,
            'last_attempt' => date('Y-m-d H:i:s')
        ];

        // Jeśli przekroczono limit, zablokuj
        if ($newCount >= $maxAttempts) {
            $updateData['blocked_until'] = date('Y-m-d H:i:s', time() + $timeWindow);
        }

        $this->update($existing['id'], $updateData);
        
        return $newCount < $maxAttempts;
    }

    public function getRemainingTime($ipAddress, $actionType)
    {
        $existing = $this->where('ip_address', $ipAddress)
                         ->where('action_type', $actionType)
                         ->first();

        if (!$existing || !$existing['blocked_until']) {
            return 0;
        }

        $blockedUntil = strtotime($existing['blocked_until']);
        $now = time();
        
        return max(0, $blockedUntil - $now);
    }

    private function cleanExpiredBlocks()
    {
        $this->where('blocked_until <', date('Y-m-d H:i:s'))
             ->where('blocked_until IS NOT NULL')
             ->set(['blocked_until' => null])
             ->update();
    }
}
