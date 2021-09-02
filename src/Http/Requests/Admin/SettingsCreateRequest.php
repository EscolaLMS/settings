<?php

namespace EscolaLms\Settings\Http\Requests\Admin;

use EscolaLms\Settings\Models\Setting;
use EscolaLms\Settings\Enums\SettingTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingsCreateRequest extends FormRequest
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
            'type' => ['required',  Rule::in(SettingTypes::getValues())],
            'value' => ['required', 'string'],
        ];
    }
}
