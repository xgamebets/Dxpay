<?php

namespace App\Filament\Pages;


use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm, HasFiltersAction;
    
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Meu Dashboard';



    /**
     * @return string|\Illuminate\Contracts\Support\Htmlable|null
     */
    public function getSubheading(): string| null|\Illuminate\Contracts\Support\Htmlable
    {
       
       return "";
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    /**
     * @return array|\Filament\Actions\Action[]|\Filament\Actions\ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [
            // Action::make('Intervalo')
            //     ->label('Filtro')
            //     ->icon('heroicon-o-calendar-days')
            //     ->form([
            //         DateRangePicker::make('Intervalo'),
            //     ])
            //     ->action(function(){

            //     }),
        ];
    }


    /**
     * @return string[]
     */
    public function getWidgets(): array
    {
        return [

            \App\Filament\Widgets\DashboardWidget::class,
            \App\Filament\Widgets\LineChart::class,
            \App\Filament\Widgets\OrdersChart::class,
            \App\Filament\Widgets\DonutChart::class,
            \App\Filament\Widgets\FaWitget::class
            

        ];
    }
    public function getFooterTitle(): string
{
    return 'Dashboard';
}


public function getFooterWidgets(): array
{
    return [

    ];
}
}
