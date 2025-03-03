<?php

use App\Jobs\GenerateScreenJob;
use Illuminate\Support\Facades\Bus;

test('it generates screen with default parameters', function () {
    Bus::fake();

    $this->artisan('trmnl:screen:generate')
        ->assertSuccessful();

    Bus::assertDispatched(GenerateScreenJob::class);
});
