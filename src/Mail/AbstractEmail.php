<?php

namespace Tusker\Framework\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use Tusker\Framework\Exception\FileNotFoundException;
use Tusker\Framework\Exception\InvalidInputException;

abstract class AbstractEmail
{
    /**
     * @var array<int, string> $from
     */
    protected array $from = [];

    /**
     * @var array<int, array<int, string>> $to
     */
    protected array $to = [];

    /**
     * @var array<int, array<int, string>> $cc
     */
    protected array $cc = [];

    /**
     * @var array<int, array<int, string>> $bcc
     */
    protected array $bcc = [];

    /**
     * @var array<int, array<int, string>> $replyTo
     */
    protected array $replyTo = [];

    /**
     * @var array<int, array<int, string>> $attachment
     */
    protected array $attachment = [];

    /**
     * @var string $subject
     */
    protected string $subject = '';

    public function setFrom(string $from, string $name = ''): void
    {
        if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid Email address', 403);
        }

        $this->from = [$from, $name];
    }

    /**
     * get from array
     *
     * @return array<int, string>
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    public function setTo(string $to, string $name = ''): void
    {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid Email address', 403);
        }

        array_push($this->to, [$to, $name]);
    }

    /**
     * get to array
     *
     * @return array<int, array<int, string>>
     */
    public function getTo(): array
    {
        return $this->to;
    }

    public function setCc(string $cc, string $name = ''): void
    {
        if (!filter_var($cc, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid Email address', 403);
        }

        array_push($this->cc, [$cc, $name]);
    }

    /**
     * get cc array
     *
     * @return array<int, array<int, string>>
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    public function setBcc(string $bcc, string $name = ''): void
    {
        if (!filter_var($bcc, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid Email address', 403);
        }

        array_push($this->bcc, [$bcc, $name]);
    }

    /**
     * get bcc array
     *
     * @return array<int, array<int, string>>
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function setReplyTo(string $replyTo, string $name = ''): void
    {
        if (!filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid Email address', 403);
        }

        array_push($this->replyTo, [$replyTo, $name]);
    }

    /**
     * get replayTo array
     *
     * @return array<int, array<int, string>>
     */
    public function getReplyTo(): array
    {
        return $this->replyTo;
    }

    /**
     * set attachment
     *
     * @param string $path path to the file
     * @param string $name (optional) name of the file
     * @param string $encoding (optional) file Encoding refer to PHPMailer class
     * @param string $mime (optional) MIME type, e.g. image/jpeg; determined automatically from $path if not specified
     * @return void
     */
    public function setAttachment(string $path, string $name = '', string $encoding = PHPMailer::ENCODING_BASE64, string $mime = '')
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException('File does not exists for given path '. $path, 403);
        }

        array_push($this->attachment, [$path, $name, $encoding, $mime]);
    }

    /**
     * get attachments array
     *
     * @return array<int, array<int, string>>
     */
    public function getAttachments(): array
    {
        return $this->attachment;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public abstract function template(): string;
}
