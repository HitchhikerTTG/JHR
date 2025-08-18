
<?php

namespace App\Controllers;

class JSLogger extends BaseController
{
    public function logMessage()
    {
        // Sprawdź czy to żądanie AJAX/POST
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $input = $this->request->getJSON(true);
        
        if (!isset($input['message'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Message required']);
        }

        $logLevel = $input['level'] ?? 'debug';
        $timestamp = $input['timestamp'] ?? date('Y-m-d H:i:s');
        $url = $input['url'] ?? 'unknown';
        $userAgent = $input['userAgent'] ?? 'unknown';
        
        $logMessage = sprintf(
            "[JS-LOG] [%s] %s | URL: %s | UA: %s",
            strtoupper($logLevel),
            $input['message'],
            $url,
            $userAgent
        );
        
        // Zapisz do pliku logów CodeIgniter
        log_message($logLevel, $logMessage);
        
        // Dodatkowo zapisz do osobnego pliku JS logów
        $logDir = WRITEPATH . 'logs/';
        $logFile = $logDir . 'javascript-' . date('Y-m-d') . '.log';
        
        $logEntry = sprintf(
            "[%s] %s\n",
            $timestamp,
            $logMessage
        );
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        return $this->response->setJSON(['status' => 'logged']);
    }
}
