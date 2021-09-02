<?php

namespace EscolaLms\Settings\Http\Controllers\Admin;

// use EscolaLms\Settings\Http\Controllers\Swagger\LessonAPISwagger;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use EscolaLms\Settings\Http\Controllers\Admin\Swagger\SettingsControllerContract;
use EscolaLms\Settings\Http\Requests\Admin\SettingsCreateRequest;
use EscolaLms\Settings\Http\Requests\Admin\SettingsDeleteRequest;
use EscolaLms\Settings\Http\Requests\Admin\SettingsListRequest;
use EscolaLms\Settings\Http\Requests\Admin\SettingsReadRequest;
use EscolaLms\Settings\Http\Requests\Admin\SettingsUpdateRequest;
use EscolaLms\Settings\Models\Setting;
use EscolaLms\Settings\Repositories\Contracts\SettingsRepositoryContract;
use EscolaLms\Settings\Services\Contracts\SettingsServiceContract;
use EscolaLms\Settings\Http\Resources\SettingResource;
use EscolaLms\Settings\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Response;
use Error;
use Illuminate\Http\JsonResponse;

/**
 * Class LessonController
 * @package App\Http\Controllers
 */

class SettingsController extends EscolaLmsBaseController  implements SettingsControllerContract 
{
    private SettingsRepositoryContract $repository;
    private SettingsServiceContract $service;

    public function __construct(SettingsRepositoryContract $repository,  SettingsServiceContract $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(SettingsListRequest $request): JsonResponse
    {
        $search = Arr::except($request->validated(), ['per_page', 'page', 'order_by', 'order']);
        $settings = $this->service->searchAndPaginate($search, $request->input('per_page'));
        return $this->sendResponseForResource(SettingResource::collection($settings), __("Order search results"));
    }

    public function store(SettingsCreateRequest $request): JsonResponse
    {
        $input = $request->all();

        try {
            $setting = $this->repository->create($input);
        } catch (Error $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse($setting->toArray(), 'Setting saved successfully');
    }

    public function show($id, SettingsReadRequest $request): JsonResponse
    {

        $setting = $this->repository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found', 404);
        }

        return $this->sendResponse($setting->toArray(), 'Setting retrieved successfully');
    }

    public function update($id, SettingsUpdateRequest $request): JsonResponse
    {
        $input = $request->all();

        $setting = $this->repository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        try {
            $setting = $this->repository->update($input, $id);
        } catch (Error $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendResponse($setting->toArray(), 'Setting updated successfully');
    }

    public function destroy($id, SettingsDeleteRequest $request): JsonResponse
    {
        $setting = $this->repository->find($id);

        if (empty($setting)) {
            return $this->sendError('Setting not found');
        }

        try {
            $this->repository->delete($id);
        } catch (Error $error) {
            return $this->sendError($error->getMessage(), 422);
        }

        return $this->sendSuccess('Setting deleted successfully');
    }

    public function groups(SettingsListRequest $request): JsonResponse
    {

        $groups = $this->service->groups();

        return $this->sendResponse($groups->toArray(), 'Settings groups retrieved successfully');
    }
}
