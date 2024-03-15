<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductUnitAPIRequest;
use App\Http\Requests\API\UpdateProductUnitAPIRequest;
use App\Models\ProductUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductUnitController
 */

class ProductUnitAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/product-units",
     *      summary="getProductUnitList",
     *      tags={"ProductUnit"},
     *      description="Get all ProductUnits",
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
     *                  @OA\Items(ref="#/components/schemas/ProductUnit")
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
        $query = ProductUnit::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $productUnits = $query->get();

        return $this->sendResponse($productUnits->toArray(), 'Product Units retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/product-units",
     *      summary="createProductUnit",
     *      tags={"ProductUnit"},
     *      description="Create ProductUnit",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductUnit")
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
     *                  ref="#/components/schemas/ProductUnit"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductUnitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProductUnit $productUnit */
        $productUnit = ProductUnit::create($input);

        return $this->sendResponse($productUnit->toArray(), 'Product Unit saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/product-units/{id}",
     *      summary="getProductUnitItem",
     *      tags={"ProductUnit"},
     *      description="Get ProductUnit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductUnit",
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
     *                  ref="#/components/schemas/ProductUnit"
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
        /** @var ProductUnit $productUnit */
        $productUnit = ProductUnit::find($id);

        if (empty($productUnit)) {
            return $this->sendError('Product Unit not found');
        }

        return $this->sendResponse($productUnit->toArray(), 'Product Unit retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/product-units/{id}",
     *      summary="updateProductUnit",
     *      tags={"ProductUnit"},
     *      description="Update ProductUnit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductUnit",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductUnit")
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
     *                  ref="#/components/schemas/ProductUnit"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductUnitAPIRequest $request): JsonResponse
    {
        /** @var ProductUnit $productUnit */
        $productUnit = ProductUnit::find($id);

        if (empty($productUnit)) {
            return $this->sendError('Product Unit not found');
        }

        $productUnit->fill($request->all());
        $productUnit->save();

        return $this->sendResponse($productUnit->toArray(), 'ProductUnit updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/product-units/{id}",
     *      summary="deleteProductUnit",
     *      tags={"ProductUnit"},
     *      description="Delete ProductUnit",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductUnit",
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
        /** @var ProductUnit $productUnit */
        $productUnit = ProductUnit::find($id);

        if (empty($productUnit)) {
            return $this->sendError('Product Unit not found');
        }

        $productUnit->delete();

        return $this->sendSuccess('Product Unit deleted successfully');
    }
}
