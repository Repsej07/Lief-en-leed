<x-app-layout>
    <div class="flex justify-center items-center py-12">
        <div class="max-w-2xl w-full bg-white border border-gray-200 shadow-lg rounded-2xl px-8 py-10 text-gray-800">
            <div class="text-center">
                <h1 class="text-2xl font-bold mb-6">Importeer hier de bestaande data</h1>
                <div class="text-center">
                    {{-- Success/Error feedback --}}
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('skipped') && count(session('skipped')) > 0)
                        <div class="mt-6 bg-red-100 text-red-800 p-4 rounded-lg">
                            <h2 class="font-bold text-lg mb-2">Overgeslagen gebruikers:</h2>
                            <ul class="list-disc list-inside">
                                @foreach (session('skipped') as $skip)
                                    <li>
                                        <strong>{{ $skip['medewerker'] }}</strong> ({{ $skip['email'] }}) —
                                        {{ $skip['reden'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('import.data') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <!-- file input and button -->
                    </form>
                </div>

                <form action="{{ route('import.data') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <input type="file" name="import_file" accept=".json" required
                        class="block w-full text-gray-700 border border-gray-300 rounded-lg p-2">

                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                        Importeer
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
