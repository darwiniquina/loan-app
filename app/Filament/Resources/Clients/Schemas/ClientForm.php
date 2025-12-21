<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client Information')
                    ->schema([
                        TextInput::make('full_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name'),
                        TextInput::make('contact_no')
                            ->required()
                            ->tel()
                            ->maxLength(255)
                            ->label('Contact Number'),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Address'),
                        FileUpload::make('id_upload_path')
                            ->label('ID Upload')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                            ->maxSize(5120)
                            ->directory('client-ids')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
