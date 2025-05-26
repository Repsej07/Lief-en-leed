@php
    $medicalChecks = $medicalChecks ?? collect([]);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('HR Dashboard - Ziektecontrole') }}</h2>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Ziekmeldingen -->
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
            <td class="px-4 py-3 text-sm controle-status">
                @php
                    $latestCheck = $user->medicalChecks()->orderBy('created_at', 'desc')->first();
                @endphp

                @if ($latestCheck)
                    @if ($latestCheck->status === 'gepland')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Gepland</span>
                    @elseif ($latestCheck->status === 'goedgekeurd')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Goedgekeurd</span>
                    @elseif ($latestCheck->status === 'afgekeurd')
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Afgekeurd</span>
                    @else
                        Niet gepland
                    @endif
                @else
                    Niet gepland
                @endif
            </td>
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
                    <div id="dropzone" class="border-2 border-dashed border-gray-300 p-6 rounded-lg mb-4 text-center bg-gray-50">
                        <p class="text-sm text-gray-500">Sleep een medewerker hierheen om een controle in te plannen</p>
                    </div>
                    <table id="planned-controls-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach (['Medewerker', 'Type', 'Datum', 'Status', 'Acties'] as $h)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        {{ $h }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="planned-controls-body">
                            @foreach ($medicalChecks as $check)
                                <tr>
                                    <td class="px-4 py-3 flex items-center space-x-3">
                                        <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold">
                                            {{ collect(explode(' ', $check->user->name))->map(fn($n) => strtoupper($n[0]))->join('') }}
                                        </span>
                                        <div class="text-sm font-medium">{{ $check->user->name }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ ucfirst($check->type) }}</td>
                                    <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($check->planned_date)->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3">
                                        @if($check->status === 'gepland')
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Gepland</span>
                                        @elseif($check->status === 'goedgekeurd')
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Goedgekeurd</span>
                                        @elseif($check->status === 'afgekeurd')
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Afgekeurd</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        <form action="{{ route('medical-checks.approve', $check->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition mr-2">
                                                Goedkeuren
                                            </button>
                                        </form>
                                        <form action="{{ route('medical-checks.disapprove', $check->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition">
                                                Afkeuren
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for planning check --}}
    <div id="check-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-medium mb-4">Plan controle voor <span id="modal-user-name"></span></h3>
            <form id="check-form" class="space-y-4">
                @csrf
                <input type="hidden" id="modal-user-id" name="user_id">
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type controle</label>
                    <select id="type" name="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="huisbezoek">Huisbezoek</option>
                        <option value="telefonisch">Telefonisch</option>
                        <option value="spreekuur">Spreekuur</option>
                    </select>
                </div>
                
 
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded">Annuleren</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Inplannen</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const geplandeMedewerkers = @json($medicalChecks->pluck('user_id'));
        function drag(event) {
            const userId = event.target.getAttribute('data-id');
            const userName = event.target.getAttribute('data-name');
            event.dataTransfer.setData('userId', userId);
            event.dataTransfer.setData('userName', userName);
        }
        
        document.getElementById('dropzone').addEventListener('dragover', function(event) {
            event.preventDefault();
            this.classList.add('bg-blue-50', 'border-blue-300');
        });
        
        document.getElementById('dropzone').addEventListener('dragleave', function(event) {
            this.classList.remove('bg-blue-50', 'border-blue-300');
        });
        
document.getElementById('dropzone').addEventListener('drop', function(event) {
    event.preventDefault();
    this.classList.remove('bg-blue-50', 'border-blue-300');
    
    const userId = event.dataTransfer.getData('userId');
    const userName = event.dataTransfer.getData('userName');

    // Check of user al gepland is
    if (geplandeMedewerkers.includes(Number(userId))) {
        alert(`${userName} heeft al een geplande controle.`);
        return; // Stop hier, niet de modal openen
    }
    
    // Anders modal openen zoals gewoonlijk
    document.getElementById('modal-user-id').value = userId;
    document.getElementById('modal-user-name').textContent = userName;
    document.getElementById('check-modal').classList.remove('hidden');
    document.getElementById('check-modal').classList.add('flex');
});

        
        document.getElementById('modal-cancel').addEventListener('click', function() {
            document.getElementById('check-modal').classList.add('hidden');
            document.getElementById('check-modal').classList.remove('flex');
        });
        
        document.getElementById('check-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("medical-checks.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('check-modal').classList.add('hidden');
                    document.getElementById('check-modal').classList.remove('flex');
                    
                    // Reload the page to reflect new changes
                    window.location.reload();
                }
            });
        });
    </script>
</x-app-layout>
