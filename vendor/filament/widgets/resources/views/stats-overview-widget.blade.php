@php
    $columns = $this->getColumns();
@endphp

<x-filament-widgets::widget class=" fi-wi-stats-overview">
    <div @if ($pollingInterval = $this->getPollingInterval()) wire:poll.{{ $pollingInterval }} @endif @class(['hidden sm:grid  fi-wi-stats-overview-stats-ctn  gap-6'])
        style="grid-template-columns: repeat(5, 1fr);">
        @foreach ($this->getCachedStats() as $stat)
            {{ $stat }}
        @endforeach
    </div>

    <div @if ($pollingInterval = $this->getPollingInterval()) wire:poll.{{ $pollingInterval }} @endif @class(['grid sm:hidden fi-wi-stats-overview-stats-ctn gap-6'])
        style="grid-template-columns: repeat(1, 1fr);">
        @foreach ($this->getCachedStats() as $stat)
            {{ $stat }}
        @endforeach
    </div>
</x-filament-widgets::widget>
