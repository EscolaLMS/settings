<?php

namespace EscolaLms\Settings\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'group' => $this->group,
            'value' => $this->value,
            'public' => $this->public,
            'enumerable' => $this->enumerable,
            'sort' => $this->sort,
            'type' => $this->type,
            'data' => $this->data,
        ];
    }
}
