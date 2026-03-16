<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('users.index');
        }

        if ($user->isManager()) {
            return redirect()->route('projects.index');
        }

        return redirect()->route('projects.index');
    }
}
