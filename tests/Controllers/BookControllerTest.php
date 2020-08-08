<?php

use App\Http\Controllers\Book\BookController as BookController;
class BookControllerTest extends TestCase
{

    use Laravel\Lumen\Testing\DatabaseMigrations;

    /**
     * @var BookController
     */
    private $controllerClass;

    /**
     * @var string
     */
    const ROUTE = 'api/book';

    protected function setUp(): void
    {
        $this->controllerClass = app()->make(BookController::class);
        parent::setUp();
    }

    public function testBookApiIsOk()
    {
        $this->get(self::ROUTE);
        $this->assertResponseOk();
    }

    public function testBookApiReturnContentTypeJson()
    {
        $this->get(self::ROUTE);
        $headerData = $this->response->headers;
        $contentType = $this->response->headers->get('content-type');
        $this->assertEquals($contentType, 'application/json;charset=utf-8');
    }
}
