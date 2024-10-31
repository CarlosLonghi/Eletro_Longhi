<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Category;
use App\Models\Service;
use App\ServiceStatus;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Section::make('Dados do Cliente')->schema([
                    Forms\Components\TextInput::make('customer_name')
                        ->label('Nome')
                        ->required(),
                    Forms\Components\TextInput::make('customer_phone')
                        ->label('Telefone')
                        ->tel()
                        ->required(),
                    Forms\Components\TextInput::make('customer_email')
                        ->label('Email')
                        ->email()
                        ->columnSpan(['sm' => 2, 'lg' => 1]),
                ])->columns(['sm' => 2, 'lg' => 3]),

                Section::make('Dados do Aparelho')->schema([
                    Forms\Components\TextInput::make('device_name')
                        ->label('Nome')
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                    Forms\Components\Select::make('category_id')
                        ->label('Categoria')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->selectablePlaceholder(false)
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                    Forms\Components\Textarea::make('device_description')
                        ->label('Descrição')
                        ->rows(4)
                        ->autosize()
                        ->maxLength(255)
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                    Forms\Components\FileUpload::make('device_image')
                        ->label('Foto')
                        ->image()
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                ])->columns(['sm' => 2]),


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
                        ->options([
                            'awaiting_evaluation' => ServiceStatus::AwaitingEvaluation->label(),

                            'in_evaluation' =>
                            ServiceStatus::InEvaluation->label(),

                            'awaiting_approval' =>
                            ServiceStatus::AwaitingApproval->label(),

                            'approved' =>
                            ServiceStatus::Approved->label(),

                            'in_repair' =>
                            ServiceStatus::InRepair->label(),

                            'awaiting_parts' =>
                            ServiceStatus::AwaitingParts->label(),

                            'repair_completed' =>
                            ServiceStatus::RepairCompleted->label(),

                            'awaiting_payment' =>
                            ServiceStatus::AwaitingPayment->label(),

                            'payment_received' =>
                            ServiceStatus::PaymentReceived->label(),

                            'device_collected' =>
                            ServiceStatus::DeviceCollected->label(),
                        ])
                        ->default('awaiting_evaluation')
                        ->selectablePlaceholder(false)
                        ->required()
                        ->columnSpan(['sm' => 2, 'md' => 1]),
                ])->columns(['sm' => 2]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('device_image')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('device_name')
                    ->label('Dispositivo')
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
                    ->options([
                        'awaiting_evaluation' => ServiceStatus::AwaitingEvaluation->label(),

                        'in_evaluation' =>
                        ServiceStatus::InEvaluation->label(),

                        'awaiting_approval' =>
                        ServiceStatus::AwaitingApproval->label(),

                        'approved' =>
                        ServiceStatus::Approved->label(),

                        'in_repair' =>
                        ServiceStatus::InRepair->label(),

                        'awaiting_parts' =>
                        ServiceStatus::AwaitingParts->label(),

                        'repair_completed' =>
                        ServiceStatus::RepairCompleted->label(),

                        'awaiting_payment' =>
                        ServiceStatus::AwaitingPayment->label(),

                        'payment_received' =>
                        ServiceStatus::PaymentReceived->label(),

                        'device_collected' =>
                        ServiceStatus::DeviceCollected->label(),
                    ])
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
                    ->options([
                        'awaiting_evaluation' => ServiceStatus::AwaitingEvaluation->label(),

                        'in_evaluation' =>
                        ServiceStatus::InEvaluation->label(),

                        'awaiting_approval' =>
                        ServiceStatus::AwaitingApproval->label(),

                        'approved' =>
                        ServiceStatus::Approved->label(),

                        'in_repair' =>
                        ServiceStatus::InRepair->label(),

                        'awaiting_parts' =>
                        ServiceStatus::AwaitingParts->label(),

                        'repair_completed' =>
                        ServiceStatus::RepairCompleted->label(),

                        'awaiting_payment' =>
                        ServiceStatus::AwaitingPayment->label(),

                        'payment_received' =>
                        ServiceStatus::PaymentReceived->label(),

                        'device_collected' =>
                        ServiceStatus::DeviceCollected->label(),
                    ])
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
