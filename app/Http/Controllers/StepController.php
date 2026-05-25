<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\IdeaStep;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function update(IdeaStep $step)
    {
        //authorization

        $step->update(['completed' => !$step->completed]);

        return back();
    }
}
