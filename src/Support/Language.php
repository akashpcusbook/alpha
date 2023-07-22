<?php

namespace Tusker\Framework\Support;

use Tusker\Framework\Exception\FileNotFoundException;

class Language
{
    private string $locale = 'en';

    private string $langPath = '';

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLangPath(): void
    {
        $this->langPath = app_path('lang/'. $this->locale . '/');
    }

    public function translate(string $key, string ...$values): string
    {
        $this->setLangPath();
        /**
         * @var array<mixed, mixed>|null $langData
         */
        $langData = $this->getLangFileData($this->langPath . $this->locale . '.php');

        if (null === $langData) {
            throw new FileNotFoundException('language File not found for locale '. $this->locale);
        }

        $keyArr = explode('.', $key);

        $text = array_key_exists($keyArr[0], $langData) ? $langData[$keyArr[0]] : '';

        if ('' === $text) {
            return '';
        }
        
        for ($i=1; $i < count($keyArr) ; $i++) { 
            $langKey = $keyArr[$i];

            if (array_key_exists($langKey, $text)) {
                $text = $text[$langKey];
                continue;
            }

            $text = '';
            break;
        }

        $text = is_string($text) ? $text : '';

        if (!empty($values) && !empty($text)) {
            foreach($values as $key => $value) {
                $text = str_replace('{'.($key + 1).'}', $value, $text);
            }
        }

        return $text;

    }

    /**
     * return language file data
     *
     * @param string $path
     * @return mixed
     */
    private function getLangFileData(string $path)
    {
        if (file_exists($path)) {
            return require_once($path);
        }

        return null;
    }
}
