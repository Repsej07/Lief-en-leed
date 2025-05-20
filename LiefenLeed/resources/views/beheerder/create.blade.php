<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwe Ziekmelding</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                {{-- Success message --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('beheerder.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Medewerker --}}
                    <div>
                        <label for="medewerker" class="block text-sm font-medium text-gray-700">Medewerker</label>
                        <select id="medewerker" name="medewerker" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Selecteer medewerker --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->afdeling ?? 'Geen afdeling' }})</option>
                            @endforeach
                        </select>
                        @error('medewerker')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Startdatum --}}
                    <div>
                        <label for="startdatum" class="block text-sm font-medium text-gray-700">Startdatum ziekte</label>
                        <input type="date" name="startdatum" id="startdatum" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        @error('startdatum')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opmerkingen --}}
                    <div>
                        <label for="opmerkingen" class="block text-sm font-medium text-gray-700">Opmerkingen (optioneel)</label>
                        <textarea name="opmerkingen" id="opmerkingen" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Eventuele aanvullende informatie..."></textarea>
                    </div>

                    {{-- Actieknoppen --}}
                    <div class="flex justify-end">
                        <a href="{{ route('beheerder.index') }}" class="mr-4 py-2 px-4 border rounded-md text-sm text-gray-700 hover:bg-gray-50">
                            Annuleren
                        </a>
                        <button type="submit"
                            class="py-2 px-4 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Ziekmelding versturen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
