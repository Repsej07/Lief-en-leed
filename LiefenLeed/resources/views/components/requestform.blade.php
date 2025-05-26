<div class="max-w-2xl mx-auto mt-10 bg-white border border-gray-200 shadow-lg rounded-2xl px-8 py-10">
    <div class="flex justify-center mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-800">Lief en Leed Aanvraag</h1>
    </div>

    <form action="{{ route('storeRequest') }}" method="POST" class="space-y-8">
        @csrf

        <div class="flex flex-col md:flex-row md:space-x-8 space-y-6 md:space-y-0">
            <div class="flex-1">
                <label for="name" class="block mb-2 text-gray-700 font-medium">
                    Naam Werknemer <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                        autocomplete="off"
                        required
                        placeholder="Zoek werknemer..."
                    >
                    <input type="hidden" name="selected_name" id="selected_name" required>
                    <input type="hidden" name="medewerker" id="medewerker">
                    <div
                        id="nameList"
                        class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 hidden max-h-52 overflow-y-auto"
                    ></div>
                </div>
            </div>
            <div class="flex-1">
                <label for="type" class="block mb-2 text-gray-700 font-medium">
                    Selecteer een gebeurtenis <span class="text-red-500">*</span>
                </label>
                <select
                    name="type"
                    id="type"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    required
                >
                    @foreach ($gebeurtenissen as $gebeurtenis)
                        <option value="{{ $gebeurtenis->type }}">{{ $gebeurtenis->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="opmerkingen" class="block mb-2 text-gray-700 font-medium">
                Eventuele opmerkingen?
            </label>
            <textarea
                name="opmerkingen"
                id="opmerkingen"
                class="w-full p-3 border border-gray-300 rounded-lg resize-none h-24 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                autocapitalize="sentences"
                maxlength="250"
                placeholder="Schrijf hier je opmerkingen (max 250 tekens)..."
            ></textarea>
        </div>

        <div class="flex justify-center">
            <button
                type="submit"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-10 rounded-lg shadow transition"
            >
                Aanvragen
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const nameInput = document.getElementById('name');
    const nameList = document.getElementById('nameList');
    const selectedNameInput = document.getElementById('selected_name');
    const medewerkerInput = document.getElementById('medewerker');

    nameInput.addEventListener('input', function() {
        const query = this.value.trim();

        if (query.length > 0) {
            fetch(`/search-employees?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        nameList.innerHTML = data.map(employee => {
                            const fullName = `${employee.voornaam} ${employee.tussenvoegsel ? employee.tussenvoegsel + ' ' : ''}${employee.achternaam}`;
                            return `
                                <div
                                    class="p-2 hover:bg-blue-100 cursor-pointer rounded transition"
                                    data-name="${fullName}"
                                    data-medewerker="${employee.medewerker}"
                                >
                                    ${fullName}
                                </div>
                            `;
                        }).join('');
                        nameList.classList.remove('hidden');
                    } else {
                        nameList.classList.add('hidden');
                    }

                    nameList.querySelectorAll('div[data-name]').forEach(item => {
                        item.addEventListener('click', function() {
                            nameInput.value = this.dataset.name;
                            selectedNameInput.value = this.dataset.name;
                            medewerkerInput.value = this.dataset.medewerker;
                            nameList.classList.add('hidden');
                        });
                    });
                });
        } else {
            nameList.classList.add('hidden');
            selectedNameInput.value = '';
            medewerkerInput.value = '';
        }
    });

    document.addEventListener('click', function(e) {
        if (!nameInput.contains(e.target) && !nameList.contains(e.target)) {
            nameList.classList.add('hidden');
        }
    });
});
</script>
