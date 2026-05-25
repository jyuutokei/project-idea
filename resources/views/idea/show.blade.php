<x-layout.layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between">
            <a href="{{ route('idea.index') }}" class="text-blue-500 hover:text-blue-700">
                &larr; Back to Ideas
            </a>

            <div class="flex items-center gap-x-3">
                <button x-data class="btn btn-outlined" @click="$dispatch('open-modal', 'edit-idea-modal')">Edit
                    Idea</button>

                <form action="{{ route('idea.destroy', $idea) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outlined text-red-500">Delete Idea</button>
                </form>
            </div>
        </div>

        <header>
            {{-- have to remember to create symbolic link for uploaded image to be available in public folder --}}
            @if ($idea->image_path)
            <div class="rounded-lg overflow-hidden mb-5">
                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="" class="w-full h-auto object-cover">
            </div>
            @endif
            <h1 class="text-3xl font-bold">{{ $idea->title }}</h1>
            <p class="text-muted-background text-sm mt-2">Created {{ $idea->created_at->diffForHumans() }}</p>
        </header>

        <div class="mt-10">
            <x-idea.status-label status="{{ $idea->status }}">
                {{ $idea->status->label() }}
            </x-idea.status-label>

            <p class="mt-5 prose prose-inverted">{!! $idea->formattedDescription !!}</p>
        </div>

        @if ($idea->steps->count())
        <div>
            <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>

            <div class="mt-2 space-y-2">
                @foreach ($idea->steps as $step)
                <x-card class="text-primary font-medium flex gap-x-3 items-center">
                    <form action="{{ route('step.update', $step) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-center gap-x-3">
                            <button type="submit" role="checkbox"
                                class="size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                            <span
                                class="{{ $step->completed ? 'line-through text-muted-foreground' : '' }}">{{ $step->description }}</span>
                        </div>
                    </form>
                </x-card>
                @endforeach
            </div>
        </div>
        @endif

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

        <x-idea.modal :idea="$idea" />
    </div>
</x-layout.layout>