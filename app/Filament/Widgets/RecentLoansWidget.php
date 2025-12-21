<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Loan;

class RecentLoansWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()
                    ->latest()
                    ->limit(5)
            )
            ->heading('Recent Loans')
            ->columns([
                TextColumn::make('code')
                    ->label('Loan Code')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('client.full_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('principal_amount')
                    ->label('Principal')
                    ->money('PHP')
                    ->sortable(),
                
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Active' => 'success',
                        'Paid' => 'info',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
                
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->recordAction(null)
            ->recordUrl(fn (Loan $record): string => route('filament.admin.resources.loans.view', ['record' => $record]))
            ->paginated(false);
    }
}
