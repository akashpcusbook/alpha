<?php

namespace Tusker\Framework\Cli;

class CommandOutput
{
    private const MIN_WIDTH = 40;
    private const PROGRESS_WIDTH = 30;

    private int $totalCount = 0;

    public function __construct(private OutputText $outputText) {}

    /**
     * print text string in cli
     *
     * @param string $string
     * @return void
     */
    public function text(string $string): void
    {
        echo $this->outputText->getColoredString($string, 'white');
    }

    /**
     * print green color text string in cli
     *
     * @param string $string
     * @return void
     */
    public function textSuccess(string $string): void
    {
        echo $this->outputText->getColoredString($string, 'green');
    }

    /**
     * print red color text string in cli
     *
     * @param string $string
     * @return void
     */
    public function textError(string $string): void
    {
        echo $this->outputText->getColoredString($string, 'red');
    }

    /**
     * print yellow color text string in cli
     *
     * @param string $string
     * @return void
     */
    public function textWarning(string $string): void
    {
        echo $this->outputText->getColoredString($string, 'yellow');
    }

    /**
     * print blue color text string in cli
     *
     * @param string $string
     * @return void
     */
    public function textInfo(string $string): void
    {
        echo $this->outputText->getColoredString($string, 'blue');
    }

    /**
     * print newline for cli
     *
     * @return void
     */
    public function newLine(): void
    {
        echo PHP_EOL;
    }

    /**
     * print success text for cli
     *
     * @param string $string
     * @return void
     */
    public function success(string $string = 'success'): void
    {
        $outputStr = sprintf(' [Ok] %s ', $string);
        $outputLen = strlen($outputStr);
        $successStr = "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        $successStr .= "\r\n". $outputStr. str_repeat(' ', $outputLen < self::MIN_WIDTH ? (self::MIN_WIDTH - $outputLen) : 0) ;
        $successStr .= "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        echo $this->outputText->getColoredString($successStr, 'black', 'green');
        $this->newLine();
    }

    /**
     * print error text for cli
     *
     * @param string $string
     * @return void
     */
    public function error(string $string = 'error'): void
    {
        $outputStr = sprintf(' [Error] %s ', $string);
        $outputLen = strlen($outputStr);
        $successStr = "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        $successStr .= "\r\n". $outputStr. str_repeat(' ', $outputLen < self::MIN_WIDTH ? (self::MIN_WIDTH - $outputLen) : 0) ;
        $successStr .= "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        echo $this->outputText->getColoredString($successStr, 'black', 'red');
        $this->newLine();
    }

    /**
     * print warning text for cli
     *
     * @param string $string
     * @return void
     */
    public function warning(string $string = 'warning'): void
    {
        $outputStr = sprintf(' [Warning] %s ', $string);
        $outputLen = strlen($outputStr);
        $successStr = "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        $successStr .= "\r\n". $outputStr. str_repeat(' ', $outputLen < self::MIN_WIDTH ? (self::MIN_WIDTH - $outputLen) : 0) ;
        $successStr .= "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        echo $this->outputText->getColoredString($successStr, 'black', 'yellow');
        $this->newLine();
    }

    /**
     * print info string for cli
     *
     * @param string $string
     * @return void
     */
    public function info(string $string = 'Info'): void
    {
        $outputStr = sprintf(' [Info] %s ', $string);
        $outputLen = strlen($outputStr);
        $successStr = "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        $successStr .= "\r\n". $outputStr. str_repeat(' ', $outputLen < self::MIN_WIDTH ? (self::MIN_WIDTH - $outputLen) : 0) ;
        $successStr .= "\r\n".str_repeat(' ', $outputLen > self::MIN_WIDTH ? $outputLen : self::MIN_WIDTH);
        echo $this->outputText->getColoredString($successStr, 'black', 'blue');
        $this->newLine();
    }

    /**
     * used to start a progress bar
     *
     * @param integer $total
     * @return void
     */
    public function startProgress(int $total): void
    {
        $this->totalCount = $total;
        $this->newLine();
    }

    /**
     * used to start progressbar and updates the progressbar status
     *
     * @param integer $count
     * @param string $desc
     * @return void
     */
    public function progressCount(int $count, string $desc = ''): void
    {
        $perc = round(($count * 100) / $this->totalCount);
        $bar = round((self::PROGRESS_WIDTH * $perc) / 100);
        $info = $count."/".$this->totalCount;
        echo sprintf(" %s%% [%s%s] %s %s\r", $perc, str_repeat("▓", (int)$bar), str_repeat(" ", (int)(self::PROGRESS_WIDTH - $bar)), $info, $desc);
    }

    /**
     * stop the progress bar
     *
     * @return void
     */
    public function stopProgress(): void
    {
        $this->totalCount = 0;
        $this->newLine();
    }
}
