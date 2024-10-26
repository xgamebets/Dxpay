<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GerenciamentoResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Gereciamento;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;

class GerenciamentoResource extends Resource
{
    protected static ?string $model = Gereciamento::class;


    protected static ?string $modelLabel = "Gerenciamento de IP's";

    protected static ?string $navigationLabel = "Gerenciamento";
    protected static ?string $title = "Lista de Ip's";
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ip')
                    ->required(),
                Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Hidden::make('user_id')
                    ->default(1),

            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip')
                    ->label('Ip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data  de Ativação')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGerenciamentos::route('/'),
            'create' => Pages\CreateGerenciamento::route('/create'),
            'edit' => Pages\EditGerenciamento::route('/{record}/edit'),
        ];
    }
}
