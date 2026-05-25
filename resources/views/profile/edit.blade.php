<x-layout.layout>
    <x-form.form title="Edit your account" desc="Need to make a tweak?">
        <form action="{{ route('profile.update') }}" method="POST" class="mb-10">
            @csrf
            @method('PATCH')

            <x-form.field name="name" label="Name" :value="$user->name" />
            <x-form.field name="email" label="Email" type="email" :value="$user->email" />
            <x-form.field name="password" label="New Password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full">Update Account</button>
        </form>
    </x-form.form>
</x-layout.layout>