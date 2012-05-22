<?php

namespace Taggle\PHPUnit\Result;

use Taggle\Store;

class Processor implements \Taggle\Document\Processor {

    private $store;

    function __construct(Store $store) {
        $this->store = $store;
    }

    function process($filename, $ref_id=null) {
        $documents = array();
        $contents = file_get_contents($filename);
        $json = '[' . str_replace('}{', '},{', $contents) .']';
        $messages = json_decode($json);
        foreach ($messages as $message) {
            $message->taggle_type = 'phpunit_result';
            $message->ref_id = $ref_id;
            $documents[] = $message;
        }
        return $this->store->batchSave($documents);
    }
}