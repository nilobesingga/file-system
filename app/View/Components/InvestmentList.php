<?php

namespace App\View\Components;

use App\Models\InvestmentStatistic;
use App\Models\User;
use Illuminate\View\Component;

class InvestmentList extends Component
{
    public $investorCode;
    public $investorName;
    public $month;
    public $year;
    public $selectedInvestor;

    public function __construct($investorCode = null, $investorName = null, $month = array(), $year = null, $selectedInvestor = null)
    {
        $this->investorCode = request('investor_code', $investorCode);
        $this->investorName = request('investor_name', $investorName);
        $this->month = request('month', $month);
        $this->year = request('year', $year);
        $this->selectedInvestor = request('selected_investor', $selectedInvestor);
    }

    public function render()
    {
        // Build query
        $query = InvestmentStatistic::query()->with('user','statement');

        // Apply sorting
        $query->orderBy('investor_code')
              ->orderBy('year')
              ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')");

        // Apply filters
        if ($this->investorCode) {
            $query->where('investor_code', 'like', "%{$this->investorCode}%");
        }

        if ($this->investorName) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->investorName}%");
            });
        }

        if ($this->month) {
            $query->whereIN('month', $this->month);
        }

        if ($this->year) {
            $query->where('year', $this->year);
        }

        if ($this->selectedInvestor) {
            $query->whereHas('user', function ($q) {
                $q->where('name', $this->selectedInvestor);
            });
        }

        if (request('is_publish') !== null) {
            $query->where('is_publish', request('is_publish'));
        }

        // Paginate results (10 per page)
        $statistics = $query->paginate(15);

        // Append filter parameters to pagination links
        $statistics->appends(request()->only(['investor_code', 'investor_name', 'month', 'year', 'selected_investor']));

        // Fetch all users for the investor name dropdown (excluding admins)
        $investors = User::where('is_admin', 0)
            ->orderBy('name')
            ->get();
        $months = [];
        for($m = 1; $m <= 12; $m++){
            $month = date('F', mktime(0, 0, 0, $m, 1));
            $months[] = array('id' => $m, 'name' => $month);
        }
        return view('components.investment-list', [
            'statistics' => $statistics,
            'investorCode' => $this->investorCode,
            'investors' => $investors,
            'months' => $months
        ]);
    }
}
