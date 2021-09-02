<?php

namespace EscolaLms\Settings\Http\Requests\Admin;

use EscolaLms\Settings\Models\Setting;
use EscolaLms\Settings\Enums\SettingTypes;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', Setting::class);
    }

    public function rules()
    {
        return [
            'key' => ['sometimes', 'string'],
            'group' => ['sometimes', 'string'],
            'public' => ['boolean'],
            'enumerable' => ['boolean'],
            'sort' => ['integer'],
            'type' => ['sometimes',  Rule::in(SettingTypes::getValues())],
            'value' => ['sometimes', 'string'],
        ];
    }
}
