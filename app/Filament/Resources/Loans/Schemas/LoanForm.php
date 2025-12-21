<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use App\Models\Client;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Basic Information')
                        ->schema([
                            Select::make('client_id')
                                ->label('Client')
                                ->relationship('client', 'full_name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('full_name')->required(),
                                    TextInput::make('contact_no')->required(),
                                    TextInput::make('email')->email(),
                                ])
                                ->columnSpanFull(),
                            TextInput::make('code')
                                ->label('Loan Code')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->placeholder('e.g., ED-1')
                                ->maxLength(255),
                            TextInput::make('name')
                                ->label('Loan Name')
                                ->required()
                                ->maxLength(255),
                            Select::make('issuer')
                                ->label('Issuer')
                                ->options([
                                    'Personal Loan' => 'Personal Loan',
                                    'Business Loan' => 'Business Loan',
                                    'Emergency Loan' => 'Emergency Loan',
                                ])
                                ->default('Personal Loan')
                                ->required(),
                            Select::make('loan_type')
                                ->label('Loan Type')
                                ->options([
                                    'DBL' => 'DBL',
                                    'Regular' => 'Regular',
                                    'Special' => 'Special',
                                ])
                                ->default('DBL')
                                ->required(),
                            TextInput::make('source')
                                ->label('Source')
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Description')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('guarantor_name')
                                ->label('Guarantor Name')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    
                    Step::make('Amounts & Terms')
                        ->schema([
                            TextInput::make('principal_amount')
                                ->label('Principal Amount (₱)')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->prefix('₱')
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('disbursement_amount', $state);
                                }),
                            TextInput::make('interest_rate_monthly')
                                ->label('Monthly Interest Rate (%)')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->suffix('%')
                                ->step(0.01),
                            TextInput::make('terms_months')
                                ->label('Terms (Months)')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->integer(),
                            DatePicker::make('start_date')
                                ->label('Start Date')
                                ->required()
                                ->default(now())
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $terms = $get('terms_months');
                                    if ($state && $terms) {
                                        $set('due_date', now()->parse($state)->addMonths($terms)->format('Y-m-d'));
                                    }
                                }),
                            DatePicker::make('due_date')
                                ->label('Due Date')
                                ->required(fn ($get) => $get('terms_months') && $get('start_date')),
                            TextInput::make('disbursement_amount')
                                ->label('Disbursement Amount (₱)')
                                ->numeric()
                                ->prefix('₱')
                                ->helperText('Usually equals principal amount'),
                            TextInput::make('additional_fees')
                                ->label('Additional Fees (₱)')
                                ->numeric()
                                ->default(0)
                                ->prefix('₱'),
                            TextInput::make('advance_payment')
                                ->label('Advance Payment (₱)')
                                ->numeric()
                                ->default(0)
                                ->prefix('₱'),
                            Textarea::make('feature_applied')
                                ->label('Features Applied')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    
                    Step::make('Review & Status')
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Draft' => 'Draft',
                                    'Active' => 'Active',
                                    'Paid' => 'Paid',
                                    'Cancelled' => 'Cancelled',
                                ])
                                ->default('Draft')
                                ->required(),
                            Toggle::make('is_complete')
                                ->label('Mark as Complete')
                                ->default(false),
                            Textarea::make('notes')
                                ->label('Notes')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ])
                ->columnSpanFull()
                ->skippable(),
            ]);
    }
}
