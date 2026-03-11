<?php

namespace App\Exceptions;

use Exception;

class InvalidTaskDateException extends Exception
{
    protected $message = "Task due date can not be before the project's start_date."; 
}
