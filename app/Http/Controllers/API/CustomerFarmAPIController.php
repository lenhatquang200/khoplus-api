<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerFarmAPIRequest;
use App\Http\Requests\API\UpdateCustomerFarmAPIRequest;
use App\Models\CustomerFarm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CustomerFarmController
 */

class CustomerFarmAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/customer-farms",
     *      summary="getCustomerFarmList",
     *      tags={"CustomerFarm"},
     *      description="Get all CustomerFarms",
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
     *                  @OA\Items(ref="#/components/schemas/CustomerFarm")
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
        $query = CustomerFarm::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $customerFarms = $query->get();

        return $this->sendResponse($customerFarms->toArray(), 'Customer Farms retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/customer-farms",
     *      summary="createCustomerFarm",
     *      tags={"CustomerFarm"},
     *      description="Create CustomerFarm",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerFarm")
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
     *                  ref="#/components/schemas/CustomerFarm"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerFarmAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CustomerFarm $customerFarm */
        $customerFarm = CustomerFarm::create($input);

        return $this->sendResponse($customerFarm->toArray(), 'Customer Farm saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/customer-farms/{id}",
     *      summary="getCustomerFarmItem",
     *      tags={"CustomerFarm"},
     *      description="Get CustomerFarm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerFarm",
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
     *                  ref="#/components/schemas/CustomerFarm"
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
        /** @var CustomerFarm $customerFarm */
        $customerFarm = CustomerFarm::find($id);

        if (empty($customerFarm)) {
            return $this->sendError('Customer Farm not found');
        }

        return $this->sendResponse($customerFarm->toArray(), 'Customer Farm retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/customer-farms/{id}",
     *      summary="updateCustomerFarm",
     *      tags={"CustomerFarm"},
     *      description="Update CustomerFarm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerFarm",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerFarm")
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
     *                  ref="#/components/schemas/CustomerFarm"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerFarmAPIRequest $request): JsonResponse
    {
        /** @var CustomerFarm $customerFarm */
        $customerFarm = CustomerFarm::find($id);

        if (empty($customerFarm)) {
            return $this->sendError('Customer Farm not found');
        }

        $customerFarm->fill($request->all());
        $customerFarm->save();

        return $this->sendResponse($customerFarm->toArray(), 'CustomerFarm updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/customer-farms/{id}",
     *      summary="deleteCustomerFarm",
     *      tags={"CustomerFarm"},
     *      description="Delete CustomerFarm",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerFarm",
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
        /** @var CustomerFarm $customerFarm */
        $customerFarm = CustomerFarm::find($id);

        if (empty($customerFarm)) {
            return $this->sendError('Customer Farm not found');
        }

        $customerFarm->delete();

        return $this->sendSuccess('Customer Farm deleted successfully');
    }
}
