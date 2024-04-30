<div class="col-span-2 flex">
    <x-form.input type="date"
        name="starting_date"
        id="starting_date"
        label="Data de Início"
        wire:model.live="startingDate"
        required
    />

    <div class="mx-8">
        <label for="duration"
              class="block mb-2 text-sm font-medium text-gray-900">
            Duração <span class="text-red-600">*</span>
        </label>
        <label class="inline-flex items-center cursor-pointer mr-8">
            <input type="radio"
                name="duration"
                wire:model.live="duration"
                value="15"
                class="sr-only peer"
                required
                @click="isMeasurable = false">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 flex">
                15 dias
            </span>
        </label>

        <label class="inline-flex items-center cursor-pointer">
            <input type="radio"
                name="duration"
                wire:model.live="duration"
                value="30"
                class="sr-only peer"
                required
                @click="isMeasurable = true">
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 flex">
                30 dias
            </span>
        </label>
    </div>

    <x-form.input type="date"
        name="ending_date"
        id="ending_date"
        label="Data de Término"
        wire:model.live="endingDate"
        required
    />
</div>
