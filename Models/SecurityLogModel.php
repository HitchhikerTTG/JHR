<?php
#i idę o zakład że to tu też się wykaszani
namespace App\Models;

use CodeIgniter\Model;

class SecurityLogModel extends Model
{
    protected $table = 'security_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ip_address', 'user_agent', 'action', 'email_hash', 'suspicious_score', 'blocked'];
    protected $useTimestamps = true;

    public function logAction($ipAddress, $userAgent, $action, $emailHash = null, $suspiciousScore = 0)
    {
        $this->save([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'action' => $action,
            'email_hash' => $emailHash,
            'suspicious_score' => $suspiciousScore,
            'blocked' => ($suspiciousScore >= 5)
        ]);
    }

    public function calculateSuspiciousScore($ipAddress, $userAgent, $email = null)
    {
        $score = 0;
        
        // Sprawdź częstotliwość akcji z tego IP
        $ipActions = $this->where('ip_address', $ipAddress)
                          ->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 hour')))
                          ->countAllResults();
        
        if ($ipActions > 10) $score += 2;
        if ($ipActions > 20) $score += 3;

        // Sprawdź User Agent
        if (empty($userAgent) || strlen($userAgent) < 10) {
            $score += 2;
        }

        // Sprawdź czy to bot
        $botPatterns = ['bot', 'crawler', 'spider', 'scraper'];
        foreach ($botPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                $score += 3;
                break;
            }
        }

        // Sprawdź email (jeśli podany)
        if ($email) {
            $emailHash = hash('ripemd160', $email);
            $emailActions = $this->where('email_hash', $emailHash)
                                 ->where('created_at >', date('Y-m-d H:i:s', strtotime('-24 hours')))
                                 ->countAllResults();
            
            if ($emailActions > 5) $score += 2;
            if ($emailActions > 10) $score += 3;
        }

        return $score;
    }

    public function isBlocked($ipAddress)
    {
        return $this->where('ip_address', $ipAddress)
                    ->where('blocked', 1)
                    ->where('created_at >', date('Y-m-d H:i:s', strtotime('-24 hours')))
                    ->countAllResults() > 0;
    }
}
