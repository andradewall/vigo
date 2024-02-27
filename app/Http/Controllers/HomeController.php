<?php

namespace App\Http\Controllers;

use App\Enums\RentStatus;
use App\Models\Rent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $endingToday = Rent::query()
            ->with('products')
            ->where('ending_date', now()->format('Y-m-d'))
            ->paginate(10);

        $inProgressRents = Rent::query()
            ->with('products')
            ->where('status', RentStatus::IN_PROGRESS->value)
            ->paginate(10);

        $startingToday = Rent::query()
            ->with('products')
            ->where('starting_date', now()->format('Y-m-d'))
            ->paginate(10);

        return view('home', compact('endingToday', 'inProgressRents', 'startingToday'));
    }
}
