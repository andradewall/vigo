@props([
    'action',
    'post' => null,
    'patch' => null,
    'put' => null,
    'delete' => null,
    'get' => null,
    'withLoading' => null,
])

<form
        action="{{ $action }}"
        method="POST"
        @if($withLoading) x-data="{ submitButtonDisabled: false }" @endif
        @if($withLoading) @submit="submitButtonDisabled = true" @endif
        {{ $attributes }}
>
    @csrf

    @if ($get)
        @method('GET')
    @endif

    @if ($put)
        @method('PUT')
    @endif

    @if ($patch)
        @method('PATCH')
    @endif

    @if ($delete)
        @method('DELETE')
    @endif

    {{ $slot }}
</form>
