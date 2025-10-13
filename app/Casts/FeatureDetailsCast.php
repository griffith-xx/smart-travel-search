<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class FeatureDetailsCast implements CastsAttributes
{
    protected $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Cast the given value - แปลง JSON เป็น array ของ full objects
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (empty($value)) {
            return [];
        }

        // Decode JSON เป็น array ของ IDs
        $ids = is_string($value) ? json_decode($value, true) : $value;
        
        if (empty($ids) || !is_array($ids)) {
            return [];
        }

        // ดึงข้อมูลเต็มจาก database
        return $this->modelClass::whereIn('id', $ids)
            ->get()
            ->toArray();
    }

    /**
     * Prepare the given value for storage - แปลงกลับเป็น JSON array ของ IDs
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (empty($value)) {
            return json_encode([]);
        }

        // ถ้าเป็น array ของ objects/arrays ให้ดึง id ออกมา
        if (is_array($value)) {
            $ids = collect($value)->map(function ($item) {
                if (is_object($item)) {
                    return $item->id ?? $item;
                }
                if (is_array($item)) {
                    return $item['id'] ?? $item;
                }
                return $item;
            })->filter()->values()->toArray();

            return json_encode($ids);
        }

        return json_encode([]);
    }
}
