<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of book categories.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Category::withCount('books');

        if (! empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('name')->get();
        $totalCategories = Category::count();

        return view('admin.categories.index', compact('categories', 'totalCategories', 'search'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'icon' => $validated['icon'] ?: 'book-open',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "'.$category->name.'" berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:categories,name,'.$category->id],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'icon' => $validated['icon'] ?: ($category->icon ?: 'book-open'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "'.$category->name.'" berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki '.$category->books()->count().' buku terhubung.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "'.$name.'" berhasil dihapus.');
    }
}
