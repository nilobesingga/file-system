<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SortIcon extends Component
{
    public function __construct(
        public string $column
    ) {}

    public function render()
    {
        return view('components.sort-icon');
    }
}
