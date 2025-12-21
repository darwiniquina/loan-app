<?php

namespace App\Filament\Resources\Loans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                TextColumn::make('interest_rate_monthly')
                    ->label('Rate (%)')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('terms_months')
                    ->label('Terms')
                    ->suffix(' mos')
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Active' => 'success',
                        'Paid' => 'info',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                IconColumn::make('is_complete')
                    ->label('Complete')
                    ->boolean(),
                TextColumn::make('loan_type')
                    ->label('Type')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('issuer')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('disbursement_amount')
                    ->label('Disbursement')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('additional_fees')
                    ->label('Fees')
                    ->money('PHP')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('advance_payment')
                    ->label('Advance')
                    ->money('PHP')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guarantor_name')
                    ->label('Guarantor')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('source')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
