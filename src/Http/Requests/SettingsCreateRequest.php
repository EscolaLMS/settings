<?php

namespace EscolaLms\Auth\Http\Requests\Admin;

use EscolaLms\Settings\Models\Setting;
use EscolaLms\Settings\Enums\SettingsTypes;
use Illuminate\Validation\Rule;

class SettingsCreateRequest extends AbstractAdminOnlyRequest
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
            'type' => ['required',  Rule::in(SettingsTypes::getValues())],
            'value' => ['required', 'string'],
        ];
    }
}
