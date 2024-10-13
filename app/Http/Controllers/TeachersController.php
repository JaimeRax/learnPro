<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeachersController extends Controller
{



    public function disableUser($id)
    {
        $user = User::find($id);
        $user->disable();
        return redirect('/teachers');
    }

    public function activeUser($id)
    {
        $user = User::find($id);
        $user->enable();
        return redirect('/teachers');
    }
}
