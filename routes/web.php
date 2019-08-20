<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Validator;

$router->post('/api/generate', function () use ($router) {
    $validator = Validator::make($router->app->request->all(), [
        'type' => [
            'in:integer,alphanumeric,guid,string,list'
        ],
        'length' => [
            'integer',
            'min:1',
            'max:256',
            'api_max_length',
        ],
        'list' => 'api_list'
    ]);
    if ($validator->fails()) {
        return \response()
            ->json($validator->getMessageBag())
            ->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    try {
        $generator = $router->app->make('Generator', [
            'type' => $router->app->request->json('type', 'alphanumeric'),
            'length' => $router->app->request->json('length', null),
            'list' => $router->app->request->json('list', null)
        ]);
        $id = DB::table('generated_values')
            ->insertGetId(['value' => $generator->generate()]);
    } catch (\Exception | \Error $e) {
        return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    return response(['id' => $id])
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->setStatusCode(Response::HTTP_CREATED);
});

$router->get('/api/retrieve/{id}', function ($id) use ($router) {
    $generatedValue = DB::table('generated_values')
        ->where('id', '=', $id)
        ->value('value');
    if (!$generatedValue) {
        return response('', Response::HTTP_NOT_FOUND);
    }

    return response(['value' => $generatedValue])
        ->withHeaders([
            'Content-Type' => 'application/json',
        ]);
});


