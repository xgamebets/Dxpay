<?php

namespace App\Filament\Admin\Pages;

use App\Models\GamesKey;
use App\Traits\VolutiTrait;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Http;

class PixInPage extends Page implements HasForms
{
    use InteractsWithForms;
    use VolutiTrait;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $title = 'Gerar cobrança';

    public ?string $qrCode = null;
    protected static string $view = 'filament.pages.pixinpage';

    // protected static ?string $slug = 'chaves-dos-jogos';

    /**
     * @dev @victormsalatiel
     * @return bool
     */


    public ?string $amount;

    public ?string $copiaEcola;
    public ?array $data = [];
    // public ?GamesKey $setting;

    /**
     * @return void
     */
    public function mount(): void {}

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados  da cobrança')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Valor da cobrança')
                            ->placeholder('Digite aqui o valor')
                            ->maxLength(191)
                    ])
                    ->columns(3)
            ])
            ->statePath('data');
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        $amount = $this->data['amount'];
        // var_dump(route('pixgenerate'));die;
        try {
            $response = self::requestQrCode($amount);
            if ($response['pixCopiaECola']) {
                $qrCode = new QrCode($response['pixCopiaECola']);
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                 
              
                $this->qrCode = 'data:image/png;base64,' . base64_encode($result->getString());
                $this->copiaEcola = $response['pixCopiaECola'];
                $this->amount = $amount;
            } else {
                Notification::make()->title('Erro')->body('Erro ao gerar cobrança: ' . $response->body())->send();
            }
        } catch (\Exception $e) {
            Notification::make()->title('Erro')->body('Erro ao gerar cobrança: ' . $e->getMessage())->send();
        }
    }
    public function copyQrCode(): void
    {
        if ($this->qrCode) {
            // Aqui você pode retornar a imagem do QR Code ou um alerta de sucesso
            Notification::make()->title('Sucesso')->body('QR Code copiado para a área de transferência!')->send();
        } else {
            Notification::make()->title('Erro')->body('Não há QR Code para copiar.')->send();
        }
    }
}
