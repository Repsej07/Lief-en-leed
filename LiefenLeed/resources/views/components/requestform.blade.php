<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-7xl">

    <div id="forms">
        <form action="" method="post">
            <div class="flex flex-row items-center justify-center space-x-8">
                <div class="flex flex-col items-center">
                    <label for="name" class="mb-2 text-black font-bold">
                       Naam Werknemer
                    </label>
                    <input type="text" name="name" id="name" class="p-2 rounded-md w-[24em]" required>
                </div>
                <div class="flex flex-col items-center">
                    <label for="dropdown" class="mb-2 font-bold">Selecteer een gebeurtenis</label>
                    <select name="dropdown" id="" class="p-2 rounded-md w-[24em]">
                        <option value="ziek">Ziek</option>
                        <option value="ziekte 3 maanden">Ziekte 3 maanden</option>
                        <option value="ziekte 3 weken">Ziekte 3 weken</option>
                        <option value="ziekte ziekenhuisopname">Ziekte ziekenhuisopname</option>
                        <option value="huwelijk/geregistreerd partnerschap">Huwelijk/Geregistreerd Partnerschap</option>
                        <option value="ontslag/fpu/pensionering">Ontslag/FPU/Pensionering</option>
                        <option value="50e verjaardag">50e Verjaardag</option>
                        <option value="65e verjaardag">65e Verjaardag</option>
                        <option value="12,5 jaar huwelijk">12,5 Jaar Huwelijk</option>
                        <option value="12,5 jaar ambtenaar">12,5 Jaar Ambtenaar</option>
                        <option value="25 jaar huwelijk">25 Jaar Huwelijk</option>
                        <option value="25 jaar ambtenaar">25 Jaar Ambtenaar</option>
                        <option value="overlijden ambtenaar of huisgenoot">Overlijden Ambtenaar of Huisgenoot</option>
                        <option value="40 jaar ambtenaar">40 Jaar Ambtenaar</option>
                        <option value="40 jarig huwelijk">40 Jarig Huwelijk</option>
                    </select>
                </div>

            </div>
            <div class="flex flex-col items-center space-y-2 w-full mt-5">
                <label for="opmerkingen" class="mb-2 font-bold">Eventuele opmerkingen?</label>
                <textarea name="opmerkingen" id="opmerkingen" class="p-2 rounded-md w-full resize-none h-20 overflow-hidden" autocapitalize="sentences" maxlength="250" ></textarea>
            </div>
            <div class="flex justify-center mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded w-full text-xl">
                    Aanvragen
                </button>
            </div>


        </form>

    </div>

</div>
