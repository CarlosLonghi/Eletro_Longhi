<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Device;
use App\Models\Service;
use App\ServiceStatus;
use Filament\Forms;
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
                Forms\Components\Select::make('device_id')
                    ->label('Dispositivo')
                    ->options(Device::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->prefix('R$')
                    ->default(50)
                    ->numeric()
                    ->required(),
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
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('device.name')
                    ->label('Dispositivo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('device.image')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('device.customer.name')
                    ->label('Cliente')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL', true)
                    ->sortable(),
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
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
