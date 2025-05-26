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
                        <div class="relative w-[24em]">
                            <input type="text" name="medewerker" id="name" class="p-2 rounded-md w-full"
                                autocomplete="off" required>
                            <div id="nameList" class="bg-white border rounded shadow-md absolute z-10 mt-1 w-full hidden">
                            </div>
                        </div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById('name');
            const nameList = document.getElementById('nameList');

            nameInput.addEventListener('input', function() {
            const query = this.value;

            if (query.length > 0) {
                fetch(`/search-employees?query=${query}`)
                .then(res => res.json())
                .then(data => {
                    let output = '';
                    if (data.length > 0) {
                    data.forEach(employee => {
                        output +=
                        `<div class="p-2 hover:bg-blue-100 cursor-pointer" data-name="${employee.name}" data-id="${employee.id}">${employee.name}</div>`;
                    });
                    nameList.innerHTML = output;
                    nameList.classList.remove('hidden');
                    } else {
                    nameList.classList.add('hidden');
                    }

                    // click event on options
                    document.querySelectorAll('#nameList div').forEach(item => {
                    item.addEventListener('click', function() {
                        nameInput.value = this.dataset.name;
                        const userIdInput = document.createElement('input');
                        userIdInput.type = 'hidden';
                        userIdInput.name = 'user_id';
                        userIdInput.value = this.dataset.id;
                        nameInput.closest('form').appendChild(userIdInput);
                        nameList.classList.add('hidden');
                    });
                    });
                });
            } else {
                nameList.classList.add('hidden');
            }
            });

            // Close dropdown on outside click
            document.addEventListener('click', function(e) {
            if (!nameInput.contains(e.target) && !nameList.contains(e.target)) {
                nameList.classList.add('hidden');
            }
            });
        });
    </script>

</x-app-layout>
