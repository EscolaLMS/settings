<?php

namespace EscolaLms\Auth\Http\Requests\Admin;

use EscolaLms\Fields\Models\Setting;

use EscolaLms\Fields\Enums\FieldTypes;

class UserGroupListRequest extends AbstractAdminOnlyRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Setting::class);
    }

    public function rules()
    {
        return [
            'key' => ['required', 'string'],
            'group' => ['required', 'string'],
            'public' => ['boolean'],
            'enumerable' => ['boolean'],
            'sort' => ['integer'],
            'type' => ['required', 'in:' . implode(',', FieldTypes::getValues())],
            'value' => ['required', 'string'],
        ];
    }
}
