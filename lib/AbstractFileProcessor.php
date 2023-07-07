<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

use WHMCS\Module\Server\SimpleWHMCSModule\Utils;

abstract class AbstractFileProcessor {
    protected function read(string $filename) : array{
        try{
            Utils::isFileExisted($filename);

            $data = json_decode(file_get_contents($filename), true);

            if($data === null)
                throw new \Exception();

            return $data;
        }catch (\Exception $ex){
            return [];
        }
    }

    protected function write(string $filename, array $data) : void {
        file_put_contents($filename, json_encode($data));
    }

    public abstract function appendRecord(string $id, string $name, string $lastname) : void;

    public abstract function removeRecord(string $id) : void;
}