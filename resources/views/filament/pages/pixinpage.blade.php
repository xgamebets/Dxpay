<x-filament-panels::page>
    @if (!$qrCode)
        <form wire:submit.prevent="submit">
            {{ $this->form }}
            <br>
            <x-filament::button type="submit">
                Gerar cobrança
            </x-filament::button>
        </form>
    @endif

    @if ($qrCode)
        <div class="w-full flex flex-col items-center mt-4">
            <h1 class="font-bold text-[28px]">R$ {{ $amount }}</h1>
            <img id="qrCodeImage" src="{{ $qrCode }}" alt="QR Code" class="mt-2">
            <x-filament::button onclick="copyQrCode()" wire:click="copyQrCode" id="copyButton"
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
                Copiar QR Code
            </x-filament::button>
        </div>
    @endif

</x-filament-panels::page>

@if ($copiaEcola)
    <script>
        function copyQrCode() {
            navigator.clipboard.writeText({
                $copiaEcola
            }).then(() => {
                console.log($copiaEcola);
            }).catch(err => {
                console.error('Erro ao copiar QR Code: ', err);
            });
        }
    </script>
@endif
