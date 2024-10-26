<?php

namespace App\Filament\Widgets;

use App\Models\PixInModel;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DonutChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'donutChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Controle de Conversões';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $depositsGerados = 
        PixInModel::where("user_id",auth()->user()->id)
        ->where("status",0)
        ->count('id');
        $depositsPagos = 
        PixInModel::where("user_id",auth()->user()->id)
        ->where("status",1)
        ->count('id');
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$depositsGerados,$depositsPagos],
            'labels' => ['Pix Gerados','Pix Pagos'],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
            'plotOptions' => array(
                'pie' =>  array(
                    'donut' =>  array(
                        'size' => '50%'
                    )
                )
            )
        ];
    }
}
