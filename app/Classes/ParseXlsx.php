<?php

namespace App\Classes;
use SimpleXLSX;
use App\Classes\Interfaces\ReadFileInterface;

class ParseXlsx implements ReadFileInterface
{
    const SOURCE_FILE = 'fields.xlsx';
    private $simpleXLSX;

    public function __construct(SimpleXLSX $simpleXLSX)
    {
        $this->simpleXLSX = $simpleXLSX;
    }

    public function readFileContent($file)
    {
        $file = public_path() . '\\' . $file;
        $except = ["xlsx", "xls"];
        $extensions = implode('|', $except);
        if (filesize($file) > 0) {
            if (preg_match('/^.*\.(' . $extensions . ')$/i', $file)) {
                if ($xlsx = $this->simpleXLSX->parse($file)) {
                    foreach ($xlsx->rows() as $key => $val) {
                        $arrHeaders['headers'][] = $val;
                        $arrRows[] = $val;
                    }
                    foreach ($arrHeaders['headers'][0] as $key => $val) {
                        if (preg_match('/Filter:/', $val)) {
                            $length = $key;
                            $values['rows'][] = substr(strstr($val, ":"), 1, strlen(strstr($val, ":")));
                        }
                    }
                    for ($i = 1; $i < ($length + 1); $i++) {
                        for ($j = 0; $j < $length; $j++) {
                            $rows[$values['rows'][$j]][] = !empty($arrRows[$i][$j]) ? $arrRows[$i][$j] : '--------- empty value ----------';
                        }
                    }
                    return $rows;

                } else {
                    echo $this->simpleXLSX->parseError();
                }
            } else {
                echo "File extension is bad.";
            }
        } else {
            echo "File not exist.";
        }
    }
}