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

class PixoutPage extends Page implements HasForms
{
    use InteractsWithForms;
    use VolutiTrait;


    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $title = 'Realizar Pagamento';

    public ?string $qrCode = null;
    protected static string $view = 'filament.pages.pixoutpage';

    // protected static ?string $slug = 'chaves-dos-jogos';

    /**
     * @dev @victormsalatiel
     * @return bool
     */


    public ?string $amount;
    public ?array $data = [];

    public ?bool $disabled = false;
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
                Section::make('Dados  da pagamento')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Valor do pagamento')
                            ->placeholder('Digite aqui o valor')
                            ->maxLength(191),
                        TextInput::make('pix_key')
                            ->label('Digite aqui a chave pix')
                            ->placeholder('Digite aqui a chave')
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
        $this->disabled = true;
        $amount = $this->data['amount'];
        $pixKey = $this->data['pix_key'];
        $response = self::cashout($amount,$pixKey);
        
        if(isset($response['detail'])){
            Notification::make()->title("Erro")->body($response['detail'])->send();
            return;
        }
        
        Notification::make()->title('Status atual:'. $response['status'])->body('Saque realizado com sucesso!')->send();
    }
   
}
