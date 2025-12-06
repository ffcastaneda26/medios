<?php

namespace App\Filament\Resources\Sponsors\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AdvertisementsRelationManager extends RelationManager
{
    protected static string $relationship = 'advertisements';

    protected static ?string $title = 'Anuncios';

    protected static ?string $modelLabel = 'Anuncio';

    protected static ?string $pluralModelLabel = 'Anuncios';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(150)
                        ->columnSpanFull(),

                    DateTimePicker::make('start_date')
                        ->label('Fecha de Inicio')
                        ->required(),

                    DateTimePicker::make('end_date')
                        ->label('Fecha de Fin')
                        ->required()
                        ->after('start_date'),
                    TextInput::make('priority')
                        ->label('Prioridad')
                        ->numeric()
                        ->default(2)
                        ->minvalue(1)
                        ->helperText('Mayor número = mayor prioridad'),
                    Select::make('status')
                        ->label('Estado')
                        ->options([
                            'active' => 'Activo',
                            'inactive' => 'Inactivo',
                            'paused' => 'Pausado',
                        ])
                        ->default('active')
                        ->required(),

                ])->columns(2),
                Group::make()->schema([
                    Select::make('position')
                        ->label('Posición')
                        ->options([
                            'header' => 'Encabezado',
                            'footer' => 'Pie de página',
                            'sidebar_left' => 'Barra Lateral Izquierda',
                            'sidebar_right' => 'Barra Lateral Derecha',
                            'content_top' => 'Arriba del Contenido',
                            'content_bottom' => 'Abajo del Contenido',
                        ])
                        ->required(),
                    Select::make('ad_type')
                        ->label('Tipo de Anuncio')
                        ->options([
                            'banner' => 'Banner',
                            'sidebar' => 'Barra Lateral',
                            'popup' => 'Popup',
                            'native' => 'Nativo',
                        ])
                        ->required(),
                    TextInput::make('click_url')
                        ->label('URL de Destino')
                        ->url()
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    KeyValue::make('content')
                        ->label('Contenido (JSON)')
                        ->helperText('Configura el contenido del anuncio (imagen, texto, etc.)')
                        ->addActionLabel('Agregar campo')
                        ->columnSpanFull(),

                ])->columns(2),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ad_type')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'primary' => 'banner',
                        'success' => 'sidebar',
                        'warning' => 'popup',
                        'info' => 'native',
                    ]),

                Tables\Columns\TextColumn::make('position')
                    ->label('Posición')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                        'warning' => 'paused',
                    ]),

                Tables\Columns\TextColumn::make('impressions_count')
                    ->label('Impresiones')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Clics')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridad')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Inicio')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fin')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'active' => 'Activo',
                        'inactive' => 'Inactivo',
                        'paused' => 'Pausado',
                    ]),

                Tables\Filters\SelectFilter::make('ad_type')
                    ->label('Tipo')
                    ->options([
                        'banner' => 'Banner',
                        'sidebar' => 'Barra Lateral',
                        'popup' => 'Popup',
                        'native' => 'Nativo',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nuevo Anuncio'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('priority', 'desc');
    }
}
