<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\IdeaStatus;
use App\Models\Idea;
use App\Http\Requests\IdeaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $status = $request->status;

        if (!in_array($status, array_column(IdeaStatus::cases(), 'value'))) {
            $status = null;
        }

        $ideas = $user
            ->ideas()
            ->when($status, fn($query, $status) => $query->where('status', $status))
            ->latest()
            ->get();

        $statusCount = $user
            ->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view("idea.index", [
            'ideas' => $ideas,
            'statusCount' => $statusCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request, CreateIdea $actions)
    {
        // $idea = Auth::user()->ideas()->create($request->safe()->except(['steps', 'image']));

        // $idea->steps()->createMany(
        //     collect($request->steps)->map(fn($step) => ['description' => $step])
        // );

        // $imagePath = $request->image->store('ideas', 'public');

        // $idea->update([
        //     'image_path' => $imagePath
        // ]);

        $actions->handle($request->safe()->all());

        return to_route('idea.index')
            ->with('success', 'Idea created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view("idea.show", [
            'idea' => $idea
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea, UpdateIdea $action)
    {
        Gate::authorize('workWith', $idea);

        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'Idea updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return to_route('idea.index')
            ->with('success', 'Idea deleted successfully.');
    }
}
