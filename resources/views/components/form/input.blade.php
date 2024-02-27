@props([
    'type',
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
          class="block mb-2 text-sm font-medium text-gray-900">
        {{ $label }} @if ($required)<span class="text-red-600">*</span> @endif
    </label>
    <input type="{{ $type }}"
           id="{{ $id }}"
           name="{{ $name }}"
           value="{{ old($name) ?? $value }}"
           @if($readonly) readonly @endif
           @if($required) required @endif
            {{ $attributes->merge(["class" => "bg-gray-50 read-only:bg-gray-200 border border-gray-300 text-gray-900
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"]) }}
            {{ $attributes }}
    />
    @if($hint)
        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500">
            {{ $hint }}
        </p>
    @endif
    @error($name)
    <p class="mt-2 text-sm text-red-600"><span class="font-medium">
        {{ $errors->first($name) }}
    </p>
    @enderror
</div>
