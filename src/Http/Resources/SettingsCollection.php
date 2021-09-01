<?php

namespace EscolaLms\Settings\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        foreach ($this->collection as $value) {
            switch($value->type) {
                case "config":
                    $data[$value->group][$value->key] = config($value->value);
                    break;
                case "json":
                    $data[$value->group][$value->key] = json_decode($value->value);
                    break;
                default:
                $data[$value->group][$value->key] = $value->value;
            }
            
        }

        return $data;
  
    }
}