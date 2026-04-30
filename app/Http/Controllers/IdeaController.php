<?php

namespace App\Http\Controllers;

use App\IdeaStatus;
use App\Models\Idea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        Auth::user()->ideas()->create($request->validated());

        return to_route('idea.index')
            ->with('success', 'Idea created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        if ($idea->user_id !== Auth::id()) {
            abort(403);
        }

        return view("idea.show", [
            'idea' => $idea
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        if ($idea->user_id !== Auth::id()) {
            abort(403);
        }

        $idea->delete();

        return to_route('idea.index')
            ->with('success', 'Idea deleted successfully.');
    }
}
