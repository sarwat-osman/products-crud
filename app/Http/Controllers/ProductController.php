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
        try {
            $products = Product::with('category', 'subcategory')
                ->paginate(10);

            $categories = Category::select('id', 'title')
                ->get();

            $subcategories = Subcategory::select('id', 'title')
                ->get();
          
            return view('index',compact('products', 'categories', 'subcategories'))
                ->with('i', (request()->input('page', 1) - 1) * 5);

        } catch(Exception $exception) {
            return view('index', ['error'=>'Failed to create Product!']);
        }      
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
        try {
            $product->delete();
           
            return redirect()->route('products.index')
                ->with('success','Product deleted successfully!');
        } catch(Exception $exception) {
            return redirect()->route('products.index')
                ->with('error','Failed to create Product!');
        }      
    }

    public function getSubcategories(Request $request)
    {
        try {
            $subcategories = Subcategory::where('category_id', $request->category_id)
                ->get();

            return response()->json([
                "status" => true,
                "data" => $subcategories
            ]);
        } catch(Exception $exception) {
            return response()->json([
                "status" => false,
                "error" => $exception->getMessage()
            ]);
        }    
    }

    public function filter(Request $request)
    {
        try {
            if($request->filled('category_id')) {
                if($request->filled('subcategory_id')) {
                    $filteredProducts = Product::where('subcategory_id', $request->subcategory_id)
                        ->get();
                }
                else {                    
                    $category = Category::where('id', $request->category_id)
                        ->first();
                    $filteredProducts = $category->products;
                }
            }

            if($request->filled('min_price') && $request->filled('max_price')) {
                $filteredProducts = $filteredProducts->where('price', '>=', $request->min_price)
                    ->where('price', '<=', $request->max_price)
                    ->all();
            }

            $tbodyHtml = "";
            foreach ($filteredProducts as $product) {
                $rowHtml = '<tr>
                                <td>' . $product->id . '</td>
                                <td>' . $product->title . '</td>
                                <td>' . $product->description . '</td>
                                <td>' . $product->category->title . '</td>
                                <td>' . $product->subcategory->title . '</td>
                                <td>' . $product->price . '</td>
                                <td>
                                    <form action="{{ route(\'products.destroy\',$product->id) }}" method="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          
                                        <button type="submit" class="btn btn-danger del_prod_btn" data-id="{{$product->id}}">X</button>
                                    </form>
                                </td>
                            </tr>';
                $tbodyHtml = $tbodyHtml . $rowHtml;
            }

            // return view('index')
            //     ->with('success','Product created successfully!');
            return response()->json([
                "status" => true,
                "data" => $tbodyHtml
            ]);
        } catch(Exception $exception) {
            return response()->json([
                "status" => false,
                "error" => $exception->getMessage()
            ]);
        }    
    }

    public function search(Request $request)
    {
        try {
            $searchedProducts = Product::where('title', 'LIKE','%'.$request->title.'%')
                ->get();

            $tbodyHtml = "";
            foreach ($searchedProducts as $product) {
                $rowHtml = '<tr>
                                <td>' . $product->id . '</td>
                                <td>' . $product->title . '</td>
                                <td>' . $product->description . '</td>
                                <td>' . $product->category->title . '</td>
                                <td>' . $product->subcategory->title . '</td>
                                <td>' . $product->price . '</td>
                                <td>
                                    <form action="{{ route(\'products.destroy\',$product->id) }}" method="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          
                                        <button type="submit" class="btn btn-danger del_prod_btn" data-id="{{$product->id}}">X</button>
                                    </form>
                                </td>
                            </tr>';
                $tbodyHtml = $tbodyHtml . $rowHtml;
            }

            return response()->json([
                "status" => true,
                "data" => $tbodyHtml
            ]);
        } catch(Exception $exception) {
            return response()->json([
                "status" => false,
                "error" => $exception->getMessage()
            ]);
        }    
    }
}
