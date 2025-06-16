<x-app-layout>
    <div class="min-h-screen flex items-center justify-center py-12">
        <div class="bg-white shadow-xl rounded-2xl px-10 pt-10 pb-12 max-w-md w-full text-center">
            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-opacity="0.15"
                        stroke-width="2.5" fill="currentColor" fill-opacity="0.05" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 13l3 3 7-7" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-800 mb-2">Aanvraag succesvol!</h2>
            <p class="mb-6 text-gray-600">Je aanvraag is succesvol ingevuld.<br>Bedankt voor je inzending.</p>
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 transition text-white font-semibold py-3 px-8 rounded-lg shadow">
                Terug naar Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
