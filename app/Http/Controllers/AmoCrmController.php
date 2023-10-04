<?php

namespace App\Http\Controllers;

use App\AmoCrmService;
use App\Http\Requests\AddContactRequest;
use App\LogsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AmoCrmController extends Controller
{
    /**
     * @param AmoCrmService $service
     * @return JsonResponse
     */
    public function index(AmoCrmService $service): JsonResponse
    {
        return new JsonResponse([
            'data' => $service->getLeads()
        ]);
    }

    /**
     * @param AddContactRequest $request
     * @param AmoCrmService $service
     * @return JsonResponse
     */
    public function addContact(AddContactRequest $request, AmoCrmService $service): JsonResponse
    {
        $service->addContact($request->getDto());

        return new JsonResponse();
    }

    /**
     * @param LogsService $service
     * @return JsonResponse
     */
    public function logs(LogsService $service): JsonResponse
    {
        return new JsonResponse([
            'data' => $service->getLogs()
        ]);
    }
}
