<?php

namespace Neoan3\Core;

use Exception;
use Throwable;

class MockRouteException extends Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}