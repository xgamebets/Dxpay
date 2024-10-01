<?php

namespace App\Filament\Widgets;
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



        return [
            Stat::make('Faturamento hoje', "$800")
                ->icon(Asset('assets/chart.svg')),
            Stat::make('Faturamento Mensal', "$900")
                ->icon(Asset('assets/money.svg'))
            ,
            Stat::make('Vendas', "$1200")
            ->description('24% mais vendas')
            ,
            Stat::make('Usuarios', "800")
                ->icon(Asset('assets/user.svg'))
            ,
            Stat::make('Conversão', "600")
                ->icon(Asset('assets/arrows.svg'))
            ,
            Stat::make('Saldo', "$5000")
            ->icon(Asset('assets/unitstates.svg'))
            ,
        ];
    }

}
