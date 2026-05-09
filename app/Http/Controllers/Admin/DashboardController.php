<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'officers' => User::where('role', 'officer')->count(),
            'admins'   => User::where('role', 'admin')->count(),
            'total'    => User::count(),
        ];

        $recentUsers = User::latest()->paginate(5);

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
