<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlantAPIRequest;
use App\Http\Requests\API\UpdatePlantAPIRequest;
use App\Models\Plant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PlantController
 */

class PlantAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/plants",
     *      summary="getPlantList",
     *      tags={"Plant"},
     *      description="Get all Plants",
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
     *                  @OA\Items(ref="#/components/schemas/Plant")
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
        $query = Plant::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $plants = $query->get();

        return $this->sendResponse($plants->toArray(), 'Plants retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/plants",
     *      summary="createPlant",
     *      tags={"Plant"},
     *      description="Create Plant",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Plant")
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
     *                  ref="#/components/schemas/Plant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePlantAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Plant $plant */
        $plant = Plant::create($input);

        return $this->sendResponse($plant->toArray(), 'Plant saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/plants/{id}",
     *      summary="getPlantItem",
     *      tags={"Plant"},
     *      description="Get Plant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Plant",
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
     *                  ref="#/components/schemas/Plant"
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
        /** @var Plant $plant */
        $plant = Plant::find($id);

        if (empty($plant)) {
            return $this->sendError('Plant not found');
        }

        return $this->sendResponse($plant->toArray(), 'Plant retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/plants/{id}",
     *      summary="updatePlant",
     *      tags={"Plant"},
     *      description="Update Plant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Plant",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Plant")
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
     *                  ref="#/components/schemas/Plant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePlantAPIRequest $request): JsonResponse
    {
        /** @var Plant $plant */
        $plant = Plant::find($id);

        if (empty($plant)) {
            return $this->sendError('Plant not found');
        }

        $plant->fill($request->all());
        $plant->save();

        return $this->sendResponse($plant->toArray(), 'Plant updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/plants/{id}",
     *      summary="deletePlant",
     *      tags={"Plant"},
     *      description="Delete Plant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Plant",
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
        /** @var Plant $plant */
        $plant = Plant::find($id);

        if (empty($plant)) {
            return $this->sendError('Plant not found');
        }

        $plant->delete();

        return $this->sendSuccess('Plant deleted successfully');
    }
}
