<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category', 'subcategory')
            ->paginate(10);

        $categories = Category::select('id', 'title')
            ->get();

        $subcategories = Subcategory::select('id', 'title')
            ->get();
      
        return view('index',compact('products', 'categories', 'subcategories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:50',
                'description' => 'required|max:255',
                'category' => 'required',
                'subcategory_id' => 'required|integer',
                'price' => 'required',
            ]);
            
            $createProduct = Product::create($request->except(['category']));

            return redirect()->route('products.index')
                ->with('success','Product created successfully!');

            // return response()->json([ 
            //     'status' => true, 
            //     'product' => $createProduct 
            // ], 200);

        } catch(Exception $exception) {
            return redirect()->route('products.index')
                ->with('error','Failed to create Product!');
            // return response()->json([
            //     'status' => false,
            //     'error' => $exception->getMessage() 
            // ], 500);
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
       
        return redirect()->route('products.index')
            ->with('success','Product deleted successfully!');
    }
}
