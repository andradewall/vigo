<?php

namespace App\Livewire;

use App\Models\Rent;
use Livewire\Component;

class RentNumber extends Component
{
    public ?string $number = '';

    public function mount(): void
    {
        $rents = Rent::select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        $complete = range(1, max($rents));
    }

    public function render()
    {
        return view('livewire.rent-number');
    }
}
