<?php

namespace Spatie\LivewireWizard;

use Illuminate\Support\Arr;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LivewireWizard\Tests\TestSupport\Support\EventEmitter;

class WizardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-livewire-wizard')
            ->hasViews();
    }

    public function bootingPackage()
    {
        $this->registerLivewireTestMacros();
    }

    public function registerLivewireTestMacros()
    {
        TestableLivewire::macro('emitEvents', function () {
            return new EventEmitter($this);
        });

        TestableLivewire::macro('getStateForStep', function (string $step) {
            $state = $this->get('allStepState');

            $stepName = class_exists($step)
                ? Livewire::getAlias($step)
                : $step;

            return Arr::get($state, $stepName);
        });
    }
}
