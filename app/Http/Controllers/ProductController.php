<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request){
        // $products = Product::all();
        $query = Product::query();
        if(request()->has("search") && $request->search){
            $query = $query->where("name","like","%".$request->search."%")
                        ->orWhere('description','like',"%".$request->search."%");
        }
        $products = $query->latest()->paginate(8);

        return view("product.product-list",compact("products"));
    } 

    public function create(){
        $categories = Category::all();
        return view("product.create",compact("categories"));
    }

    public function store(Request $request){
        $validated = $request->validate([
            "name"=> "required|string",
            "description"=> "nullable|string",
            "price"=> "required|numeric",
            "quantity"=> "required|numeric",
            "status"=> "required",
            "category_id"=> "required",
            "image"=> "nullable|image|mimes:jpg,png",

            ]);
            if ($request->hasFile("image")) {
                $validated["image"] = $request->file("image")->store("products","public");
            }
            Product::create($validated);

            return redirect()->route("product.index")->with("success","product added successfully");
        }
}