<x-html :title="$attributes->get('title') ?? ''" 
    class="
    text-cool-gray-800 leading-normal lg:px-2 font-sans" x-data="AppOffCanvasMenu()">
    <x-slot name="head">
        <link rel="stylesheet" href="{{ mix('css/docs.css') }}">
        {{ $head ?? "" }}
    </x-slot>

    <x-docs.header></x-docs.header>

    <main role="main" class="w-full flex-auto">
        <div class="max-w-8xl mx-auto px-4 lg:px-4 xl:px-6 lg:flex lg:flex-row">

            <x-screencasts.nav.menu :items="docs_navigation()"></x-screencasts.nav.menu>

                <div class="relative w-full px-3 lg:ml-10 xl:ml-16 lg:px-0 mt-10 mb-20">
                    {{ $slot }}
                </div> 
        </div>
    </main>

    <x-slot name="footer">
        <script src="{{ mix('js/main.js') }}"></script>
        @stack('scripts')
    </x-slot>
</x-html>