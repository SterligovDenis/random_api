<?php

namespace App\Providers;

use App\Generators\GuidGenerator;
use App\Generators\ListGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind('Generator', function ($app, $params) {
            $className = 'App\Generators\\' . ucfirst($params['type']) . 'Generator';
            $obj = $app->make($className);
            if ($params['list'] !== null && $obj instanceof ListGenerator) {
                $obj->setList($params['list']);
            } elseif ($params['length'] !== null && !($obj instanceof GuidGenerator)) {
                $obj->setLength($params['length']);
            }
            return $obj;
        });
    }

    public function boot()
    {
        Validator::extend('api_max_length', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            if (
                isset($data['type'])
                && $data['type'] === 'integer'
                && $value > 19
            ) {
                $validator->errors()->add('length', 'The length may not be greater than 19.');
                return false;
            }
            return true;
        });
        Validator::extend('api_list', function ($attribute, $value, $parameters, $validator) {
            if (!is_array($value)) {
                $validator->errors()->add('list', 'The list must be an array.');
                return false;
            }
            return true;
        });
    }
}
