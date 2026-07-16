<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->has("search") && $request->search) {
            $query = $query->where("name", "like", "%" . $request->search . "%");
        }
        $categories = $query->withCount('products')->latest()->paginate(8);

        return view("category.category-list", compact("categories"));
    }

    public function create()
    {
        return view("category.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|unique:categories,name",
            "status" => "required",
        ]);

        Category::create($validated);

        return redirect()->route("category.index")->with("success", "category added successfully");
    }

    public function show($id)
    {
        $category = Category::withCount('products')->findOrFail($id);
        return view("category.show", compact("category"));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view("category.edit", compact("category", "id"));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "required|string|unique:categories,name," . $id,
            "status" => "required",
        ]);

        Category::findOrFail($id)->update($validated);

        return redirect()->route("category.index")->with("success", "category updated successfully!");
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            return redirect()->route("category.index")->with("error", "category cannot be deleted, it still has products!");
        }

        $category->delete();
        return redirect()->route("category.index")->with("success", "category deleted successfully!");
    }

    public function trashedCategories(Request $request)
    {
        $query = Category::query()->onlyTrashed();
        if ($request->has("search") && $request->search) {
            $query = $query->where("name", "like", "%" . $request->search . "%");
        }
        $categories = $query->paginate(5);
        return view("category.deleted-categories", compact("categories"));
    }

    public function showTrashed($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        return view("category.show", compact("category"));
    }

    public function restoreCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route("category.index")->with("success", "category restored successfully");
    }

    public function destroyCategory($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route("category.index")->with("success", "category was force deleted successfully!");
    }
}
