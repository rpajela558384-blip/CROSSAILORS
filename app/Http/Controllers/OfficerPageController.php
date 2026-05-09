<?php

namespace App\Http\Controllers;

use App\Models\OfficerProfile;

class OfficerPageController extends Controller
{
    public function index()
    {
        $officers = OfficerProfile::with('user')
            ->orderBy('display_order')
            ->orderBy('created_at')
            ->get();

        return view('officers', compact('officers'));
    }
}
