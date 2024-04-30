<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class RentDuration extends Component
{
    public ?string $startingDate = '';

    public ?string $duration = '';

    public ?string $endingDate = '';

    public function mount(): void
    {
        $this->startingDate = now()->format('Y-m-d');
    }

    public function updatedDuration(): void
    {
        $this->endingDate = Carbon::make($this->startingDate)
            ->addDays($this->duration)
            ->format('Y-m-d');
    }

    public function render(): View
    {
        return view('livewire.rent-duration');
    }
}
