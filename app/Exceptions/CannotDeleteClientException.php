<?php

namespace App\Exceptions;

use Exception;

class CannotDeleteClientException extends Exception
{
    protected $message = 'Cannot delete client that has active project';
}
