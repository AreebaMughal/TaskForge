<?php

namespace App\Exceptions;

use Exception;

class CannotLogtimeToArchivedProject extends Exception
{
    protected $message = 'Cannot log time to an archived project.';
}
