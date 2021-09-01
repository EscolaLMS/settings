<?php

namespace EscolaLms\Fields\Http\Controllers;

use EscolaLms\Fields\Http\Controllers\Swagger\FieldsControllerContract;
use EscolaLms\Fields\Services\Contracts\FieldsServiceContract;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use EscolaLms\Fields\Http\Resources\FieldResource;
use EscolaLms\Fields\Http\Resources\FieldsCollection;

class FieldsController extends EscolaLmsBaseController implements FieldsControllerContract
{
    private FieldsServiceContract $service;

    public function __construct(FieldsServiceContract $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $fields = $this->service->publicList();
        return $this->sendResponse(new FieldsCollection($fields), "index success");
    }

    public function show(string $group, string $key, Request $request): JsonResponse
    {
        $field = $this->service->find($group, $key, true);
        return $this->sendResponse(new FieldResource($field), "show success");
    }
}
