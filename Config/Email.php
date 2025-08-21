<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail = '';
    public string $fromName = '';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = '';

    /**
     * SMTP Username
     */
    public string $SMTPUser = '';

    /**
     * SMTP Password
     */
    public string $SMTPPass = '';

    /**
     * SMTP Port
     */
    public int $SMTPPort = 587;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 60;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     * @var string '', 'tls' or 'ssl' (note: 'ssl' & 'tls' are identical)
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use "\r\n" to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use "\r\n" to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;

    public function __construct()
    {
        parent::__construct();

        // Konfiguracja dla Postmark SMTP
        $this->fromEmail = env('POSTMARK_FROM_EMAIL', 'okno@johari.pl');
        $this->fromName = env('POSTMARK_FROM_NAME', 'Okno Johari');
        
        $this->protocol = 'smtp';
        $this->SMTPHost = env('email.SMTPHost', 'smtp.postmarkapp.com');
        $this->SMTPPort = (int) env('email.SMTPPort', 587);
        $this->SMTPUser = env('POSTMARK_SERVER_TOKEN', '');
        $this->SMTPPass = env('POSTMARK_SERVER_TOKEN', '');
        $this->SMTPCrypto = env('email.SMTPCrypto', 'tls');
        $this->SMTPTimeout = (int) env('email.SMTPTimeout', 60);
        
        $this->mailType = 'html';
        $this->charset = 'UTF-8';
        $this->validate = true;
        $this->wordWrap = true;
        $this->wrapChars = 76;
        
        // Ważne dla Postmark - używaj standardowych nagłówków
        $this->CRLF = "\r\n";
        $this->newline = "\r\n";
    }
}
