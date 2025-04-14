<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AccountStatement extends Component
{
    public $statementData;

    public function __construct($statementData = [])
    {
        $this->statementData = $statementData;
    }

    public function render(): View
    {
        return view('components.account-statement');
    }
}
