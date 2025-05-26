
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center py-12">
        <x-requestform :gebeurtenissen="$gebeurtenissen">
        </x-requestform>

    </div>
</x-app-layout>
