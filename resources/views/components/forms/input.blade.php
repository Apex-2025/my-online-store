@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'class' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 text-sm font-bold mb-2">
        {{ $label }}:
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline ' . $class]) }}>
    @error($name)
    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>
