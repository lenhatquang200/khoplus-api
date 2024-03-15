<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerGroupAPIRequest;
use App\Http\Requests\API\UpdateCustomerGroupAPIRequest;
use App\Models\CustomerGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CustomerGroupController
 */

class CustomerGroupAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/customer-groups",
     *      summary="getCustomerGroupList",
     *      tags={"CustomerGroup"},
     *      description="Get all CustomerGroups",
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
     *                  @OA\Items(ref="#/components/schemas/CustomerGroup")
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
        $query = CustomerGroup::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $customerGroups = $query->get();

        return $this->sendResponse($customerGroups->toArray(), 'Customer Groups retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/customer-groups",
     *      summary="createCustomerGroup",
     *      tags={"CustomerGroup"},
     *      description="Create CustomerGroup",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerGroup")
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
     *                  ref="#/components/schemas/CustomerGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerGroupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CustomerGroup $customerGroup */
        $customerGroup = CustomerGroup::create($input);

        return $this->sendResponse($customerGroup->toArray(), 'Customer Group saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/customer-groups/{id}",
     *      summary="getCustomerGroupItem",
     *      tags={"CustomerGroup"},
     *      description="Get CustomerGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerGroup",
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
     *                  ref="#/components/schemas/CustomerGroup"
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
        /** @var CustomerGroup $customerGroup */
        $customerGroup = CustomerGroup::find($id);

        if (empty($customerGroup)) {
            return $this->sendError('Customer Group not found');
        }

        return $this->sendResponse($customerGroup->toArray(), 'Customer Group retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/customer-groups/{id}",
     *      summary="updateCustomerGroup",
     *      tags={"CustomerGroup"},
     *      description="Update CustomerGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerGroup",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerGroup")
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
     *                  ref="#/components/schemas/CustomerGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerGroupAPIRequest $request): JsonResponse
    {
        /** @var CustomerGroup $customerGroup */
        $customerGroup = CustomerGroup::find($id);

        if (empty($customerGroup)) {
            return $this->sendError('Customer Group not found');
        }

        $customerGroup->fill($request->all());
        $customerGroup->save();

        return $this->sendResponse($customerGroup->toArray(), 'CustomerGroup updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/customer-groups/{id}",
     *      summary="deleteCustomerGroup",
     *      tags={"CustomerGroup"},
     *      description="Delete CustomerGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerGroup",
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
        /** @var CustomerGroup $customerGroup */
        $customerGroup = CustomerGroup::find($id);

        if (empty($customerGroup)) {
            return $this->sendError('Customer Group not found');
        }

        $customerGroup->delete();

        return $this->sendSuccess('Customer Group deleted successfully');
    }
}
