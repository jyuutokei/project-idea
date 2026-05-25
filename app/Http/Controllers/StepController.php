<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\IdeaStep;

class StepController extends Controller
{
    public function update(IdeaStep $step)
    {
        //authorization

        $step->update(['completed' => !$step->completed]);

        return response()->json(['completed' => $step->completed]);
    }
}
