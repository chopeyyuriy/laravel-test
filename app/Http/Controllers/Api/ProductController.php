<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\ListProductsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductDetailsRequest;
use App\Http\Requests\UpdateProductPriceRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProductStockRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class ProductController extends CoreController
{
    public static function routers()
    {
        Route::group(
            [
                'prefix' => 'product',
            ],
            function () {
                Route::post('store-product', [static::class, 'storeProduct']);
                Route::post('update-product', [static::class, 'updateProduct']);
                Route::post('update-product-details', [static::class, 'updateProductDetails']);
                Route::get('list-products', [static::class, 'listProducts']);
                Route::delete('delete-product', [static::class, 'deleteProduct']);
                Route::post('update-product-price', [static::class, 'updateProductPrice']);
                Route::post('update-product-stock', [static::class, 'updateProductStock']);
            }
        );
    }

    /**
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProduct(StoreProductRequest $request)
    {
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;

        if ($product->save()) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $product->id;
            $productDetail->price = $request->price;
            $productDetail->stock = $request->stock;
            $productDetail->save();
        }

        return $this->responseSuccess(new ProductResource($product));
    }

    /**
     * @param UpdateProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProduct(UpdateProductRequest $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return $this->responseError('Product not found');
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->update();

        return $this->responseSuccess(new ProductResource($product));
    }

    /**
     * @param UpdateProductDetailsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductDetails(UpdateProductDetailsRequest $request)
    {
        $productDetail = ProductDetail::where('product_id', $request->product_id)
            ->first();

        if (!$productDetail) {
            return $this->responseError('Product Details not found');
        }

        $productDetail->price = $request->price;
        $productDetail->stock = $request->stock;
        $productDetail->update();

        return $this->responseSuccess(new ProductDetailResource($productDetail));
    }

    /**
     * @param ListProductsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listProducts(ListProductsRequest $request)
    {
        $products = Product::paginate($this->getPerPage($request->per_pate ?? 15));

        return $this->responseSuccess(new ProductsResource($products));
    }

    /**
     * @param DeleteProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProduct(DeleteProductRequest $request)
    {
        $product = Product::find($request->product_id);
        if ($product) {
            $product->delete();
        }

        return $this->responseSuccess('The product has been successfully removed');
    }

    /**
     * @param UpdateProductPriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductPrice(UpdateProductPriceRequest $request)
    {
        $productDetail = ProductDetail::where('product_id', $request->product_id)
            ->first();

        if (!$productDetail) {
            return $this->responseError('Product Details not found');
        }

        $productDetail->price = $request->price;
        $productDetail->update();

        return $this->responseSuccess(new ProductDetailResource($productDetail));
    }

    /**
     * @param UpdateProductStockRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProductStock(UpdateProductStockRequest $request)
    {
        $productDetail = ProductDetail::where('product_id', $request->product_id)
            ->first();

        if (!$productDetail) {
            return $this->responseError('Product Details not found');
        }

        $productDetail->stock = $request->stock;
        $productDetail->update();

        return $this->responseSuccess(new ProductDetailResource($productDetail));
    }
}
