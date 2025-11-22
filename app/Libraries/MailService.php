<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;
use Config\Services;

class MailService
{
    protected Email $email;
    protected string $baseUrl;
    protected string $fromEmail;
    protected string $fromName;

    public function __construct()
    {
        $this->email     = Services::email();
        $this->baseUrl   = rtrim(config('App')->baseURL ?? base_url(), '/');
        $this->fromEmail = config('Email')->fromEmail ?: env('email.fromEmail');
        $this->fromName  = config('Email')->fromName ?: env('email.fromName');
    }

    public function sendVerificationMail(array $usuario): void
    {
        if (empty($usuario['correo']) || empty($usuario['token'])) {
            return;
        }

        $this->email->clear(true);

        if ($this->fromEmail) {
            $this->email->setFrom($this->fromEmail, $this->fromName ?: 'Aventones');
        }

        $verificationUrl = $this->baseUrl . '/verify?token=' . urlencode($usuario['token']);

        $this->email->setTo($usuario['correo'], $usuario['nombre'] ?? '');
        $this->email->setSubject('Verificacion de cuenta');
        $this->email->setMessage(
            "Para verificar su cuenta ingrese a este link:<br><br>" .
            "<a href=\"{$verificationUrl}\">{$verificationUrl}</a>"
        );

        if (!$this->email->send(false)) {
            log_message('error', 'Fallo envio de correo: ' . $this->email->printDebugger(['headers']));
        }
    }
}
