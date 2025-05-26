<x-app-layout>
    <div class="mt-8 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-7xl mx-auto">
        <div class="flex justify-center items-center mb-6">
            <h1 class="text-2xl font-bold">Aanvragen Overzicht</h1>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medewerker</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($requests as $request)
                <!-- Alle medewerwerkers uit de requests tabel zijn hier zichtbaar -->
                    @if (!$request->approved)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600 mr-3">
                                    <!-- Eerste twee letters worden weergeven -->
                                    {{ strtoupper(substr($request->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $request->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <!-- Datum van aanvraag wordt geparsed en geformatteerd -->
                                {{ \Carbon\Carbon::parse($request->datum)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('request.goedkeuren', $request->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded">Goedkeuren</button>
                                </form>
                                <form action="{{ route('request.afkeuren', $request->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded">Afkeuren</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
