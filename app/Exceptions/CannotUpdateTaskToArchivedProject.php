<?php

namespace App\Exceptions;

use Exception;

class CannotUpdateTaskToArchivedProject extends Exception
{
    protected $message = 'Cannot update task for an archived project';
}
