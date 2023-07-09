<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

use WHMCS\Module\Server\SimpleWHMCSModule\FileStream;

abstract class AbstractFileProcessor {

    protected function write(string $filename, string $record) : void{
        FileStream::stream_read($filename, function($reader) use ($record) {
            fwrite($reader, $record);
        }, "a");
    }

    protected function removeById(string $filename, string $id) : void{
        FileStream::stream_update($filename, $id, function () {
            /* write a blank line to delete the record */
            return "";
        });
    }

    protected function updateStatusById(string $filename, string $id, string $status) : void{
        FileStream::stream_update($filename, $id, function ($line) use ($status){
            $data = json_decode($line, true);
            $data['status'] = $status;
            return json_encode($data) . "\n";
        });
    }

    protected function isRecordUnique(string $filename, string $id) : bool{
        $unique = true;
        FileStream::stream_read($filename, function ($reader) use ($id, &$unique){
            while (($line = fgets($reader)) !== false) {
                if (json_decode($line, true)['id'] == $id) {
                    $unique = false;
                }
            }
        });
        return $unique;
    }

    /* functions to implementation */
    public abstract function appendRecord(string $id, string $name, string $lastname, string $status) : void;

    public abstract function removeRecord(string $id) : void;

    public abstract function updateRecord(string $id, string $status) : void;
}