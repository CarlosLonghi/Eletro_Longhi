<?php

namespace App\Filament\Widgets;

use App\Enums\ServiceStatus;
use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestServices extends BaseWidget
{
    protected static ?string $heading = 'Serviços Recentes';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public ?string $statusFilter = null;

    public function table(Table $table): Table
    {
        $filter = request()->query('statusFilter');

        return $table
            ->query(
                ServiceResource::getEloquentQuery()
                    ->when($filter, fn ($q) => $q->where('status', $filter))
            )
            ->defaultPaginationPageOption(6)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_model')
                    ->label('Modelo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
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
                    ->default($filter)
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->record(fn (Service $record): Service => $record)
                    ->form(fn (Form $form): Form => ServiceResource::form($form))
            ]);
    }
}
