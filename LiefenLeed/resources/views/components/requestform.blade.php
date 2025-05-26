<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-7xl">
    <div class="flex justify-center items-center mb-4">
        <h1 class="text-2xl font-bold">Lief en leed Aanvraag</h1>
    </div>
    <div id="forms">
        <form action="{{route(name: 'storeRequest')}}" method="POST">
            @csrf
            <div class="flex flex-row items-center justify-center space-x-8">
                <div class="flex flex-col items-center">
                    <label for="name" class="mb-2 text-black font-bold">
                        Naam Werknemer*
                    </label>
                    <div class="relative w-[24em]">
                        <input type="text" name="name" id="name" class="p-2 rounded-md w-full"
                            autocomplete="off" required placeholder="Zoek werknemer...">
                        <input type="hidden" name="selected_name" id="selected_name" required>
                        <div id="nameList" class="bg-white border rounded shadow-md absolute z-10 mt-1 w-full hidden">
                        </div>
                    </div>

                </div>
                <div class="flex flex-col items-center">
                    <label for="type" class="mb-2 font-bold">Selecteer een gebeurtenis*</label>
                    <select name="type" id="type" class="p-2 rounded-md w-[24em]" required>
                        @foreach ($gebeurtenissen as $gebeurtenis)
                            <option value="{{ $gebeurtenis->type }}">{{ $gebeurtenis->type }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="flex flex-col items-center space-y-2 w-full mt-5">
                <label for="opmerkingen" class="mb-2 font-bold">Eventuele opmerkingen?</label>
                <textarea name="opmerkingen" id="opmerkingen" class="p-2 rounded-md w-full resize-none h-20 overflow-hidden"
                    autocapitalize="sentences" maxlength="250"></textarea>
            </div>
            <div class="flex justify-center mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded w-full text-xl">
                    Aanvragen
                </button>
            </div>


        </form>

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
                                    `<div class="p-2 hover:bg-blue-100 cursor-pointer" data-name="${employee.name}">${employee.name}</div>`;
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
