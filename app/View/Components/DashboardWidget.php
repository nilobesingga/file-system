<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardWidget extends Component
{
    public $totalFiles;
    public $amountInvested;
    public $currency;
    public $numberOfBonds;
    public $monthlyInvestments;
    public $monthlyBonds;
    public $labels;
    public $recentUploadsCount;
    public $newFiles;
    public $netPerformance;
    public $netYield;

    public function __construct(
        $amountInvested,
        $currency,
        $numberOfBonds,
        $totalFiles,
        $monthlyBonds,
        $monthlyInvestments,
        $labels,
        $recentUploadsCount,
        $newFiles,
        $netPerformance,
        $netYield
        ){
        $this->totalFiles = $totalFiles;
        $this->amountInvested = $amountInvested;
        $this->currency = $currency;
        $this->numberOfBonds = $numberOfBonds;
        $this->monthlyInvestments = $monthlyInvestments;
        $this->monthlyBonds = $monthlyBonds;
        $this->labels = $labels;
        $this->recentUploadsCount = $recentUploadsCount;
        $this->newFiles = $newFiles;
        $this->netPerformance = $netPerformance;
        $this->netYield = $netYield;
    }

    public function render()
    {
        return view('components.dashboard-widget');
    }
}
