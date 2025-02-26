<?php

use Livewire\Volt\Component;

new class extends Component {

    public $plugins = [
        'markup' =>
            ['name' => 'Markup', 'icon' => 'code-backet', 'route' => 'plugins.markup'],
        'api' =>
            ['name' => 'API', 'icon' => 'code-backet', 'route' => 'plugins.api'],
    ];

};
?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold dark:text-gray-100">Plugins</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($plugins as $plugin)
                <div
                    class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-xs">
                    <a href="{{ route($plugin['route']) }}" class="block">
                        <div class="flex items-center space-x-4 px-10 py-8">
                            <flux:icon name="code-bracket" class="text-4xl text-accent"/>
                            <h3 class="text-xl font-medium dark:text-zinc-200">{{$plugin['name']}}</h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
