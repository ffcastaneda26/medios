<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email(),
                    TextInput::make('phone')
                        ->label('Teléfono')
                        ->tel(),

                    DatePicker::make('contract_start')
                        ->label('Inicio del Contrato'),
                    DatePicker::make('contract_end')
                        ->label('Fin del Contrato'),
                ])->columns(2),
                Group::make()->schema([
                    TextInput::make('website')
                        ->label('Sitio Web')
                        ->url()
                        ->columnSpanFull(),

                    TextInput::make('contact_person')
                        ->label('Persona de Contacto'),
                    Toggle::make('active')
                        ->label('¿Activo?'),

                ])->columns(2),

                FileUpload::make('logo')
                    ->label('Logotipo')
                    ->image()
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'image/jpg',
                        'image/gif', // ✅ GIF agregado
                        'video/mp4', // ✅ Videos agregados
                        'video/quicktime', // MOV
                        'video/x-msvideo', // AVI
                        'video/webm', // WebM
                        'video/x-matroska', // MKV
                    ])
                    ->disk('public')
                    ->directory('sponsors')
                    ->visibility('public')
                    ->maxSize(5120) // 5MB
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $sanitizedName = Str::slug($originalName);
                        $extension = $file->getClientOriginalExtension();

                        return time().'_'.$sanitizedName.'.'.$extension;
                    })
                    ->deleteUploadedFileUsing(function ($file) {
                        if ($file && Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    })
                    ->columnSpanFull()
                    ->helperText('Tamaño máximo: 5MB. Formatos: JPG, PNG, WebP, GIF, MP4, MOV, AVI, WebM, MKV'),
            ]);
    }
}
