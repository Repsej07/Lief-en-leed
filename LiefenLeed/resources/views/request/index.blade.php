<x-app-layout>
    <style>
        @media (max-width: 640px) {
            table thead {
                display: none;
            }

            table,
            tbody,
            tr,
            td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                background: #fff;
                box-sizing: border-box;
                padding: 0.5rem 0;
            }

            td {
                padding: 0.5rem 1rem;
                border: none;
                border-bottom: 1px solid #e5e7eb;
                text-align: center;
                font-size: 0.95rem;
                color: #374151;
                display: block;
                width: 100%;
            }

            td:last-child {
                border-bottom: none;
            }

            label {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                gap: 0.5rem;
                cursor: pointer;
                width: 100%;
            }

            label>div.flex.items-center.flex-1 {
                flex-direction: row !important;
                justify-content: center !important;
                gap: 0.75rem;
                margin-bottom: 0.5rem;
            }

            label>div.flex.items-center.flex-1>div.h-10.w-10 {
                margin: 0 !important;
            }

            /* Text elements */
            label>div.flex.items-center.flex-1>span.text-sm.font-medium.text-gray-900 {
                text-align: left;
            }

            /* Other info divs */
            label>div.flex-1.text-sm.text-gray-700 {
                width: 100%;
                text-align: center;
                margin-bottom: 0.5rem;
            }

            /* Form buttons container */
            label>div.flex-1:last-child {
                display: flex !important;
                justify-content: center !important;
                gap: 0.5rem;
                width: auto !important;
            }

            /* Make buttons smaller and inline on mobile */
            form.inline {
                flex: 1 1 auto;
            }

            form.inline button {
                width: 100%;
                max-width: 120px;
                font-size: 0.9rem;
                padding: 0.4rem 0.75rem;
            }

            /* Show/hide details below each row when checkbox toggled */
            .peer-checked~div {
                display: block !important;
            }

            .peer~div {
                display: none;
            }

            /* Style the expanded detail box */
            .peer-checked~div {
                background-color: #d1fae5;
                /* green-50 */
                border-top: 1px solid #bbf7d0;
                /* green-100 */
                padding: 0.75rem 1rem;
                color: #065f46;
                /* green-800 */
                font-size: 0.9rem;
                border-radius: 0 0 0.5rem 0.5rem;
                text-align: left;
            }
        }

        /*i did the mobile stylings with the help of AI because of not enough time*/
    </style>
    <div class="mt-12 bg-white shadow-xl rounded-2xl px-10 pt-8 pb-12 mb-8 max-w-6xl mx-auto">
        <div class="flex flex-col items-center mb-6 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">
                Overzicht van niet Goedgekeurde Aanvragen
            </h1>
            @if ($requests->where('approved', false)->count() > 0)
                <span
                    class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full mt-2 md:mt-0">
                    {{ $requests->where('approved', false)->count() }} Actie vereist
                </span>
            @else
                <span
                    class="inline-block bg-green-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full mt-2 md:mt-0">
                    Geen openstaande aanvragen
                </span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Medewerker</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Datum</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase w-1/4">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($requests->where('approved', false) as $request)
                        @php $uid = 'aanvraag-' . $request->id; @endphp
                        <tr class="hover:bg-blue-50 transition">
                            <td colspan="4" class="p-0 border-0">
                                <input type="checkbox" id="{{ $uid }}" class="peer hidden" />
                                <label for="{{ $uid }}"
                                    class="flex cursor-pointer items-center w-full px-6 py-4 hover:bg-blue-100 transition">
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 mr-3 shadow-sm">
                                            {{ strtoupper(substr($request->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $request->name }}</span>
                                    </div>
                                    <div class="flex-1 text-sm text-gray-700">{{ $request->type }}</div>
                                    <div class="flex-1 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($request->datum)->format('d M Y H:i') }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex flex-col gap-2 w-48">
                                            <form action="{{ route('request.goedkeuren', $request->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-green-100 text-green-800 py-2 rounded-lg text-center hover:bg-green-200 transition font-semibold shadow">
                                                    <svg class="inline w-5 h-5 mr-1 -mt-1" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Goedkeuren
                                                </button>
                                            </form>
                                            <form action="{{ route('request.afkeuren', $request->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full bg-red-100 text-red-800 py-2 rounded-lg text-center hover:bg-red-200 transition font-semibold shadow">
                                                    <svg class="inline w-5 h-5 mr-1 -mt-1" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Afkeuren
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </label>
                                <div
                                    class="peer-checked:block hidden bg-blue-50 border-t border-blue-100 px-6 py-4 text-gray-700">
                                    <span class="font-semibold">Aangedvraagd door:</span>
                                    <span>{{ $request->created_by }}</span>
                                    <br>
                                    <span class="font-semibold">Opmerkingen:</span>
                                    <span>
                                        {{ $request->opmerkingen ? $request->opmerkingen : 'Geen opmerkingen toegevoegd.' }}
                                    </span>
                                </div>
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
                            <td colspan="4" class="p-0 border-0">
                                <input type="checkbox" id="{{ $uid }}" class="peer hidden" />
                                <label for="{{ $uid }}"
                                    class="flex cursor-pointer items-center w-full px-6 py-4 hover:bg-green-50 transition">
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 mr-3 shadow-sm">
                                            {{ strtoupper(substr($request->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $request->name }}</span>
                                    </div>
                                    <div class="flex-1 text-sm text-gray-700">{{ $request->type }}</div>
                                    <div class="flex-1 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($request->datum)->format('d M Y H:i') }}
                                    </div>
                                    <div class="flex-1">
                                        <form action="{{ route('request.toggleStatus', $request->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="w-full inline-block bg-green-100 text-green-800 py-2 rounded-lg text-center font-semibold shadow hover:bg-green-200 transition"
                                                title="Klik om goedkeuring in te trekken">
                                                <svg class="inline w-5 h-5 mr-1 -mt-1" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Goedgekeurd
                                            </button>
                                        </form>

                                    </div>
                                </label>
                                <div
                                    class="peer-checked:block hidden bg-green-50 border-t border-green-100 px-6 py-4 text-gray-700">
                                    <span class="font-semibold">Aangedvraagd door:</span>
                                    <span>{{ $request->created_by }}</span>
                                    <br>
                                    <span class="font-semibold">Opmerkingen:</span>
                                    <span>
                                        {{ $request->comments ? $request->comments : 'Geen opmerkingen toegevoegd.' }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-lg">
                                Nog geen goedgekeurde aanvragen
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>
