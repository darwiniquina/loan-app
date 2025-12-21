<?php

namespace App\Filament\Resources\Loans\Schemas;

use App\Models\Loan;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LoanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('name'),
                IconEntry::make('is_complete')
                    ->boolean(),
                TextEntry::make('status'),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('due_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('guarantor_name')
                    ->placeholder('-'),
                TextEntry::make('issuer'),
                TextEntry::make('loan_type'),
                TextEntry::make('principal_amount')
                    ->numeric(),
                TextEntry::make('interest_rate_monthly')
                    ->numeric(),
                TextEntry::make('disbursement_amount')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('terms_months')
                    ->numeric(),
                TextEntry::make('additional_fees')
                    ->numeric(),
                TextEntry::make('advance_payment')
                    ->numeric(),
                TextEntry::make('feature_applied')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('source')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Loan $record): bool => $record->trashed()),
            ]);
    }
}
