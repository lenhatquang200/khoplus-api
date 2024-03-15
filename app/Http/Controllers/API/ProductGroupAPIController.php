<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductGroupAPIRequest;
use App\Http\Requests\API\UpdateProductGroupAPIRequest;
use App\Models\ProductGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductGroupController
 */

class ProductGroupAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/product-groups",
     *      summary="getProductGroupList",
     *      tags={"ProductGroup"},
     *      description="Get all ProductGroups",
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
     *                  @OA\Items(ref="#/components/schemas/ProductGroup")
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
        $query = ProductGroup::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $productGroups = $query->get();

        return $this->sendResponse($productGroups->toArray(), 'Product Groups retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/product-groups",
     *      summary="createProductGroup",
     *      tags={"ProductGroup"},
     *      description="Create ProductGroup",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductGroup")
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
     *                  ref="#/components/schemas/ProductGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductGroupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProductGroup $productGroup */
        $productGroup = ProductGroup::create($input);

        return $this->sendResponse($productGroup->toArray(), 'Product Group saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/product-groups/{id}",
     *      summary="getProductGroupItem",
     *      tags={"ProductGroup"},
     *      description="Get ProductGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductGroup",
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
     *                  ref="#/components/schemas/ProductGroup"
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
        /** @var ProductGroup $productGroup */
        $productGroup = ProductGroup::find($id);

        if (empty($productGroup)) {
            return $this->sendError('Product Group not found');
        }

        return $this->sendResponse($productGroup->toArray(), 'Product Group retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/product-groups/{id}",
     *      summary="updateProductGroup",
     *      tags={"ProductGroup"},
     *      description="Update ProductGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductGroup",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductGroup")
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
     *                  ref="#/components/schemas/ProductGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductGroupAPIRequest $request): JsonResponse
    {
        /** @var ProductGroup $productGroup */
        $productGroup = ProductGroup::find($id);

        if (empty($productGroup)) {
            return $this->sendError('Product Group not found');
        }

        $productGroup->fill($request->all());
        $productGroup->save();

        return $this->sendResponse($productGroup->toArray(), 'ProductGroup updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/product-groups/{id}",
     *      summary="deleteProductGroup",
     *      tags={"ProductGroup"},
     *      description="Delete ProductGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductGroup",
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
        /** @var ProductGroup $productGroup */
        $productGroup = ProductGroup::find($id);

        if (empty($productGroup)) {
            return $this->sendError('Product Group not found');
        }

        $productGroup->delete();

        return $this->sendSuccess('Product Group deleted successfully');
    }
}
