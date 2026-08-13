<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DropdownOption;
use Illuminate\Http\Request;

class DropdownOptionController extends Controller
{
    /** List all categories */
    public function index()
    {
        $categories = DropdownOption::$categories;

        // Count per category
        $counts = [];
        foreach (array_keys($categories) as $cat) {
            $counts[$cat] = DropdownOption::where('category', $cat)->count();
        }

        return view('backend.config.dropdown_options.index', compact('categories', 'counts'));
    }

    /** List/manage options for a specific category */
    public function category(string $category)
    {
        abort_unless(array_key_exists($category, DropdownOption::$categories), 404);

        $categoryName = DropdownOption::$categories[$category];
        $options = DropdownOption::forCategory($category);
        $templateTypes = DropdownOption::whereIn('category', ['letter_type', 'invoice_type'])->where('is_active', true)->pluck('label')->unique()->values();

        return view('backend.config.dropdown_options.category', compact('category', 'categoryName', 'options', 'templateTypes'));
    }

    /** Store a new option */
    public function store(Request $request, string $category)
    {
        abort_unless(array_key_exists($category, DropdownOption::$categories), 404);

        $rules = [
            'type'          => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'website'       => 'nullable|url|max:255',
            'image'         => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:10240',
            'margin_top'    => 'nullable|numeric|min:0|max:500',
            'margin_bottom' => 'nullable|numeric|min:0|max:500',
            'margin_left'   => 'nullable|numeric|min:0|max:500',
            'margin_right'  => 'nullable|numeric|min:0|max:500',
        ];

        if (is_array($request->label)) {
            $rules['label'] = 'required|array|min:1';
            $rules['label.*'] = 'required|string|max:255';
        } else {
            $rules['label'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $labels = is_array($request->label) ? $request->label : [$request->label];
        $maxOrder = DropdownOption::where('category', $category)->max('sort_order') ?? -1;

        $imagePath = null;
        $marginTop = $request->filled('margin_top') ? (int) $request->margin_top : null;
        $marginBottom = $request->filled('margin_bottom') ? (int) $request->margin_bottom : null;
        $marginLeft = $request->filled('margin_left') ? (int) $request->margin_left : 0;
        $marginRight = $request->filled('margin_right') ? (int) $request->margin_right : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('letter_heads', 'public');
            
            // Auto detect top/bottom margins if not provided by admin
            if ($category === 'letter_head' && ($marginTop === null || $marginBottom === null)) {
                $detected = DropdownOption::autoDetectPadMargins(storage_path('app/public/' . $imagePath));
                if ($marginTop === null) $marginTop = $detected['margin_top'];
                if ($marginBottom === null) $marginBottom = $detected['margin_bottom'];
            }
        }

        $addedCount = 0;
        foreach ($labels as $label) {
            // Check duplicate within category
            $exists = DropdownOption::where('category', $category)
                ->where('label', $label)
                ->exists();

            if ($exists) {
                continue; // Skip existing
            }

            DropdownOption::create([
                'category'      => $category,
                'label'         => $label,
                'type'          => $request->type,
                'country'       => $request->country,
                'website'       => $request->website,
                'image_path'    => $imagePath,
                'margin_top'    => $marginTop ?? 130,
                'margin_bottom' => $marginBottom ?? 120,
                'margin_left'   => $marginLeft,
                'margin_right'  => $marginRight,
                'sort_order'    => ++$maxOrder,
                'is_active'     => true,
            ]);
            $addedCount++;
        }

        if ($addedCount === 0 && count($labels) === 1) {
            return back()->withErrors(['label' => 'This option already exists in this category.'])->withInput();
        }

        $msg = is_array($request->label) ? "$addedCount option(s) added successfully." : "Option \"{$labels[0]}\" added successfully.";
        return back()->with('success', $msg);
    }

    /** Update label or toggle active */
    public function update(Request $request, DropdownOption $dropdownOption)
    {
        $request->validate([
            'label'         => 'required|string|max:255',
            'type'          => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'website'       => 'nullable|url|max:255',
            'image'         => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:10240',
            'margin_top'    => 'nullable|numeric|min:0|max:500',
            'margin_bottom' => 'nullable|numeric|min:0|max:500',
            'margin_left'   => 'nullable|numeric|min:0|max:500',
            'margin_right'  => 'nullable|numeric|min:0|max:500',
            'is_active'     => 'nullable|boolean',
        ]);

        $data = [
            'label'         => $request->label,
            'type'          => $request->type,
            'country'       => $request->country,
            'website'       => $request->website,
            'margin_top'    => $request->filled('margin_top') ? (int) $request->margin_top : ($dropdownOption->margin_top ?? 130),
            'margin_bottom' => $request->filled('margin_bottom') ? (int) $request->margin_bottom : ($dropdownOption->margin_bottom ?? 120),
            'margin_left'   => $request->filled('margin_left') ? (int) $request->margin_left : ($dropdownOption->margin_left ?? 0),
            'margin_right'  => $request->filled('margin_right') ? (int) $request->margin_right : ($dropdownOption->margin_right ?? 0),
            'is_active'     => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            if ($dropdownOption->image_path && \Storage::disk('public')->exists($dropdownOption->image_path)) {
                \Storage::disk('public')->delete($dropdownOption->image_path);
            }
            $data['image_path'] = $request->file('image')->store('letter_heads', 'public');

            if ($dropdownOption->category === 'letter_head' && (!$request->filled('margin_top') || !$request->filled('margin_bottom'))) {
                $detected = DropdownOption::autoDetectPadMargins(storage_path('app/public/' . $data['image_path']));
                if (!$request->filled('margin_top')) $data['margin_top'] = $detected['margin_top'];
                if (!$request->filled('margin_bottom')) $data['margin_bottom'] = $detected['margin_bottom'];
            }
        }

        $dropdownOption->update($data);

        return back()->with('success', 'Option updated successfully.');
    }

    /** Toggle active/inactive */
    public function toggle(DropdownOption $dropdownOption)
    {
        $dropdownOption->update(['is_active' => !$dropdownOption->is_active]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success'   => true,
                'is_active' => (bool) $dropdownOption->is_active,
                'message'   => 'Status updated successfully.'
            ]);
        }

        $state = $dropdownOption->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "Option \"{$dropdownOption->label}\" has been {$state}.");
    }

    /** Delete an option */
    public function destroy(DropdownOption $dropdownOption)
    {
        $label = $dropdownOption->label;
        $category = $dropdownOption->category;
        $dropdownOption->delete();

        return back()->with('success', "Option \"{$label}\" deleted successfully.");
    }

    /** Update sort order (AJAX) */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $sortOrder => $id) {
            DropdownOption::where('id', $id)->update(['sort_order' => $sortOrder]);
        }

        return response()->json(['success' => true]);
    }
}
