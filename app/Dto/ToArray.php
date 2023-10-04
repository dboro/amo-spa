<?php

namespace App\Dto;

trait ToArray
{
    public function toArray(bool $sanitize = false): array
    {
        $data = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties();

        foreach ($props as $prop) {
            if ($sanitize) {
                if ( ! is_null($prop->getValue($this))) {
                    $data[$prop->name] = $prop->getValue($this);
                }
            } else {
                $data[$prop->name] = $prop->getValue($this);
            }
        }

        return $data;
    }
}
