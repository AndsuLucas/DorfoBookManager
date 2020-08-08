<?php
use App\Http\Controllers\Book\BookController as BookController;

class BookControllerTest extends TestCase
{
    private BookController $controllerClass;

    /**
     * @var string
     */
    const ROUTE = 'api/book';

    protected function setUp(): void
    {
        $this->controllerClass = app()->make(BookController::class);
        $this->markTestSkipped('incomplete');
        parent::setUp();
    }

    /**
     *
     */
    public function testBookApiIsOk()
    {
        $this->get(self::ROUTE);
        $this->assertResponseOk();
    }

    public function testBookApiReturnContentTypeJson()
    {
        $this->get(self::ROUTE);
        $contentType = $this->response->headers->get('content-type');
        $this->assertEquals($contentType, 'application/json;charset=utf-8');
    }
}