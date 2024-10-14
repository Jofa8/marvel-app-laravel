<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Marvel App</title>
        @vite('resources/css/app.css')
    </head>
    <body class="">
        <div class="flex flex-col items-center justify-center w-full">
            <h1 class="my-16 text-6xl font-bold bg-clip-text text-black hover:rotate-3 hover:scale-105 transition duration-500">Marvel List App</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-[1200px]">
                @foreach ($characters as $character)
                    <div class="flex flex-col items-center bg-white p-4 rounded-lg">
                        <div class="relative">
                            @if(isset($character->image))
                                <img src="{{ $character->image }}" class="h-72 w-48 rounded-md" />
                            @else
                                <img src="{{ $character->thumbnail->path }}.{{ $character->thumbnail->extension }}" class="h-72 w-48 rounded-md"/>
                            @endif
                            <div class="absolute top-2 right-2 bg-blue-600 text-white py-1 px-3 rounded-md text-xs">
                                <span>{{ $character->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
