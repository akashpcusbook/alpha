<?php

namespace Tusker\Framework\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use Tusker\Framework\Exception\EmailException;

class Email
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host = env('MAIL_HOST', '');
        $this->mail->SMTPAuth = true;
        $this->mail->Username = env('MAIL_USERNAME', '');
        $this->mail->Password = env('MAIL_PASSWORD', '');
        $this->mail->SMTPSecure = 'tls' === env('MAIL_SECURE', '') ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = (int)env('MAIL_PORT', '465');
        $this->mail->XMailer = "Mail By Tusker ".app_version();
    }

    public function setXMailer(string $xmailer): self
    {
        $this->mail->XMailer = $xmailer;

        return $this;
    }

    public function setHeader(string $key, ?string $value = null): self
    {
        try {
            if (!$this->mail->addCustomHeader($key, $value)) {
                throw new EmailException('Unable to set Header');
            }
        } catch (\Exception $e) {
            throw new EmailException('Unable to set Header');
        }

        return $this;
    }

    public function setMessageId(string $messageId): self
    {
        $this->mail->MessageID = $messageId;

        return $this;
    }

    public function getMessageId(): string
    {
        return $this->mail->getLastMessageID();
    }

    public function send(mixed $email): self
    {
        try {
            $from = $email->getFrom();
            $this->mail->setFrom($from[0], $from[1]);

            foreach($email->getTo() as $to)
            {
                $this->mail->addAddress($to[0], $to[1]);
            }

            foreach($email->getReplyTo() as $replyTo)
            {
                $this->mail->addReplyTo($replyTo[0], $replyTo[1]);
            }

            foreach($email->getCc() as $cc)
            {
                $this->mail->addCC($cc[0], $cc[1]);
            }

            foreach($email->getBcc() as $bcc)
            {
                $this->mail->addBCC($bcc[0], $bcc[1]);
            }

            foreach($email->getAttachments() as $attachments)
            {
                $this->mail->addAttachment($attachments[0], $attachments[1], $attachments[2], $attachments[3]);
            }

            $this->mail->isHTML(true);

            $this->mail->Subject = $email->getSubject();
            $this->mail->Body    = $email->template();
            $this->mail->AltBody = $email->template();

            $this->mail->send();
        } catch (\Exception $e) {
            throw new EmailException($this->mail->ErrorInfo, 500);
        }

        return $this;
    }
}
