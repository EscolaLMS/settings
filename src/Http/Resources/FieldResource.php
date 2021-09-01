<?php

namespace EscolaLms\Fields\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $data = [
            'id' => $this->id,
            'key' => $this->key,
            'group' => $this->group,
            'value' => $this->value,
            'public' => $this->public,
            'enumerable' => $this->enumerable,
            'sort' => $this->sort,
            'type' => $this->type,
        ];

        if ($this->type === 'json') {
            $data['value'] = json_decode($data['value']);
        }

        return $data;
    }
}