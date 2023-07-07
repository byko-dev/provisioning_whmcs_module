<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

class Utils
{
    public static function removeItemById(array &$array, $id) : void {
        $array = array_filter($array, function ($item) use ($id) {
            return $item['id'] != $id;
        });
    }

    public static function isFileExisted(string $filename) : void{
        if(!file_exists($filename))
            throw new \Exception("File $filename doesnt exists");
    }

    public static function isIdUnique(array $array, $newId) {
        foreach ($array as $subarray) {
            if ($subarray['id'] == $newId) {
                return false;
            }
        }
        return true;
    }

}