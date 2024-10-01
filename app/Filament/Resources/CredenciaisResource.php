<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CredenciaisResource\Pages;
use App\Filament\Resources\CredenciaisResource\RelationManagers;
use App\Models\Credenciais;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CredenciaisResource extends Resource
{
    protected static ?string $model = Credenciais::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCredenciais::route('/'),
            'create' => Pages\CreateCredenciais::route('/create'),
            'edit' => Pages\EditCredenciais::route('/{record}/edit'),
        ];
    }
}
