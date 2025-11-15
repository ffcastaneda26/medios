<?php

namespace App\Filament\Resources\News\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    TextInput::make('caption')
                        ->label('Descripción'),
                    TextInput::make('order')
                        ->label('Orden')
                        ->required()
                        ->numeric()
                        ->default(0),
                ]),
                Group::make()->schema([

                    FileUpload::make('image_path')
                        ->label('Imagen')
                        ->image()
                        ->imageEditor()
                        ->imageEditorViewportWidth('200')
                        ->imageEditorViewportHeight('200')
                        ->acceptedFileTypes(['image/*'])
                        ->disk('public')
                        ->directory('news')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $file->getClientOriginalExtension();

                            return time().'_'.$originalName.'.'.$extension;
                        }),

                ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen'),
                TextColumn::make('caption')
                    ->label('Descripción')
                    ->searchable(),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
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
