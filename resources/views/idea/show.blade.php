<x-layout.layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between">
            <a href="{{ route('idea.index') }}" class="text-blue-500 hover:text-blue-700">
                &larr; Back to Ideas
            </a>

            <div class="flex items-center gap-x-3">
                <button class="btn btn-outlined">Edit Idea</button>

                <form action="{{ route('idea.destroy', $idea) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outlined text-red-500">Delete Idea</button>
                </form>
            </div>
        </div>

        <header>
            <h1 class="text-3xl font-bold">{{ $idea->title }}</h1>
            <p class="text-muted-background text-sm mt-2">Created {{ $idea->created_at->diffForHumans() }}</p>
        </header>

        <div class="mt-10">
            <x-idea.status-label status="{{ $idea->status }}">
                {{ $idea->status->label() }}
            </x-idea.status-label>

            <p class="mt-5">{{ $idea->description }}</p>
        </div>

        @if ($idea->links->count())
        <div>
            <h3 class="font-bold text-xl mt-6">Links</h3>

            <div class="mt-2 space-y-2">
                @foreach ($idea->links as $link)
                <x-card :href="$link" target="_blank" class="text-primary font-medium flex gap-x-3 items-center">
                    {{ $link }}
                </x-card>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layout.layout>