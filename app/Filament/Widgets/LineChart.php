<?php

namespace App\Filament\Widgets;

use App\Models\PixInModel;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LineChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'customersChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Total faturado';

    /**
     * Sort
     */
    protected static ?int $sort = 4;

    /**
     * Widget content height
     */
    protected static ?int $contentHeight = 270;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        // Obter o ano e o mês atual
        $anoAtual = date('Y');
        
        // Inicializar um array para armazenar os dados mensais
        $depositsPorMes = array_fill(0, 12, 0); // 12 meses
    
        // Agrupar depósitos por mês
        $depositsGerados = PixInModel::where("user_id", auth()->user()->id)
            // ->where("status", 0)
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->get();
    
        // Preencher o array com os totais mensais
        foreach ($depositsGerados as $deposito) {
            $depositsPorMes[$deposito->mes - 1] = $deposito->total; // Meses são 1-12
        }
    
        return [
            'chart' => [
                'type' => 'line',
                'height' => 250,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'Depósitos Gerados',
                    'data' => $depositsPorMes, // Usar os dados agrupados
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontWeight' => 400,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontWeight' => 400,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'horizontal',
                    'shadeIntensity' => 1,
                    'gradientToColors' => ['#2563eb'],
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 1,
                    'stops' => [0, 100, 100, 100],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'show' => false,
            ],
            'markers' => [
                'size' => 2,
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 4,
            ],
            'colors' => ['#2563eb'],
        ];
    }
}