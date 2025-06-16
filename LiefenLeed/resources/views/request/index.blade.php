<x-app-layout>
    <style>
        /* Responsive table for mobile */
       @media (max-width: 640px) {
    table thead {
        display: none;
    }
    table, tbody, tr, td {
        display: block;
        width: 100%;
    }
    tr {
        margin-bottom: 1.25rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-sizing: border-box;
        padding: 0.75rem 1rem;
        background: white;
    }
    td {
        padding: 0.75rem 1rem; /* no padding-left for label */
        position: relative;
        border: none;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        line-height: 1.4;
        font-size: 0.9rem;
        color: #374151;
    }
    td:last-child {
        border-bottom: 0;
    }
    /* Hide the data-label before content */
    td::before {
        content: none !important;
    }
    /* Details row styles */
    .details-row {
        margin-top: -1rem;
        border: none;
        padding: 0;
        background-color: #eff6ff;
        border-radius: 0 0 0.5rem 0.5rem;
    }
    .details-row td {
        padding: 0.75rem 1rem !important;
        border: none !important;
        font-size: 0.9rem;
        color: #374151;
        text-align: left;
        position: static;
        padding-left: 1rem !important;
        line-height: 1.5;
    }
    .details-row td::before {
        content: none !important;
    }
}

    </style>

    <div class="mt-12 bg-white shadow-xl rounded-2xl px-10 pt-8 pb-12 mb-8 max-w-6xl mx-auto">
        {{-- Section: Niet Goedgekeurde Aanvragen --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">
                Overzicht van niet Goedgekeurde Aanvragen
            </h1>
            @if ($requests->where('approved', false)->count() > 0)
                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $requests->where('approved', false)->count() }} Actie vereist
                </span>
            @else
                <span class="inline-block bg-green-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full">
                    Geen openstaande aanvragen
                </span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4" id="label">Medewerker</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4" id="label">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4" id="label">Datum</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4" id="label">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($requests->where('approved', false) as $request)
                        @php $uid = 'aanvraag-' . $request->id; @endphp
                        <tr class="hover:bg-blue-50 transition">
                            <td data-label="Medewerker" class="px-6 py-4 flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 mr-3 shadow-sm">
                                    {{ strtoupper(substr($request->name, 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $request->name }}</span>
                            </td>
                            <td data-label="Type" class="px-6 py-4 text-gray-700 text-sm">{{ $request->type }}</td>
                            <td data-label="Datum" class="px-6 py-4 text-gray-700 text-sm">
                                {{ \Carbon\Carbon::parse($request->datum)->format('d M Y H:i') }}
                            </td>
                            <td data-label="Acties" class="px-6 py-4">
                                <div class="flex flex-col gap-2 max-w-xs">
                                    <form action="{{ route('request.goedkeuren', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-100 text-green-800 py-2 rounded-lg text-center hover:bg-green-200 transition font-semibold shadow flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-1 -mt-1" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Goedkeuren
                                        </button>
                                    </form>
                                    <form action="{{ route('request.afkeuren', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-red-100 text-red-800 py-2 rounded-lg text-center hover:bg-red-200 transition font-semibold shadow flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-1 -mt-1" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Afkeuren
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="4">
                                <strong>Aangedvraagd door:</strong> {{ $request->created_by }} <br>
                                <strong>Opmerkingen:</strong>
                                {{ $request->opmerkingen ? $request->opmerkingen : 'Geen opmerkingen toegevoegd.' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-lg">
                                Geen openstaande aanvragen
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Section: Goedgekeurde Aanvragen --}}
        <div class="flex justify-between items-center mb-6 mt-14">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">
                Goedgekeurde Aanvragen
            </h1>
            <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                Archief
            </span>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Medewerker</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Datum</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($requests->where('approved', true) as $request)
                        @php $uid = 'approved-aanvraag-' . $request->id; @endphp
                        <tr>
                            <td data-label="Medewerker" class="px-6 py-4 flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 mr-3 shadow-sm">
                                    {{ strtoupper(substr($request->name, 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $request->name }}</span>
                            </td>
                            <td data-label="Type" class="px-6 py-4 text-gray-700 text-sm">{{ $request->type }}</td>
                            <td data-label="Datum" class="px-6 py-4 text-gray-700 text-sm">
                                {{ \Carbon\Carbon::parse($request->datum)->format('d M Y H:i') }}
                            </td>
                            <td data-label="Status" class="px-6 py-4">
                                <form action="{{ route('request.toggleStatus', $request->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-block bg-green-100 text-green-800 py-2 rounded-lg text-center font-semibold shadow hover:bg-green-200 transition flex items-center justify-center"
                                        title="Status wijzigen">
                                        <svg class="w-5 h-5 mr-1 -mt-1" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Goedgekeurd
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="4">
                                <strong>Aangedvraagd door:</strong> {{ $request->created_by }} <br>
                                <strong>Opmerkingen:</strong>
                                {{ $request->opmerkingen ? $request->opmerkingen : 'Geen opmerkingen toegevoegd.' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-lg">
                                Geen goedgekeurde aanvragen
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
