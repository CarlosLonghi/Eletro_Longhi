<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Service;
use App\Enums\ServiceStatus;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $modelLabel = 'Serviço';
    protected static ?string $pluralModelLabel = 'Serviços';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Serviço')->schema([
                    Forms\Components\TextInput::make('price')
                        ->label('Preço')
                        ->prefix('R$')
                        ->default(50)
                        ->numeric()
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(ServiceStatus::class)
                        ->default('awaiting_evaluation')
                        ->selectablePlaceholder(false)
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                ])->columns(['sm' => 2]),

                Section::make('Dados do Cliente')->schema([
                    Forms\Components\TextInput::make('customer_name')
                        ->label('Nome')
                        ->placeholder('Digite o nome')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('customer_phone')
                        ->label('Telefone')
                        ->placeholder('Digite o telefone')
                        ->tel()
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('customer_email')
                        ->label('Email (Opcional)')
                        ->placeholder('Digite o email')
                        ->email()
                        ->maxLength(255)
                        ->columnSpan(['sm' => 2, 'lg' => 1]),
                ])->columns(['sm' => 2, 'lg' => 3]),

                Section::make('Dados do Aparelho')->schema([
                    Forms\Components\Select::make('brand_id')
                        ->label('Marca')
                        ->placeholder('Selecione uma marca')
                        ->options(Brand::all()->pluck('name', 'id'))
                        ->required()
                        ->columnSpan(['sm' => 1, 'md' => 1]),
                    Forms\Components\TextInput::make('device_model')
                        ->label('Modelo')
                        ->placeholder('Digite o modelo')
                        ->maxLength(255)
                        ->required()
                        ->columnSpan(['sm' => 1, 'md' => 1]),
                    Forms\Components\Select::make('category_id')
                        ->label('Categoria')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->default(Category::first()->id)
                        ->selectablePlaceholder(false)
                        ->required()
                        ->columnSpan(['sm' => 1, 'md' => 1]),
                    Forms\Components\CheckboxList::make('device_accessories')
                        ->label('Acessórios do aparelho')
                        ->options([
                            'cable' => 'Cabo de Energia',
                            'control' => 'Controle',
                            'wall_support' => 'Suporte de Parede',
                            'shelf_support' => 'Suporte de Estante',
                            'others' => 'Outros (informe na descrição)',
                        ])
                        ->columnSpan(['sm' => 3, 'md' => 1]),
                    Forms\Components\Textarea::make('device_description')
                        ->label('Descrição (Opcional)')
                        ->placeholder('Informações adicionais sobre o aparelho ou acessórios...')
                        ->rows(4)
                        ->autosize()
                        ->maxLength(255)
                        ->columnSpan(['sm' => 3, 'md' => 1]),
                    Forms\Components\FileUpload::make('device_images')
                        ->label('Foto (Opcional)')
                        ->image()
                        ->multiple()
                        ->maxFiles(5)
                        ->openable()
                        ->optimize('webp')
                        ->resize(50)
                        ->columnSpan(['sm' => 3, 'md' => 1]),
                ])->columns(['sm' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_model')
                    ->label('Modelo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nome do cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Telefone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('price')
                    ->label('Valor')
                    ->money('BRL', true),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options(ServiceStatus::class)
                    ->selectablePlaceholder(false)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Iniciado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(ServiceStatus::class)
                    ->selectablePlaceholder(false),

                Tables\Filters\SelectFilter::make('category.name')
                    ->label('Categoria')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->relationship('category', 'name')
                    ->placeholder('Todas')
                    ->indicator('Categoria'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
