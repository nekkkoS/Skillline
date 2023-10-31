<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditApplication;
use App\Http\Resources\CreditApplicationResource;

/**
 * @OA\Info(
 *     title="Кредитные Заявки API",
 *     version="1.0.0"
 * )
 */
class CreditApplicationController extends Controller
{
        /**
     * @OA\Get(
     *     path="/api/credit-applications",
     *     summary="Получить список кредитных заявок",
     *     tags={"Credit Applications"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешное получение списка кредитных заявок",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CreditApplication")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $creditApplications = CreditApplication::with('bank')->paginate($perPage);
        return CreditApplicationResource::collection($creditApplications);
    }

        /**
     * @OA\Post(
     *     path="/api/credit-applications",
     *     summary="Создать новую кредитную заявку",
     *     tags={"Credit Applications"},
     *     @OA\RequestBody(
     *         description="Поля запроса",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/CreditApplication"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Успешное создание новой кредитной заявки",
     *         @OA\JsonContent(ref="#/components/schemas/CreditApplication")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dealer' => 'required|string',
            'contact_person' => 'required|string',
            'loan_amount' => 'required|numeric',
            'loan_term' => 'required|integer',
            'interest_rate' => 'required|numeric',
            'reason' => 'required|string',
            'status' => 'required|string',
            'bank_id' => 'required|exists:banks,id',
        ]);

        $creditApplication = new CreditApplication($data);
        $creditApplication->save();

        return new CreditApplicationResource($creditApplication);
    }

        /**
     * @OA\Get(
     *     path="/api/credit-applications/{id}",
     *     summary="Получить информацию о кредитной заявке",
     *     tags={"Credit Applications"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор заявки",
     *         schema=@OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное получение информации о кредитной заявке",
     *         @OA\JsonContent(ref="#/components/schemas/CreditApplication")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Заявка не найдена"
     *     )
     * )
     */
    public function show(CreditApplication $creditApplication)
    {
        $creditApplication->load('bank');
        return new CreditApplicationResource($creditApplication);
    }

        /**
     * @OA\Put(
     *     path="/api/credit-applications/{id}",
     *     summary="Обновить информацию о кредитной заявке",
     *     tags={"Credit Applications"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор заявки",
     *         schema=@OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Поля запроса",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CreditApplication")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное обновление информации о кредитной заявке",
     *         @OA\JsonContent(ref="#/components/schemas/CreditApplication")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Заявка не найдена"
     *     )
     * )
     */
    public function update(Request $request, CreditApplication $creditApplication)
    {
        $data = $request->validate([
            'dealer' => 'string',
            'contact_person' => 'string',
            'loan_amount' => 'numeric',
            'loan_term' => 'integer',
            'interest_rate' => 'numeric',
            'reason' => 'string',
            'status' => 'string',
            'bank_id' => 'exists:banks,id',
        ]);

        $creditApplication->update($data);

        return new CreditApplicationResource($creditApplication);
    }

        /**
     * @OA\Delete(
     *     path="/api/credit-applications/{id}",
     *     summary="Удалить кредитную заявку",
     *     tags={"Credit Applications"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор заявки",
     *         schema=@OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Успешное удаление заявки"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Заявка не найдена"
     *     )
     * )
     */
    public function destroy(CreditApplication $creditApplication)
    {
        $creditApplication->delete();
        return response()->json(['message' => 'Credit application deleted']);
    }
}
