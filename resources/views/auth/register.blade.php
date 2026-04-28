<x-layout.layout>
    <x-form.form title="Register an account" desc="Start tracking your ideas today">
        <form action="{{ route('register') }}" method="POST" class="mb-10">
            @csrf

            <x-form.field name="name" label="Name" />
            <x-form.field name="email" label="Email" type="email" />
            <x-form.field name="password" label="Password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full">Create Account</button>
        </form>
    </x-form.form>
</x-layout.layout>