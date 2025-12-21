<?php

namespace App\Filament\Resources\Loans\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoanAmortizationsRelationManager extends RelationManager
{
    protected static string $relationship = 'loanAmortizations';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('installment_no')
                    ->label('Installment #')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1),
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),
                TextInput::make('amount_due')
                    ->label('Amount Due (₱)')
                    ->required()
                    ->numeric()
                    ->prefix('₱'),
                TextInput::make('principal_component')
                    ->label('Principal Component (₱)')
                    ->numeric()
                    ->prefix('₱'),
                TextInput::make('interest_component')
                    ->label('Interest Component (₱)')
                    ->numeric()
                    ->prefix('₱'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Unpaid' => 'Unpaid',
                        'Paid' => 'Paid',
                    ])
                    ->default('Unpaid')
                    ->required(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('installment_no')
                    ->numeric(),
                TextEntry::make('due_date')
                    ->date(),
                TextEntry::make('amount_due')
                    ->numeric(),
                TextEntry::make('principal_component')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('interest_component')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('installment_no')
            ->columns([
                TextColumn::make('installment_no')
                    ->label('Installment #')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount_due')
                    ->label('Amount Due')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('principal_component')
                    ->label('Principal')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('interest_component')
                    ->label('Interest')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Unpaid' => 'warning',
                        'Paid' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('installment_no', 'asc');
    }
}
