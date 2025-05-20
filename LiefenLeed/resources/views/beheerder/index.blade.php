<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('HR Dashboard - Ziekteverzuim') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Huidige ziekmeldingen --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium">Huidige ziekmeldingen</h3>
                    <a href="{{ route('beheerder.create') }}" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm inline-block">Nieuwe ziekmelding</a>
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach (['Medewerker', 'Afdeling', 'Startdatum', 'Status', 'Controle', 'Acties'] as $index => $h)
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase
                                        {{ $index === 5 ? 'w-[130px] whitespace-nowrap' : '' }}">
                                        {{ $h }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="sick-users-table-body">
                            @foreach ($users->where('is_sick', true) as $user)
                                <tr draggable="true" ondragstart="drag(event)" data-id="{{ $user->id }}" data-name="{{ $user->name }}" style="cursor: grab;">
                                    <td class="px-4 py-3 flex items-center space-x-3">
                                        <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold">
                                            {{ collect(explode(' ', $user->name))->map(fn($n) => strtoupper($n[0]))->join('') }}
                                        </span>
                                        <div class="text-sm font-medium">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $user->afdeling ?? 'Geen afdeling' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->sick_start_date ? \Carbon\Carbon::parse($user->sick_start_date)->format('d M Y') : 'Onbekend' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Ziek</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm controle-status">Niet gepland</td>
                                    <td class="px-4 py-3 text-right text-sm w-[130px] whitespace-nowrap">
                                        <form action="{{ route('beheerder.markNotSick') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="medewerker" value="{{ $user->id }}">
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition">
                                                Markeer als niet ziek
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Geplande controles --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium">Geplande controles (drag medewerkers hieronder)</h3>
                </div>
                <div class="overflow-x-auto p-4">
                    <table id="planned-controls-table" class="min-w-full divide-y divide-gray-200" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach (['Medewerker', 'Type', 'Datum', 'Status'] as $index => $h)
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase
                                        {{ $index === 3 ? 'w-[130px] whitespace-nowrap' : '' }}">
                                        {{ $h }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="planned-controls-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- script voor draggable elementen -->
<script>
    const plannedBody = document.getElementById('planned-controls-body');

    function allowDrop(e) { e.preventDefault(); }

    function drag(e) {
        const tr = e.target.closest('tr');
        if (!tr) return;
        e.dataTransfer.setData('text/plain', JSON.stringify({id: tr.dataset.id, name: tr.dataset.name}));
    }

    function drop(e) {
        e.preventDefault();
        const {id, name} = JSON.parse(e.dataTransfer.getData('text/plain'));
        if (document.querySelector(`#planned-controls-body tr[data-id="${id}"]`)) {
            alert('Deze medewerker is al toegevoegd aan Geplande controles.');
            return;
        }
        const now = new Date().toLocaleString('nl-NL', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
        const types = ['Huisbezoek', 'Telefonisch'].map(t => `<option>${t}</option>`).join('');
        const tr = document.createElement('tr');
        tr.dataset.id = id;
        tr.innerHTML = `
            <td class="px-4 py-3 text-sm">${name}</td>
            <td class="px-4 py-3 text-sm">
                <select class="border rounded px-2 py-1 text-sm min-w-[120px] max-w-[150px] whitespace-nowrap">
                    ${types}
                </select>
            </td>
            <td class="px-4 py-3 text-sm">${now}</td>
            <td class="px-4 py-3 w-[130px] whitespace-nowrap">
                <span class="status-label px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Gepland</span>
            </td>`;
        plannedBody.appendChild(tr);
    }
</script>
</x-app-layout>
