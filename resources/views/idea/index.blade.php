<x-layout.layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-background text-sm mt-2">Capture your thoughts. Make a plan</p>

            <x-card x-data @click="$dispatch('open-modal', 'create-idea-modal')" is="button" type="button"
                class="mt-10 cursor-pointer h-32 w-full text-left">
                <p>What's the idea?</p>
            </x-card>
        </header>

        <div x-data="{ open: false }" class="relative">
            <button class="bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 rounded-md"
                @click="open = !open">
                Filter
            </button>

            <div x-show="open" x-transition:enter="ease-out duration-300 origin-top-left"
                x-transition:enter-start="opacity-0 scale-95" x-transition:leave="ease-in duration-300 origin-top-left"
                x-transition:leave-end="opacity-0 scale-90" class="absolute left-0 ml-20 -mt-9" style="display: none">
                @foreach (App\IdeaStatus::cases() as $status)
                <x-idea.filter-btn status="{{ $status->value }}" count="{{ $statusCount[$status->value] ?? 0 }}" />
                @endforeach
                <a href="/ideas" class="btn bg-gray-500/10 text-gray-500 border-gray-500/20">No Filter</a>
            </div>
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>
                    <div class="mt-1">
                        <x-idea.status-label status="{{ $idea->status }}">
                            {{ $idea->status->label() }}
                        </x-idea.status-label>
                    </div>
                    <p class="mt-5 line-clamp-3">{{ $idea->description }}</p>
                    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                </x-card>
                @empty
                <x-card>
                    <p>No ideas at this time.</p>
                </x-card>
                @endforelse
            </div>
        </div>
        <x-modal name="create-idea-modal" title="New Idea">
            <form x-data="{ status: 'pending' }" action="{{ route('idea.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <x-form.field label="Title" name="title" placeholder="What is your idea title?" autofocus
                        required />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>

                        <div class="flex gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                            <button type="button" @click="status = @js($status->value)" class="btn flex-1 h-10"
                                :class="{ 'btn-outlined': status !== @js($status->value) }">{{ $status->label() }}</button>
                            @endforeach
                        </div>

                        <input type="hidden" name="status" id="status" :value="status">
                        <x-form.error name="status" />
                    </div>

                    <x-form.field label="Description" name="description" type="textarea"
                        placeholder="Describe your idea." />

                    <div class="flex justify-end gap-x-5">
                        <button type="button" class="btn btn-outlined" @click="show = false">Cancel</button>
                        <button type="submit" class="btn">Create</button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-layout.layout>