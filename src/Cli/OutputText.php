<?php

namespace Tusker\Framework\Cli;

class OutputText
{
    /**
     * foreground color list
     *
     * @var array<mixed, mixed>
     */
    private $foregroundColors = [];

    /**
     * Background color list
     *
     * @var array<mixed, mixed>
     */
    private $backgroundColors = [];

    public function __construct()
    {
      $this->foregroundColors['black'] = '0;30';
      $this->foregroundColors['dark_gray'] = '1;30';
      $this->foregroundColors['blue'] = '0;34';
      $this->foregroundColors['light_blue'] = '1;34';
      $this->foregroundColors['green'] = '0;32';
      $this->foregroundColors['light_green'] = '1;32';
      $this->foregroundColors['cyan'] = '0;36';
      $this->foregroundColors['light_cyan'] = '1;36';
      $this->foregroundColors['red'] = '0;31';
      $this->foregroundColors['light_red'] = '1;31';
      $this->foregroundColors['purple'] = '0;35';
      $this->foregroundColors['light_purple'] = '1;35';
      $this->foregroundColors['brown'] = '0;33';
      $this->foregroundColors['yellow'] = '1;33';
      $this->foregroundColors['light_gray'] = '0;37';
      $this->foregroundColors['white'] = '1;37';

      $this->backgroundColors['black'] = '40';
      $this->backgroundColors['red'] = '41';
      $this->backgroundColors['green'] = '42';
      $this->backgroundColors['yellow'] = '43';
      $this->backgroundColors['blue'] = '44';
      $this->backgroundColors['magenta'] = '45';
      $this->backgroundColors['cyan'] = '46';
      $this->backgroundColors['light_gray'] = '47';
    }

    /**
     * get colored string
     *
     * @param string $string
     * @param string $foregroundColors
     * @param string $backgroundColors
     * @return string
     */
    public function getColoredString(string $string, string $foregroundColors = '', string $backgroundColors = ''): string
    {
		$coloredString = "";

		if (isset($this->foregroundColors[$foregroundColors])) {
			$coloredString .= "\033[" . $this->foregroundColors[$foregroundColors] . "m";
		}

		if (isset($this->backgroundColors[$backgroundColors])) {
			$coloredString .= "\033[" . $this->backgroundColors[$backgroundColors] . "m";
		}

		$coloredString .=  $string . "\033[0m";

		return $coloredString;
	}

    /**
     * return array of foreground available colors
     *
     * @return array<mixed, mixed>
     */
    public function getForegroundColors(): array
    {
		return array_keys($this->foregroundColors);
	}

    /**
     * return array of background available colors
     *
     * @return array<mixed, mixed>
     */
    public function getBackgroundColors(): array
    {
		return array_keys($this->backgroundColors);
	}
}