<?php

namespace Tusker\Framework\Request;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class HttpRequest 
{
    public function __construct()
    {
        $requests = json_decode(file_get_contents('php://input'), true);
    
        if (!empty($requests)) {
            foreach ($requests as $key => $request) {
                $this->{$key} = htmlentities($request);
            }
        }
    
        if (!empty($_REQUEST)) {
            foreach ($_REQUEST as $key => $request) {
                $this->{$key} = htmlentities($request);
            }
        }
    }
}
