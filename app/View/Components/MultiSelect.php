<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MultiSelect extends Component
{
    public $name;
    public $id;
    public $selections;
    public $selected;
    public $placeholder;

    public function __construct($name, $id = null, $selections = [], $selected = [], $placeholder = 'Select options')
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->selections = $selections;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
    }

    public function render(): View
    {
        return view('components.multi-select');
    }
}
