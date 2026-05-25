@props(['idea' => new App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea-modal' : 'create-idea-modal' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form
        x-data="{ status: @js(old('status', $idea->status->value)), newLink: '', links: @js(old('links', $idea->links ?? [])), newStep: '', steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))) }"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @if ($idea->exists)
        @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-form.field label="Title" name="title" placeholder="What is your idea title?" :value="$idea->title"
                autofocus required />

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

            <x-form.field label="Description" name="description" type="textarea" placeholder="Describe your idea."
                :value="$idea->description" />

            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                @if ($idea->image_path)
                <div class="space-y-2">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt=""
                        class="w-full h-auto object-cover rounded-lg">

                    <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                </div>
                @endif

                <input type="file" name="image" accept="image/">
                <x-form.error name="image" />
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input :name="`steps[${index}][description]`" x-model="step.description"
                                class="input w-full" readonly>
                            <input type="hidden" :name="`steps[${index}][completed]`"
                                x-model="step.completed ? '1' : '0'" class="input w-full" readonly>

                            <button type="button" @click="steps.splice(index, 1)">
                                <x-icons.x />
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input x-model="newStep" id="new-step" spellcheck="false" placeholder="What needs to be done?"
                            class="input flex-1">
                        <button type="button"
                            @click="steps.push({ description: newStep, completed: false }); newStep = ''; "
                            :disabled="!newStep.trim()">+</button>
                    </div>
                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links" :key="link">
                        <div class="flex gap-x-2 items-center">
                            <input name="links[]" x-model="links[index]" class="input w-full" readonly>

                            <button type="button" @click="links.splice(index, 1)">
                                <x-icons.x />
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input x-model="newLink" type="url" id="new-link" autocomplete="url" spellcheck="false"
                            placeholder="https://example.com" class="input flex-1">
                        <button type="button" @click="links.push(newLink.trim()); newLink = ''; "
                            :disabled="!newLink.trim()">+</button>
                    </div>
                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" class="btn btn-outlined" @click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>

    @if ($idea->image_path)
    <form id="delete-image-form" action="{{ route('idea.image.destroy', $idea) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
    @endif
</x-modal>