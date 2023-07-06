<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;

use WHMCS\Module\Server\SimpleWHMCSModule\Utils;
class FileProcessor extends AbstractFileProcessor {

    private const BASE_FILE = __DIR__ . "/base.txt";

    public array $records;

    public function __construct() {
        $this->records = $this->read(self::BASE_FILE);
    }

    public function appendRecord($id, string $name, string $lastname): void {
        $this->records[] = ["id" => $id, "name" => $name, "lastname" => $lastname];

        $this->write(self::BASE_FILE, $this->records);
    }

    public function removeRecord(string $id): void {
        Utils::removeItemById($this->records, $id);

        $this->write(self::BASE_FILE, $this->records);
    }

}