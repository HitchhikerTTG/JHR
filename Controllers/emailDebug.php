<?php namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class EmailEnvDebug extends BaseController
{
    public function show(): ResponseInterface
    {
        $mask = function (?string $s): string {
            if (!$s) return '(EMPTY)';
            $len = strlen($s);
            return substr($s, 0, 4) . '…' . substr($s, -4) . " (len:$len)";
        };

        // 1) Odczyt bezpośrednio z .env
        $env = [
            'email.SMTPHost'   => env('email.SMTPHost'),
            'email.SMTPPort'   => env('email.SMTPPort'),
            'email.SMTPCrypto' => env('email.SMTPCrypto'),
            'email.SMTPUser'   => $mask(env('email.SMTPUser')),
            'email.SMTPPass'   => $mask(env('email.SMTPPass')),
            'email.fromEmail'  => env('email.fromEmail'),
            'email.fromName'   => env('email.fromName'),
        ];

        // 2) To, co finalnie ma obiekt konfiguracyjny
        $cfg = new \Config\Email();
        $conf = [
            'SMTPHost'   => $cfg->SMTPHost ?? null,
            'SMTPPort'   => $cfg->SMTPPort ?? null,
            'SMTPCrypto' => $cfg->SMTPCrypto ?? null,
            'SMTPUser'   => $mask($cfg->SMTPUser ?? null),
            'SMTPPass'   => $mask($cfg->SMTPPass ?? null),
            'fromEmail'  => $cfg->fromEmail ?? null,
            'fromName'   => $cfg->fromName ?? null,
            'protocol'   => $cfg->protocol ?? null,
        ];

        return $this->response->setJSON([
            'env()'         => $env,
            'Config\\Email' => $conf,
        ]);
    }
}