<?php

namespace App\Exceptions;

use Exception;

class CannotArchiveProjectException extends Exception
{
    protected $message = "cannot archive the project that has incomplete task";
}
