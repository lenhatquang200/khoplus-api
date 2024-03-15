<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductTypeAPIRequest;
use App\Http\Requests\API\UpdateProductTypeAPIRequest;
use App\Models\ProductType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductTypeController
 */

class ProductTypeAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/product-types",
     *      summary="getProductTypeList",
     *      tags={"ProductType"},
     *      description="Get all ProductTypes",
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
     *                  @OA\Items(ref="#/components/schemas/ProductType")
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
        $query = ProductType::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $productTypes = $query->get();

        return $this->sendResponse($productTypes->toArray(), 'Product Types retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/product-types",
     *      summary="createProductType",
     *      tags={"ProductType"},
     *      description="Create ProductType",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductType")
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
     *                  ref="#/components/schemas/ProductType"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProductType $productType */
        $productType = ProductType::create($input);

        return $this->sendResponse($productType->toArray(), 'Product Type saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/product-types/{id}",
     *      summary="getProductTypeItem",
     *      tags={"ProductType"},
     *      description="Get ProductType",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductType",
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
     *                  ref="#/components/schemas/ProductType"
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
        /** @var ProductType $productType */
        $productType = ProductType::find($id);

        if (empty($productType)) {
            return $this->sendError('Product Type not found');
        }

        return $this->sendResponse($productType->toArray(), 'Product Type retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/product-types/{id}",
     *      summary="updateProductType",
     *      tags={"ProductType"},
     *      description="Update ProductType",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductType",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductType")
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
     *                  ref="#/components/schemas/ProductType"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductTypeAPIRequest $request): JsonResponse
    {
        /** @var ProductType $productType */
        $productType = ProductType::find($id);

        if (empty($productType)) {
            return $this->sendError('Product Type not found');
        }

        $productType->fill($request->all());
        $productType->save();

        return $this->sendResponse($productType->toArray(), 'ProductType updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/product-types/{id}",
     *      summary="deleteProductType",
     *      tags={"ProductType"},
     *      description="Delete ProductType",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductType",
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
        /** @var ProductType $productType */
        $productType = ProductType::find($id);

        if (empty($productType)) {
            return $this->sendError('Product Type not found');
        }

        $productType->delete();

        return $this->sendSuccess('Product Type deleted successfully');
    }
}
