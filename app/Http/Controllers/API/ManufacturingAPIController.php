<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateManufacturingAPIRequest;
use App\Http\Requests\API\UpdateManufacturingAPIRequest;
use App\Models\Manufacturing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ManufacturingController
 */

class ManufacturingAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/manufacturings",
     *      summary="getManufacturingList",
     *      tags={"Manufacturing"},
     *      description="Get all Manufacturings",
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
     *                  @OA\Items(ref="#/components/schemas/Manufacturing")
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
        $query = Manufacturing::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $manufacturings = $query->get();

        return $this->sendResponse($manufacturings->toArray(), 'Manufacturings retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/manufacturings",
     *      summary="createManufacturing",
     *      tags={"Manufacturing"},
     *      description="Create Manufacturing",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Manufacturing")
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
     *                  ref="#/components/schemas/Manufacturing"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateManufacturingAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Manufacturing $manufacturing */
        $manufacturing = Manufacturing::create($input);

        return $this->sendResponse($manufacturing->toArray(), 'Manufacturing saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/manufacturings/{id}",
     *      summary="getManufacturingItem",
     *      tags={"Manufacturing"},
     *      description="Get Manufacturing",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Manufacturing",
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
     *                  ref="#/components/schemas/Manufacturing"
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
        /** @var Manufacturing $manufacturing */
        $manufacturing = Manufacturing::find($id);

        if (empty($manufacturing)) {
            return $this->sendError('Manufacturing not found');
        }

        return $this->sendResponse($manufacturing->toArray(), 'Manufacturing retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/manufacturings/{id}",
     *      summary="updateManufacturing",
     *      tags={"Manufacturing"},
     *      description="Update Manufacturing",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Manufacturing",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Manufacturing")
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
     *                  ref="#/components/schemas/Manufacturing"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateManufacturingAPIRequest $request): JsonResponse
    {
        /** @var Manufacturing $manufacturing */
        $manufacturing = Manufacturing::find($id);

        if (empty($manufacturing)) {
            return $this->sendError('Manufacturing not found');
        }

        $manufacturing->fill($request->all());
        $manufacturing->save();

        return $this->sendResponse($manufacturing->toArray(), 'Manufacturing updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/manufacturings/{id}",
     *      summary="deleteManufacturing",
     *      tags={"Manufacturing"},
     *      description="Delete Manufacturing",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Manufacturing",
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
        /** @var Manufacturing $manufacturing */
        $manufacturing = Manufacturing::find($id);

        if (empty($manufacturing)) {
            return $this->sendError('Manufacturing not found');
        }

        $manufacturing->delete();

        return $this->sendSuccess('Manufacturing deleted successfully');
    }
}
