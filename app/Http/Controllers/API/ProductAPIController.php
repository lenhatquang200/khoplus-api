<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductController
 */

class ProductAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/products",
     *      summary="getProductList",
     *      tags={"Product"},
     *      description="Get all Products",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Product")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $products = $query->get();
        $products->map(
          function ($product) {
              $product->unit;
              $product->group;
              $product->type;
          });
        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/products",
     *      summary="createProduct",
     *      tags={"Product"},
     *      description="Create Product",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        if(!isset($input['code']) || $input['code']=='')
            $input['code'] = time();
        /** @var Product $product */

        $filename = '';
        if ($request->hasFile('image')) {
            //                if (filesize($request->image) > (1024 * 1024 * 5)) {
            //                    return $this->error([], 'Kích thước ảnh quá lớn!');
            //                }
            $max_zise = 1024 * 1024 * 10;
            if (filesize($request->image) > $max_zise) {
                $destinationPath = storage_path('app/public/products');
                $filename        = (rand(1, 100) + time()) . '.'
                  . $request->image->getClientOriginalExtension();
                $img             = Image::make($request->image);
                //                    $img->resize(640);
                $img->resize(640, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($destinationPath . '/' . $filename, 70);
            }
            else {
                $filename = (rand(1, 100) + time()) . '.'
                  . $request->image->getClientOriginalExtension();
                $request->image->storeAs(
                  'products/',
                  $filename, ['disk' => 'public']
                );
            }
        }
        $input['image'] = $filename;

        $product = Product::create($input);
        $product->unit;
        $product->group;
        $product->type;
        return $this->sendResponse($product->toArray(), 'Product saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/products/{id}",
     *      summary="getProductItem",
     *      tags={"Product"},
     *      description="Get Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        $product->unit;
        $product->group;
        $product->type;
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/products/{id}",
     *      summary="updateProduct",
     *      tags={"Product"},
     *      description="Update Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductAPIRequest $request): JsonResponse
    {
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->fill($request->all());
        $product->save();
        $product->unit;
        $product->group;
        $product->type;
        return $this->sendResponse($product->toArray(), 'Product updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/products/{id}",
     *      summary="deleteProduct",
     *      tags={"Product"},
     *      description="Delete Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendSuccess('Product deleted successfully');
    }
}
