@props(['name'])

@error($name)
<p id="{{ $name }}-error" class="error" role="alert">{{ $message }}</p>
@enderror