<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\CarouselItem;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('officer.carousel.index');
    }
}
