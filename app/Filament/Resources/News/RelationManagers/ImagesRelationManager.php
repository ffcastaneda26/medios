<?php

namespace App\Filament\Resources\News\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Guardar');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Guardar y crear otro');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('caption')
                    ->label('Descripción'),

                FileUpload::make('image_path')
                    ->label('Imagen')
                    ->required()
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
                    ->directory('news')
                    ->visibility('public')
                    ->maxSize(51200) // 50MB (aumentado para videos)
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
                    ->helperText('Tamaño máximo: 50MB. Formatos: JPG, PNG, WebP, GIF, MP4, MOV, AVI, WebM, MKV'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Imágenes')
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public'),
                TextColumn::make('caption')
                    ->label('Descripción'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Agregar Imagen')
                    ->modalHeading('Creando Nueva Imagen a la Noticia')
                    ->createAnother(false),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editando Imagen'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
