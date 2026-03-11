<?php

namespace App\Exceptions;

use Exception;

class UserNotProjectMemberException extends Exception
{
    protected $message = "You are not assigned to this project.";
}
