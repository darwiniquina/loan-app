<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Client;
use App\Models\Loan;
use App\Models\LoanAmortization;

class LoanStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalClients = Client::count();
        $activeLoans = Loan::where('status', 'Active')->count();
        $totalLoanAmount = Loan::where('status', 'Active')->sum('principal_amount');
        $unpaidAmortizations = LoanAmortization::where('status', 'Unpaid')->sum('amount_due');

        return [
            Stat::make('Total Clients', $totalClients)
                ->description('Registered clients')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            
            Stat::make('Active Loans', $activeLoans)
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
            
            Stat::make('Total Loan Amount', '₱' . number_format($totalLoanAmount, 2))
                ->description('Active loans principal')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
            
            Stat::make('Pending Payments', '₱' . number_format($unpaidAmortizations, 2))
                ->description('Unpaid amortizations')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
        ];
    }
}
