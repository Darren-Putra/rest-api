<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $product = Product::latest()->paginate(10);
        return response()->json(new ProductCollection($product), Response::HTTP_OK);

        // return new ProductCollection($product);
    }

    public function store(ProductRequest $request){
        $product = Product::create($request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Product berhasil ditambahkan',
            'data' => new ProductResource($product),
        ], Response::HTTP_CREATED);
    }
    public function show(){

    }
    public function update(){

    }
    public function destroy(){

    }
}
