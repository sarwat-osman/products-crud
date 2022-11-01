@extends('layouts.app')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title">
                <h2>Products Listing</h2>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card list_card">
        <div class="card-body">
            <div class="card-header">
                <a class="btn btn-primary" id="create_prod_btn" href="{{ route('products.create') }}"> + Create Product</a>
                
                <form id="search_form">
                    @csrf
                    <input type="text" name="title" placeholder="Product Title"></input>
                    <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
                </form>

                <br/>

                <form id="filter_form">
                    @csrf
                    <select class="filter_form_fields" id="filter_by_cat" name="category_id">
                        <option value="">
                            Category
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    <select class="filter_form_fields" id="filter_by_subcat" name="subcategory_id">
                        <option value="">
                            Subcategory
                        </option>
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">
                                {{ $subcategory->title }}
                            </option>
                        @endforeach
                    </select>
                    Price Range:
                    <input class="filter_form_fields" type="number" min="0.00" name="min_price" placeholder="Min"></input> to
                    <input class="filter_form_fields" type="number" min="0.00" name="max_price" placeholder="Max"></input>
                    <button class="btn btn-secondary" type="submit">Filter</button>
                </form>
            </div>

            <table id="products_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Price (BDT)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->title }}</td>
                        <td>{{ $product->subcategory->title }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                  
                                <button type="submit" class="btn btn-danger del_prod_btn" data-id="{{$product->id}}">X</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
  
    {!! $products->links() !!}

    <!-- create product modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading">Add New Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Failed to Create Product! Try Again.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="product_create_form" action="{{ route('products.store') }}" method="POST">

                        @csrf
                      
                         <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <textarea class="form-control" name="description" placeholder="Description" required></textarea>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Category:</strong>
                                    <select class="form-control" name="category" placeholder="Category" required>
                                        <option value="">
                                            Select Category
                                        </option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Subcategory:</strong>
                                    <select class="form-control" name="subcategory_id" placeholder="Subcategory" required>
                                        <option value="">
                                            Select Subcategory
                                        </option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">
                                                {{ $subcategory->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Price:</strong>
                                    <input type="number" min="0.00" max="99999999.99" step="0.01" class="form-control" name="price" placeholder="Price" required></input>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button id="create_product_submit" type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
      
@endsection



