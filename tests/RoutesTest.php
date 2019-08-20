<?php

use Symfony\Component\HttpFoundation\Response;
use \Laravel\Lumen\Testing\DatabaseMigrations;
use \Illuminate\Support\Facades\DB;

class RoutesTest extends TestCase
{
    use DatabaseMigrations;

    public function goodPostParams()
    {
        return [
            ['', 4],
            ['', null],
            ['integer', 5],
            ['guid', null],
            ['string', 10],
            ['alphanumeric', 12],
            ['list', ['a', 'b', 'c']]
        ];
    }

    public function badPostParams()
    {
        return [
            ['alphanumeric', 0, 'length'],
            ['alphanumeric', 1001, 'length'],
            ['integer', 0, 'length'],
            ['integer', 20, 'length'],
            ['string', 0, 'length'],
            ['string', 1001, 'length'],
            ['bad_type', 10, 'type']
        ];
    }

    public function badGetParams()
    {
        return [
            [0],
            ['bad_param'],
            [100000000]
        ];
    }

    /**
     * @dataProvider badPostParams
     * @param $type
     * @param $length
     * @param $error
     */
    public function testBadPost($type, $length, $error)
    {
        $this->json('POST', '/api/generate', [
            'type' => $type,
            'length' => $length
        ]);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response->getStatusCode());
        $this->seeJsonStructure([$error]);
    }

    /**
     * @dataProvider goodPostParams
     * @param $type
     * @param int $params
     */
    public function testGoodPost($type, $params)
    {
        $testData = [];
        if ($type) {
            $testData['type'] = $type;
        }
        if (is_array($params)) {
            $testData['list'] = $params;
        } elseif ($params) {
            $testData['length'] = $params;
        }
        $this->post('/api/generate', $testData);
        $this->assertEquals(Response::HTTP_CREATED, $this->response->getStatusCode());
        $this->seeJsonStructure(['id'], $this->response->getContent());
    }

    /**
     * @dataProvider badGetParams
     * @param $id
     */
    public function testBadGet($id)
    {
        $this->get("/api/retrieve/$id");
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->response->getStatusCode());
    }

    public function testGoodGet()
    {
        $id = DB::table('generated_values')
            ->insertGetId(['value' => 'test_value']);
        $this->get("/api/retrieve/$id");
        $this->assertEquals(Response::HTTP_OK, $this->response->getStatusCode());
        $this->seeJson([
            'value' => 'test_value'
        ]);
    }
}
