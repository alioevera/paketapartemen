<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'authUser' => [
                'user_nik' => auth()->user()?->user_nik,
                'user_name' => auth()->user()?->user_name,
                'role' => auth()->user()?->role,
            ],
        ]);
    }
}