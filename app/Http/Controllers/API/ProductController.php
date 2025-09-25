<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // ==============================
    // 🔹 Umum (SEMUA ROLE)
    // ==============================
    public function index()
    {
        $products = Product::with('user')->latest()->paginate(10);
        return response()->json(new ProductCollection($products), Response::HTTP_OK);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()] // simpan owner produk
        ));

        return response()->json([
            'status' => true,
            'message' => 'Product berhasil ditambahkan',
            'data' => new ProductResource($product->load('user')),
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Detail Product',
            'data' => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Product berhasil di update',
            'data' => new ProductResource($product->load('user')),
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product berhasil di hapus',
            'data' => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    // ==============================
    // 🔹 Seller Only
    // ==============================
    public function sellerProducts()
    {
        $products = Product::with('user')
            ->where('user_id', Auth::id())
            ->paginate(10);

        return response()->json(new ProductCollection($products), Response::HTTP_OK);
    }

    public function updateSellerProduct(ProductRequest $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $product->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Produk seller berhasil diupdate',
            'data' => new ProductResource($product->load('user')),
        ], Response::HTTP_OK);
    }

    public function deleteSellerProduct($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Produk seller berhasil dihapus',
        ], Response::HTTP_OK);
    }

    // ==============================
    // 🔹 Admin Only
    // ==============================
    public function allSellerProducts()
    {
        $products = Product::with('user')->latest()->paginate(10);
        return response()->json(new ProductCollection($products), Response::HTTP_OK);
    }

    public function updateAnyProduct(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Produk seller berhasil diupdate oleh admin',
            'data' => new ProductResource($product->load('user')),
        ], Response::HTTP_OK);
    }

    public function deleteAnyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Produk seller berhasil dihapus oleh admin',
        ], Response::HTTP_OK);
    }
}
