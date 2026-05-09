<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CarouselItem;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $introCarousel   = CarouselItem::active()->where('type', 'intro')->get();
        $updatesCarousel = CarouselItem::active()->where('type', 'updates')->get();
        $projectsCarousel = CarouselItem::active()->where('type', 'projects')->get();
        $announcements   = Announcement::active()->limit(6)->get();

        return view('home', compact(
            'introCarousel',
            'updatesCarousel',
            'projectsCarousel',
            'announcements'
        ));
    }
}
