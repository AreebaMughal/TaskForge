<?php

namespace App\Exceptions;

use Exception;

class CannotUpdateTimelogToArchivedProject extends Exception
{
    protected $message = 'Cannot update timelog for an archived project';
}
