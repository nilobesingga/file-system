<?php

namespace App\View\Components;

use App\Models\InvestmentStatistic;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class InvestmentWidget extends Component
{
    /**
     * Create a new component instance.
     */
    public $investorCode;

    public function __construct($investorCode)
    {
        $this->investorCode = $investorCode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $is_publish = [1];
        if(Auth::user()->is_admin){
            $is_publish = [0,1];
        }
        $statistics = InvestmentStatistic::where('investor_code', $this->investorCode)
            ->whereIN('is_publish', $is_publish)
            ->orderBy('year')
            ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
            ->get();

        return view('components.investment-widget', [
            'statistics' => $statistics,
            'investorCode' => $this->investorCode,
        ]);
    }
}
