<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserMultiSelect extends Component
{
    /**
     * Create a new component instance.
     */

    public $users;
    public $selected;

    public function __construct($selected = [])
    {
        $this->users = \App\Models\User::where('is_admin', 0)->get();
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-multi-select');
    }
}
