<x-layout.layout>
    <x-form.form title="Log In" desc="Glad to have you back">
        <form action="{{ route('login') }}" method="POST" class="mb-10">
            @csrf

            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full">Sign In</button>
        </form>
    </x-form.form>
</x-layout.layout>