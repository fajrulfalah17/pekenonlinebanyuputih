<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with(['galleries'])->paginate(16);

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail(); //saat kategori memang ada data di munculin, saat ga ada akan keluar error
        $products = Product::with(['galleries'])
                    ->where('categories_id', $category->id)
                    ->paginate(16);

        return view('pages.category', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
} 