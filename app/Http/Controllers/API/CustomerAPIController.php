<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerAPIRequest;
use App\Http\Requests\API\UpdateCustomerAPIRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CustomerController
 */

class CustomerAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/customers",
     *      summary="getCustomerList",
     *      tags={"Customer"},
     *      description="Get all Customers",
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
     *                  @OA\Items(ref="#/components/schemas/Customer")
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
        $query = Customer::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $customers = $query->get();
        $customers->map(
          function ($customer) {
              $customer->customerGroup;
              $customer->customerBranch;
              $customer->customerFarms;
          });
        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/customers",
     *      summary="createCustomer",
     *      tags={"Customer"},
     *      description="Create Customer",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Customer")
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
     *                  ref="#/components/schemas/Customer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['branch_id']=$request->header('current-branch');
//        dd($input);
        /** @var Customer $customer */
        $customer = Customer::create($input);
        $customer->customerGroup;
        $customer->customerBranch;
        $customer->customerFarms;
        return $this->sendResponse($customer->toArray(), 'Customer saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/customers/{id}",
     *      summary="getCustomerItem",
     *      tags={"Customer"},
     *      description="Get Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
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
     *                  ref="#/components/schemas/Customer"
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
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }
        $customer->customerGroup;
        $customer->customerBranch;
        $customer->customerFarms;
        return $this->sendResponse($customer->toArray(), 'Customer retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/customers/{id}",
     *      summary="updateCustomer",
     *      tags={"Customer"},
     *      description="Update Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Customer")
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
     *                  ref="#/components/schemas/Customer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerAPIRequest $request): JsonResponse
    {
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->fill($request->all());
        $customer->save();
        $customer->customerGroup;
        $customer->customerBranch;
        $customer->customerFarms;
        return $this->sendResponse($customer->toArray(), 'Customer updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/customers/{id}",
     *      summary="deleteCustomer",
     *      tags={"Customer"},
     *      description="Delete Customer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Customer",
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
        /** @var Customer $customer */
        $customer = Customer::find($id);

        if (empty($customer)) {
            return $this->sendError('Customer not found');
        }

        $customer->delete();

        return $this->sendSuccess('Customer deleted successfully');
    }
}
