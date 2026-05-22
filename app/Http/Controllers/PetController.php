<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class PetController extends Controller
{
    // ─────────────────────────────────────────────────────────────────
    //  INDEX — Admin: all pets with search/filter/pagination
    //          Adopter: available pets only (public gallery)
    // ─────────────────────────────────────────────────────────────────
    public function index(Request $request): View
    {
        $query = Pet::with('category');

        // Search by name, breed, or category name
        $query->search($request->input('search'));

        // Filter by category_id
        $query->category($request->input('category_id'));

        // Filter by gender
        $query->gender($request->input('gender'));

        // Admins can see all statuses (defaults to Available); adopters see only Available
        if (auth()->user()->isAdmin()) {
            $status = $request->has('status') ? $request->input('status') : 'Available';
            if ($status) {
                $query->status($status);
            }
        } else {
            $query->available();
        }

        $pets = $query->latest()->paginate(10)->withQueryString();

        // All categories for filter dropdown
        $categories = Category::all();

        return view('pets.index', compact('pets', 'categories'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  CREATE — Admin only (middleware enforced in routes)
    // ─────────────────────────────────────────────────────────────────
    public function create(): View
    {
        $categories = Category::all();
        return view('pets.create', compact('categories'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  STORE — Validate, upload image, persist
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse
    {
        // Check for PHP-level upload errors before Laravel validation
        if ($request->hasFile('image')) {
            $uploadError = $request->file('image')->getError();
            if ($uploadError !== UPLOAD_ERR_OK) {
                $phpErrors = [
                    UPLOAD_ERR_INI_SIZE   => 'The image exceeds the server upload limit. Please use a smaller file.',
                    UPLOAD_ERR_FORM_SIZE  => 'The image exceeds the form upload limit.',
                    UPLOAD_ERR_PARTIAL    => 'The image was only partially uploaded. Please try again.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder for the upload.',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write the uploaded file to disk.',
                    UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
                ];
                return back()->withErrors([
                    'image' => $phpErrors[$uploadError] ?? 'Unknown upload error (code ' . $uploadError . ').',
                ])->withInput();
            }
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'breed'         => 'required|string|max:100',
            'age'           => 'required|integer|min:0|max:99',
            'gender'        => 'required|in:Male,Female',
            'health_status' => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:Available,Adopted,Archived',
            'image'         => ['nullable', 'file', 'max:10240', 'mimes:jpeg,png,jpg,gif,webp', 'image'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('pets', 'public');
        }

        Pet::create($validated);

        return redirect()->route('pets.index')
            ->with('success', 'Pet created successfully!');
    }

    // ─────────────────────────────────────────────────────────────────
    //  SHOW — Anyone authenticated can view details
    // ─────────────────────────────────────────────────────────────────
    public function show(Pet $pet): View
    {
        // Adopters may only view Available pets
        if (auth()->user()->isAdopter() && $pet->status !== 'Available') {
            abort(403, 'This pet is not available for viewing.');
        }

        return view('pets.show', compact('pet'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  EDIT — Admin only
    // ─────────────────────────────────────────────────────────────────
    public function edit(Pet $pet): View
    {
        if ($pet->status === 'Adopted') {
            abort(403, 'Adopted pets cannot be edited.');
        }

        $categories = Category::all();
        return view('pets.edit', compact('pet', 'categories'));
    }

    // ─────────────────────────────────────────────────────────────────
    //  UPDATE — Validate, swap image if new one uploaded
    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        if ($pet->status === 'Adopted') {
            abort(403, 'Adopted pets cannot be edited.');
        }

        // Check for PHP-level upload errors before Laravel validation
        if ($request->hasFile('image')) {
            $uploadError = $request->file('image')->getError();
            if ($uploadError !== UPLOAD_ERR_OK) {
                $phpErrors = [
                    UPLOAD_ERR_INI_SIZE   => 'The image exceeds the server upload limit. Please use a smaller file.',
                    UPLOAD_ERR_FORM_SIZE  => 'The image exceeds the form upload limit.',
                    UPLOAD_ERR_PARTIAL    => 'The image was only partially uploaded. Please try again.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder for the upload.',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write the uploaded file to disk.',
                    UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
                ];
                return back()->withErrors([
                    'image' => $phpErrors[$uploadError] ?? 'Unknown upload error (code ' . $uploadError . ').',
                ])->withInput();
            }
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'breed'         => 'required|string|max:100',
            'age'           => 'required|integer|min:0|max:99',
            'gender'        => 'required|in:Male,Female',
            'health_status' => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:Available,Adopted,Archived',
            'image'         => ['nullable', 'file', 'max:10240', 'mimes:jpeg,png,jpg,gif,webp', 'image'],
        ]);

        // Replace old image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image from storage
            if ($pet->image) {
                Storage::disk('public')->delete($pet->image);
            }
            $validated['image'] = $request->file('image')
                ->store('pets', 'public');
        } else {
            // Keep existing image path
            unset($validated['image']);
        }

        $pet->update($validated);

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully!');
    }

    // ─────────────────────────────────────────────────────────────────
    //  DESTROY — Admin only; delete image from disk too
    // ─────────────────────────────────────────────────────────────────
    public function destroy(Pet $pet): RedirectResponse
    {
        // Remove image from storage if present
        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet deleted successfully!');
    }

    // ─────────────────────────────────────────────────────────────────
    //  ARCHIVE — Admin only; soft-mark pet as Archived
    // ─────────────────────────────────────────────────────────────────
    public function archive(Pet $pet): RedirectResponse
    {
        $pet->update(['status' => 'Archived']);

        return redirect()->route('pets.index')
            ->with('success', 'Pet archived successfully!');
    }
}
