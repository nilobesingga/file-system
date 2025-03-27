<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardWidget extends Component
{
    public $totalFiles;
    public $amountInvested;
    public $currency;
    public $numberOfBonds;
    public $weeklyInvestments;
    public $weeklyBonds;
    public $labels;
    public $recentUploadsCount;
    public $newFiles;

    public function __construct(
        $amountInvested,
        $currency,
        $numberOfBonds,
        $totalFiles,
        $weeklyInvestments,
        $weeklyBonds,
        $labels,
        $recentUploadsCount,
        $newFiles
        ){
        $this->totalFiles = $totalFiles;
        $this->amountInvested = $amountInvested;
        $this->currency = $currency;
        $this->numberOfBonds = $numberOfBonds;
        $this->weeklyInvestments = $weeklyInvestments;
        $this->weeklyBonds = $weeklyBonds;
        $this->labels = $labels;
        $this->recentUploadsCount = $recentUploadsCount;
        $this->newFiles = $newFiles;
    }

    public function render()
    {
        return view('components.dashboard-widget');
    }
}
