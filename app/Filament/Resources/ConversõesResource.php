<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversõesResource\Pages;
use App\Filament\Resources\ConversõesResource\RelationManagers;
use App\Models\Conversões;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConversõesResource extends Resource
{
    protected static ?string $model = Conversões::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

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
            'index' => Pages\ListConversões::route('/'),
            'create' => Pages\CreateConversões::route('/create'),
            'edit' => Pages\EditConversões::route('/{record}/edit'),
        ];
    }
}
