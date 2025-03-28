<?php

namespace App\Filament\Pages;

use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\Auth;
use Schmeits\FilamentUmami\Concerns\HasFilter;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFilter, HasFiltersAction;

    public function getColumns(): int|string|array
    {
        return 12;
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('1h')
                    ->action(fn() => $this->redirect(route('filament.manager.pages.dashboard'))),
                Action::make('24h')
                    ->action(fn() => $this->redirect(route('filament.manager.pages.dashboard', ['period' => '24_hours']))),
                Action::make('7d')
                    ->action(fn() => $this->redirect(route('filament.manager.pages.dashboard', ['period' => '7_days']))),
            ])
                ->label(__('Filter'))
                ->icon('heroicon-m-funnel')
                ->size(ActionSize::Small)
                ->color('gray')
                ->button()
        ];
    }

    public function getWidgets(): array
    {
        $widgets = [
            \Schmeits\FilamentUmami\Widgets\UmamiWidgetStatsGrouped::class,
        ];

        // Only some user see the Pulse widgets
        if (Auth::user()->email === 'bstrahija@gmail.com') {
            $widgets = array_merge($widgets, [
                PulseServers::class,
                PulseExceptions::class,
                PulseCache::class,
                PulseSlowQueries::class,
                PulseUsage::class,
                PulseSlowRequests::class,
                PulseQueues::class,
                // PulseSlowOutGoingRequests::class
            ]);
        }

        return $widgets;
    }
}
