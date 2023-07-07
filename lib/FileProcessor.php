<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

use WHMCS\Module\Server\SimpleWHMCSModule\Utils;
class FileProcessor extends AbstractFileProcessor {

    private const BASE_FILE = (__DIR__ . DIRECTORY_SEPARATOR . "base.txt");

    public array $records;

    public function __construct() {
        /* reads all records from base.txt to array */
        $this->records = $this->read(self::BASE_FILE);
    }

    public function appendRecord($id, string $name, string $lastname): void {
        /* when client id exists then dont append it again to array */
        if(Utils::isIdUnique($this->records, $id)){
            $this->records[] = ["id" => $id, "name" => $name, "lastname" => $lastname];

            $this->write(self::BASE_FILE, $this->records);
        }
    }

    public function removeRecord(string $id): void {
        /* removing item from array ($this->records) by reference */
        Utils::removeItemById($this->records, $id);

        $this->write(self::BASE_FILE, $this->records);
    }

}