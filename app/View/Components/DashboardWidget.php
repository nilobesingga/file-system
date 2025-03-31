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

    public function __construct(
        $amountInvested,
        $currency,
        $numberOfBonds,
        $totalFiles,
        $monthlyBonds,
        $monthlyInvestments,
        $labels,
        $recentUploadsCount,
        $newFiles
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
    }

    public function render()
    {
        return view('components.dashboard-widget');
    }
}
