<?php

namespace Taggle;

interface Store {

    function getDocument($doc_id);
    
    function saveDocument($document);
    
    function batchSave(array $documents);
}