<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Loan;
use App\Models\LoanAmortization;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->isEmpty()) {
            $this->command->warn('No clients found. Please run ClientSeeder first.');
            return;
        }

        // Sample Loan 1
        $loan1 = Loan::create([
            'code' => 'ED-1',
            'name' => 'ED-1',
            'client_id' => $clients->first()->id,
            'status' => 'Active',
            'is_complete' => false,
            'start_date' => Carbon::parse('2025-01-01'),
            'due_date' => Carbon::parse('2025-04-01'),
            'issuer' => 'Personal Loan',
            'loan_type' => 'DBL',
            'principal_amount' => 10000.00,
            'interest_rate_monthly' => 7.0000,
            'disbursement_amount' => 10000.00,
            'terms_months' => 3,
            'additional_fees' => 0,
            'advance_payment' => 0,
            'description' => 'Emergency personal loan for medical expenses',
            'guarantor_name' => 'Jose Rizal',
        ]);

        // Generate amortization for Loan 1 (simple flat interest)
        $totalInterest = $loan1->principal_amount * ($loan1->interest_rate_monthly / 100) * $loan1->terms_months;
        $totalPayable = $loan1->principal_amount + $totalInterest;
        $monthlyPayment = $totalPayable / $loan1->terms_months;
        
        for ($i = 1; $i <= $loan1->terms_months; $i++) {
            LoanAmortization::create([
                'loan_id' => $loan1->id,
                'installment_no' => $i,
                'due_date' => Carbon::parse($loan1->start_date)->addMonths($i),
                'amount_due' => round($monthlyPayment, 2),
                'principal_component' => round($loan1->principal_amount / $loan1->terms_months, 2),
                'interest_component' => round($totalInterest / $loan1->terms_months, 2),
                'status' => 'Unpaid',
            ]);
        }

        // Sample Loan 2
        if ($clients->count() > 1) {
            $loan2 = Loan::create([
                'code' => 'BL-001',
                'name' => 'Business Expansion Loan',
                'client_id' => $clients->skip(1)->first()->id,
                'status' => 'Active',
                'is_complete' => false,
                'start_date' => Carbon::parse('2025-02-01'),
                'due_date' => Carbon::parse('2025-08-01'),
                'issuer' => 'Business Loan',
                'loan_type' => 'Regular',
                'principal_amount' => 50000.00,
                'interest_rate_monthly' => 5.0000,
                'disbursement_amount' => 48000.00,
                'terms_months' => 6,
                'additional_fees' => 2000.00,
                'advance_payment' => 0,
                'description' => 'Loan for business expansion and inventory',
            ]);

            $totalInterest2 = $loan2->principal_amount * ($loan2->interest_rate_monthly / 100) * $loan2->terms_months;
            $totalPayable2 = $loan2->principal_amount + $totalInterest2 + $loan2->additional_fees;
            $monthlyPayment2 = $totalPayable2 / $loan2->terms_months;
            
            for ($i = 1; $i <= $loan2->terms_months; $i++) {
                LoanAmortization::create([
                    'loan_id' => $loan2->id,
                    'installment_no' => $i,
                    'due_date' => Carbon::parse($loan2->start_date)->addMonths($i),
                    'amount_due' => round($monthlyPayment2, 2),
                    'principal_component' => round($loan2->principal_amount / $loan2->terms_months, 2),
                    'interest_component' => round($totalInterest2 / $loan2->terms_months, 2),
                    'status' => $i <= 2 ? 'Paid' : 'Unpaid',
                ]);
            }
        }

        // Sample Loan 3 - Draft
        if ($clients->count() > 2) {
            Loan::create([
                'code' => 'DL-002',
                'name' => 'Draft Loan Application',
                'client_id' => $clients->skip(2)->first()->id,
                'status' => 'Draft',
                'is_complete' => false,
                'start_date' => Carbon::now(),
                'due_date' => Carbon::now()->addMonths(12),
                'issuer' => 'Personal Loan',
                'loan_type' => 'Special',
                'principal_amount' => 25000.00,
                'interest_rate_monthly' => 6.0000,
                'disbursement_amount' => 25000.00,
                'terms_months' => 12,
                'additional_fees' => 500.00,
                'advance_payment' => 2500.00,
                'description' => 'Pending approval - home renovation loan',
            ]);
        }
    }
}
