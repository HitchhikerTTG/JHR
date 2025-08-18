<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class JSLogger extends BaseController
{
    public function logMessage(): ResponseInterface
    {
        // Wspieraj fetch() i klasyczne AJAX
        if ($this->request->getMethod() !== 'post') {
            return $this->failRequest('Invalid method');
        }

        // Pobierz dane JSON jako tablica asocjacyjna
        $input = $this->request->getJSON(true);
        if (!is_array($input)) {
            return $this->failRequest('Invalid JSON payload');
        }

        // Wymagane pole
        if (empty($input['message'])) {
            return $this->failRequest('Message is required');
        }

        // Walidacja i oczyszczanie
        $allowedLevels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];
        $logLevel = strtolower($input['level'] ?? 'debug');
        if (!in_array($logLevel, $allowedLevels)) {
            $logLevel = 'debug';
        }

        $message = $this->sanitize($input['message']);
        $url = filter_var($input['url'] ?? 'unknown', FILTER_SANITIZE_URL);
        $userAgent = $this->sanitize($input['userAgent'] ?? 'unknown');
        $timestamp = $input['timestamp'] ?? date('Y-m-d H:i:s');

        $logLine = sprintf(
            "[%s] [%s] %s | URL: %s | UA: %s\n",
            $timestamp,
            strtoupper($logLevel),
            $message,
            $url,
            $userAgent
        );

        // Zapisz do głównego logu CodeIgniter
        log_message($logLevel, '[JS-LOG] ' . $message . ' | URL: ' . $url . ' | UA: ' . $userAgent);
        
        // Opcjonalnie zapisz też do osobnego pliku w głównym katalogu logs
        $logFile = WRITEPATH . 'logs/javascript-' . date('Y-m-d') . '.log';
        file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

        // Można opcjonalnie też zapisać do logów CI4
        // log_message($logLevel, '[JS-LOG] ' . $message);

        return $this->response->setJSON(['status' => 'logged']);
    }

    private function sanitize(string $input): string
    {
        // Usuwa znaki mogące psuć logi (np. nowa linia, \r)
        return str_replace(["\r", "\n"], ['\\r', '\\n'], trim($input));
    }

    private function failRequest(string $msg): ResponseInterface
    {
        return $this->response
            ->setStatusCode(400)
            ->setJSON(['error' => $msg]);
    }

    private function failServer(string $msg): ResponseInterface
    {
        return $this->response
            ->setStatusCode(500)
            ->setJSON(['error' => $msg]);
    }
}