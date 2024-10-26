<?php

namespace App\Filament\Widgets;

use App\Filament\Admin\Pages\PixInPage;
use App\Models\PixInModel;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrdersChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'ordersChart';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Levantamento  de caixa total';

    /**
     * Sort
     */
    protected static ?int $sort = 3;

    /**
     * Widget content height
     */
    protected static ?int $contentHeight = 260;

    /**
     * Filter Form
     */
    protected function getFormSchema(): array
    {
        return [

            Radio::make('ordersChartType')
                ->default('bar')
                ->options([
                    'line' => 'Line',
                    'bar' => 'Col',
                    'area' => 'Area',
                ])
                ->inline(true)
                ->label('Type'),

            Grid::make()
                ->schema([
                    Toggle::make('ordersChartMarkers')
                        ->default(false)
                        ->label('Markers'),

                    Toggle::make('ordersChartGrid')
                        ->default(false)
                        ->label('Grid'),
                ]),

            TextInput::make('ordersChartAnnotations')
                ->required()
                ->numeric()
                ->default(7500)
                ->label('Annotations'),
        ];
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $filters = $this->filterFormData;
    
         // Inicializar um array para armazenar os dados mensais
                // Inicializar um array para armazenar os dados mensais
         
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
                'type' => $filters['ordersChartType'],
                'height' => 250,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'Orders per month',
                    'data' =>      $depositsPorMes, // Use the aggregated data
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 2,
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
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#2563eb'],
                    'inverseColors' => true,
                    'opacityFrom' => 1,
                    'opacityTo' => 1,
                    'stops' => [0, 100],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'show' => $filters['ordersChartGrid'],
            ],
            'markers' => [
                'size' => $filters['ordersChartMarkers'] ? 3 : 0,
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => $filters['ordersChartType'] === 'line' ? 4 : 0,
            ],
            'colors' => ['#1D77FF'],
            'annotations' => [
                'yaxis' => [
                    [
                        'y' => $filters['ordersChartAnnotations'],
                        'borderColor' => '#2563eb',
                        'borderWidth' => 1,
                        'label' => [
                            'borderColor' => '#2563eb',
                            'style' => [
                                'color' => '#fffbeb',
                                'background' => '#2563eb',
                            ],
                            'text' => 'Annotation: ' . $filters['ordersChartAnnotations'],
                        ],
                    ],
                ],
            ],
        ];
    }
}