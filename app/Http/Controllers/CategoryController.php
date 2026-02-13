<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request){

    $query = Category::withCount('articles');

    if($request->filled('search')){
       $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
    }

     $categories = $query->latest()->paginate(12)->withQueryString();



     // Calculate stats
        $totalCategories = Category::count();
        $activeCategories = Category::has('articles')->count();
        $emptyCategories = Category::doesntHave('articles')->count();
        $totalArticles = \App\Models\Article::count();
     return view('admin.categories.index', compact(
            'categories',
            'totalCategories',
            'activeCategories',
            'emptyCategories',
            'totalArticles'
        ));
    
    }


      public function create()
    {
        return view('admin.categories.create');
    }





    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ], [
            'name.required' => 'Please enter a category name.',
            'name.unique' => 'This category name already exists.',
            'slug.unique' => 'This slug is already in use.',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default icon if not provided
        if (empty($validated['icon'])) {
            $validated['icon'] = 'fas fa-folder';
        }

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = '#f97316'; // Orange
        }

        $category = Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' has been created successfully!");
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $category->load(['articles' => function($query) {
            $query->latest()->take(10);
        }]);

        $stats = [
            'total_articles' => $category->articles()->count(),
            'published_articles' => $category->articles()->where('status', 'published')->count(),
            'draft_articles' => $category->articles()->where('status', 'draft')->count(),
            'total_views' => $category->articles()->sum('views_count'),
        ];

        return view('admin.categories.show', compact('category', 'stats'));
    }

    /**
     * Show the form for editing the category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ], [
            'name.required' => 'Please enter a category name.',
            'name.unique' => 'This category name already exists.',
            'slug.unique' => 'This slug is already in use.',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$category->name}' has been updated successfully!");
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has articles
        $articleCount = $category->articles()->count();
        
        if ($articleCount > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Cannot delete '{$category->name}' because it has {$articleCount} article(s). Please reassign or delete the articles first.");
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$categoryName}' has been deleted successfully!");
    }


}
