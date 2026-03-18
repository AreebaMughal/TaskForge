<?php

namespace App\Exceptions;

use Exception;

class CannotAddlogToArchiveProject extends Exception
{
    protected $message = "Cannot add log time to an archived project.";
}
