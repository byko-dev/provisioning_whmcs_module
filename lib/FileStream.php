<?php

namespace WHMCS\Module\Server\SimpleWHMCSModule;
class FileStream {

    public static function stream_read(string $filename, $callback, string $mode = "r+") : void{
        try {
            $stream_reader = fopen($filename, $mode);
            if (!$stream_reader)
                throw new Exception("Problem with stream opening file...");

            $callback($stream_reader);

            //close file stream
            fclose($stream_reader);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public static function stream_update(string $filename, string $id, $callback) : void{

        self::stream_read($filename, function ($reader) use ($id, $callback){
            $content = "";
            while (($line = fgets($reader)) !== false) {
                if (json_decode($line, true)['id'] == $id) {

                    //callback returns update on record or "" and just remove line
                    $line = $callback($line);
                }
                $content .= $line;
            }

            //set file stream writing on start file
            fseek($reader, 0);

            fwrite($reader, $content);

            //optimize file size
            ftruncate($reader, ftell($reader));
        });

    }
}