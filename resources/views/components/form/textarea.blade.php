@props([
    'name',
    'id',
    'label',
    'required' => false,
    'readonly' => false,
    'value' => false,
    'hint' => false,
])
<div>
    <label for="{{ $id }}"
           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }} @if($required)<span class="text-red-600 dark:text-red-400">*</span>@endif
    </label>
    <textarea id="{{ $id }}"
           name="{{ $name }}"
           @if($readonly) readonly @endif
           @if($required) required @endif
            {{ $attributes }}
            {{ $attributes->merge(["class" => "bg-gray-50 read-only:bg-gray-200 border border-gray-300 text-gray-900
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
            dark:focus:border-blue-500"]) }}
    >{{ old($name) ?? $value }}</textarea>
    @if($hint)
        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $hint }}
        </p>
    @endif
    @error($name)
    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">
        {{ $errors->first($name) }}
    </p>
    @enderror
</div>