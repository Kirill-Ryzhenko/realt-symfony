<?php

namespace App\Service;

class AnnouncementFilter
{
    public function generateParamsDB($type, $params, $defaultParameters)
    {
        $params['type'] = $type;
        $choiceKeys     = ['apartment_size', 'due_date', 'ownership', 'type_house', 'balcony', 'sort'];

        foreach ($choiceKeys as $key) {
            if (!array_key_exists($key, $params)) {
                $params[$key] = 'null';
            }
        }

        $maxMinKeys = ['total_area', 'living_area', 'kitchen_area', 'price'];
        foreach ($maxMinKeys as $key) {
            if (!array_key_exists($key, $params)) {
                $params[$key]['min'] = $defaultParameters['min_' . $key];
                $params[$key]['max'] = $defaultParameters['max_' . $key];
            }
        }

        return $params;
    }

    public function generateParamsTemplate($type, $query, $defaultParameters): array
    {
        $params     = ['type' => $type];
        $choiceKeys = ['apartment_size', 'due_date', 'ownership', 'type_house', 'balcony', 'sort'];

        foreach ($choiceKeys as $key) {
            if (array_key_exists($key, $query)) {
                $params[$key] = $query[$key];
            } else {
                $params[$key] = null;
            }
        }

        $maxMinKeys = ['total_area', 'living_area', 'kitchen_area', 'price'];
        foreach ($maxMinKeys as $key) {
            if (array_key_exists($key, $query)) {
                $params[$key]['min'] = $query[$key]['min'];
                $params[$key]['max'] = $query[$key]['max'];
            } else {
                $params[$key]['min'] = $defaultParameters['min_' . $key];
                $params[$key]['max'] = $defaultParameters['max_' . $key];
            }
        }

        return $params;
    }

    public function getCurrentPage($query)
    {
        if (array_key_exists('page', $query)) {
            return $query['page'];
        } else {
            return 1;
        }
    }
}