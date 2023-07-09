<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

class FileProcessor extends AbstractFileProcessor {

    private const BASE_FILE = (__DIR__ . DIRECTORY_SEPARATOR . "base.txt");

    public function appendRecord(string $id, string $name, string $lastname, string $status) : void {
        /* when client id exists then dont append it again to file */
        if($this->isRecordUnique(self::BASE_FILE, $id)){
            $record = json_encode(["id" => $id, "firstname" => $name, "lastname" => $lastname, "status" => $status]) . "\n";
            $this->write(self::BASE_FILE, $record);
        }
    }

    public function removeRecord(string $id): void {
        $this->removeById(self::BASE_FILE, $id);
    }

    public function updateRecord(string $id, string $status) : void {
        $this->updateStatusById(self::BASE_FILE, $id, $status);
    }
}