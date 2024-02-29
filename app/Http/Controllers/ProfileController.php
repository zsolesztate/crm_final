<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckUserPermission;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('EditProfile',[
            'user' => Auth::user(),
        ]);
    }

}
