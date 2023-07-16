<?php

namespace Tusker\Framework\Parser;

class Xml
{
    private string $xmlStr = '';

    /**
     * constructor
     *
     * @param array<mixed, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->xmlStr = $this->arrayToXml($data); 
    }

    public function getXml(): string
    {
        $xmlStr = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';
        $xmlStr .= '<response>';
        $xmlStr .= $this->xmlStr;
        $xmlStr .= '</response>';

        return $xmlStr;
    }

    /**
     * converts array to xml
     *
     * @param array<mixed, mixed> $datas
     * @return string
     */
    private function arrayToXml(array $datas): string
    {
        $xmlStr = '';

        foreach ($datas as $dataKey => $dataValue) {

            $xmlStr .= '<' . $dataKey . '>';
    
            if (gettype($dataValue) === 'array') {
                $xmlStr .= $this->arrayToXml($dataValue);
            } else {
                $xmlStr .= $dataValue;
            }
    
            $xmlStr .= '</' . $dataKey . '>';
        }

        return $xmlStr;
    }
}
