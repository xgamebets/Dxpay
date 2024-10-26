<x-filament-panels::page>
    @if (!$qrCode)
        <form wire:submit.prevent="submit">
            {{ $this->form }}
            <br>
            <x-filament::button type="submit">
               Pagar
            </x-filament::button>
        </form>
    @endif

</x-filament-panels::page>

