<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::when(request()->q, function($products) {
            $products = $products->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        return Inertia::render('Apps/Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        //return inertia
        return Inertia::render('Apps/Products/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'barcode'       => 'required|unique:products',
            'title'         => 'required',
            'description'   => 'required',
            'category_id'   => 'required',
            'buy_price'     => 'required',
            'sell_price'    => 'required',
            'stock'         => 'required',
        ]);

        $image = $request->file("image");
        $image->storeAs("public/storage", $image->hashName());

        Product::create([
            'image'         => $image->hashName(),
            'barcode'       => $request->barcode,
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => $request->category_id,
            'buy_price'     => \delete_comma($request->buy_price),
            'sell_price'    => \delete_comma($request->sell_price),
            'stock'         => \delete_comma($request->stock),
        ]);

        return redirect()->route('apps.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return Inertia::render('Apps/Products/Edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'barcode'       => 'required|unique:products,barcode,'.$product->id,
            'title'         => 'required',
            'description'   => 'required',
            'category_id'   => 'required',
            'buy_price'     => 'required',
            'sell_price'    => 'required',
            'stock'         => 'required',
        ]);

        $values = [
            'barcode'       => $request->barcode,
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => $request->category_id,
            'buy_price'     => \delete_comma($request->buy_price),
            'sell_price'    => \delete_comma($request->sell_price),
            'stock'         => \delete_comma($request->stock),
        ];

        if ($request->hasFile("image")) {
            Storage::disk("local")->delete("public/products." . \basename($product->image));
            $image = $request->file("image");
            $image->storeAs("public/storage", $image->hashName());

            $values["image"] = $image->hashName();
        }

        $product->update($values);
        return redirect()->route('apps.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::disk("local")->delete("public/products." . \basename($product->image));
        $product->delete();
        return redirect()->route('apps.products.index');
    }
}
