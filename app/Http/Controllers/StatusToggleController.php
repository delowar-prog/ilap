<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatusToggleController extends Controller
{
    /**
     * Map of supported model keys to Eloquent Model class names.
     */
    private array $allowedModels = [
        'user'            => \App\Models\User::class,
        'country'         => \App\Models\Country::class,
        'state'           => \App\Models\State::class,
        'city'            => \App\Models\City::class,
        'campus'          => \App\Models\Campus::class,
        'course'          => \App\Models\Course::class,
        'institute'       => \App\Models\Institute::class,
        'agent'           => \App\Models\Agent::class,
        'letter_template' => \App\Models\LetterTemplate::class,
        'dropdown_option' => \App\Models\DropdownOption::class,
        'official_signature' => \App\Models\OfficialSignature::class,
    ];

    /**
     * Universal toggle endpoint.
     */
    public function toggle(Request $request, string $modelType, $id)
    {
        $modelKey = Str::lower($modelType);

        if (!array_key_exists($modelKey, $this->allowedModels)) {
            return response()->json(['success' => false, 'message' => 'Invalid model type.'], 400);
        }

        $modelClass = $this->allowedModels[$modelKey];
        $record = $modelClass::findOrFail($id);

        if (isset($record->status)) {
            if ($record->status === 'active' || $record->status === 'inactive') {
                $record->status = ($record->status === 'active') ? 'inactive' : 'active';
            } else {
                $record->status = $record->status ? 0 : 1;
            }
        } elseif (isset($record->is_active)) {
            $record->is_active = !$record->is_active;
        }

        $record->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}
