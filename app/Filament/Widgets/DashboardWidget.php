<?php

namespace App\Filament\Widgets;

use App\Models\PixInModel;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidget extends StatsOverviewWidget
{

    /**
     * @return array|Stat[]
     */
    public function getColumns(): int
    {
        return 6;
    }
    protected function getCards(): array
    {
        $userId = auth()->user()->id;
    
        // Faturamento de hoje
        $depositsToday = PixInModel::where("user_id", $userId)
            ->whereDate('created_at', today()) // Filtra pela data de hoje
            ->sum("amount");
    
        // Faturamento mensal
        $depositsMonthly = PixInModel::where("user_id", $userId)
            ->whereMonth('created_at', now()->month) // Filtra pelo mês atual
            ->whereYear('created_at', now()->year) // Filtra pelo ano atual
            ->sum("amount");
    
        // Faturamento confirmado de hoje
        $depositsConfirmToday = PixInModel::where("user_id", $userId)
            ->whereDate('created_at', today())
            ->where("status", 1)
            ->sum("amount");
    
        // Faturamento confirmado mensal
        $depositsConfirmMonthly = PixInModel::where("user_id", $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where("status", 1)
            ->sum("amount");
    
        // Contagem de vendas confirmadas
        $depositsConfirmCount = PixInModel::where("user_id", $userId)
            ->where("status", 1)
            ->count('id');
    
        $user = User::find($userId);
    
        return [
            Stat::make('Faturamento hoje', "R$ " . number_format($depositsToday, 2, ',', '.'))
                ->icon(Asset('assets/chart.svg')),
            Stat::make('Faturamento Mensal', "R$ " . number_format($depositsMonthly, 2, ',', '.'))
                ->icon(Asset('assets/money.svg')),
            Stat::make('Vendas', "R$ " . number_format($depositsConfirmToday, 2, ',', '.'))
                ->icon(Asset('assets/chart.svg')),
            Stat::make('Conversão', $depositsConfirmCount)
                ->icon(Asset('assets/arrows.svg')),
            Stat::make('Saldo', "R$ " . number_format($user->balance, 2, ',', '.'))
                ->icon(Asset('assets/money.svg')),
        ];
    }

}
