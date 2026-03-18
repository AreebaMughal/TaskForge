<?php

namespace App\Exceptions;

use Exception;

class CannotAddTaskToArchiveProject extends Exception
{
    protected $message= "Cannot add tasks to an archived project.'";
}
