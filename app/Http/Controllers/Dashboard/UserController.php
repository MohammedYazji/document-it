<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        // or use !Gate::allow
        if (Gate::denies("users.view"))
        {
            abort(403);
        }
        echo "Admin Dashboard";
    }
}
