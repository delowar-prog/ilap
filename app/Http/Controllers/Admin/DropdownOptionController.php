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

        $request->validate([
            'label'   => 'required|string|max:255',
            'type'    => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'image'   => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:10240',
        ]);

        // Check duplicate within category
        $exists = DropdownOption::where('category', $category)
            ->where('label', $request->label)
            ->exists();

        if ($exists) {
            return back()->withErrors(['label' => 'This option already exists in this category.'])->withInput();
        }

        $maxOrder = DropdownOption::where('category', $category)->max('sort_order') ?? -1;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('letter_heads', 'public');
        }

        DropdownOption::create([
            'category'   => $category,
            'label'      => $request->label,
            'type'       => $request->type,
            'country'    => $request->country,
            'website'    => $request->website,
            'image_path' => $imagePath,
            'sort_order' => $maxOrder + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', "Option \"{$request->label}\" added successfully.");
    }

    /** Update label or toggle active */
    public function update(Request $request, DropdownOption $dropdownOption)
    {
        $request->validate([
            'label'     => 'required|string|max:255',
            'type'      => 'nullable|string|max:255',
            'country'   => 'nullable|string|max:255',
            'website'   => 'nullable|url|max:255',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'label'     => $request->label,
            'type'      => $request->type,
            'country'   => $request->country,
            'website'   => $request->website,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            if ($dropdownOption->image_path && \Storage::disk('public')->exists($dropdownOption->image_path)) {
                \Storage::disk('public')->delete($dropdownOption->image_path);
            }
            $data['image_path'] = $request->file('image')->store('letter_heads', 'public');
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
