<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateManufacturingGroupAPIRequest;
use App\Http\Requests\API\UpdateManufacturingGroupAPIRequest;
use App\Models\ManufacturingGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ManufacturingGroupController
 */

class ManufacturingGroupAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/manufacturing-groups",
     *      summary="getManufacturingGroupList",
     *      tags={"ManufacturingGroup"},
     *      description="Get all ManufacturingGroups",
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
     *                  @OA\Items(ref="#/components/schemas/ManufacturingGroup")
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
        $query = ManufacturingGroup::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $manufacturingGroups = $query->get();

        return $this->sendResponse($manufacturingGroups->toArray(), 'Manufacturing Groups retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/manufacturing-groups",
     *      summary="createManufacturingGroup",
     *      tags={"ManufacturingGroup"},
     *      description="Create ManufacturingGroup",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ManufacturingGroup")
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
     *                  ref="#/components/schemas/ManufacturingGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManufacturingGroupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ManufacturingGroup $manufacturingGroup */
        $manufacturingGroup = ManufacturingGroup::create($input);

        return $this->sendResponse($manufacturingGroup->toArray(), 'Manufacturing Group saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/manufacturing-groups/{id}",
     *      summary="getManufacturingGroupItem",
     *      tags={"ManufacturingGroup"},
     *      description="Get ManufacturingGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ManufacturingGroup",
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
     *                  ref="#/components/schemas/ManufacturingGroup"
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
        /** @var ManufacturingGroup $manufacturingGroup */
        $manufacturingGroup = ManufacturingGroup::find($id);

        if (empty($manufacturingGroup)) {
            return $this->sendError('Manufacturing Group not found');
        }

        return $this->sendResponse($manufacturingGroup->toArray(), 'Manufacturing Group retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/manufacturing-groups/{id}",
     *      summary="updateManufacturingGroup",
     *      tags={"ManufacturingGroup"},
     *      description="Update ManufacturingGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ManufacturingGroup",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ManufacturingGroup")
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
     *                  ref="#/components/schemas/ManufacturingGroup"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManufacturingGroupAPIRequest $request): JsonResponse
    {
        /** @var ManufacturingGroup $manufacturingGroup */
        $manufacturingGroup = ManufacturingGroup::find($id);

        if (empty($manufacturingGroup)) {
            return $this->sendError('Manufacturing Group not found');
        }

        $manufacturingGroup->fill($request->all());
        $manufacturingGroup->save();

        return $this->sendResponse($manufacturingGroup->toArray(), 'ManufacturingGroup updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/manufacturing-groups/{id}",
     *      summary="deleteManufacturingGroup",
     *      tags={"ManufacturingGroup"},
     *      description="Delete ManufacturingGroup",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ManufacturingGroup",
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
        /** @var ManufacturingGroup $manufacturingGroup */
        $manufacturingGroup = ManufacturingGroup::find($id);

        if (empty($manufacturingGroup)) {
            return $this->sendError('Manufacturing Group not found');
        }

        $manufacturingGroup->delete();

        return $this->sendSuccess('Manufacturing Group deleted successfully');
    }
}
