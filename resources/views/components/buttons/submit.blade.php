@props([
    'withLoading' => null,
])

<button
        type="submit"
        @if ($withLoading) :disabled="submitButtonDisabled" @endif
        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium
        text-center text-white bg-green-700 rounded-lg focus:ring-4
        dark:bg-green-600 hover:dark:bg-green-700
        focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-green-800"
        {{ $attributes }}
>

    @if($withLoading)
        <template x-if="submitButtonDisabled">
            <span class="flex gap-2">
                <x-icons.loading />
                Salvando...
            </span>
        </template>

        <template x-if="!submitButtonDisabled">
            <span>
                {{ $slot }}
            </span>
        </template>
    @else
        {{ $slot }}
    @endif
</button>
