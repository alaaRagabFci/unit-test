<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BookTest extends TestCase
{
    use DataBaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetAllBooks()
    {
        factory(Book::class, 3)->create();
        $response = $this->get('books');
        $response->assertStatus(200);
        $this->assertCount(3, Book::all());
    }

    public function testCreateBook()
    {
        // $this->json('POST', '/user', ['name' => 'Sally']);
        // $response = $this->withHeaders([
        //     'X-Header' => 'Value',
        // ])->json('POST', '/user', ['name' => 'Sally']);
        $response = $this->post('books',['name' => 'book 1', 'price' => 10]);
        $response->assertStatus(201);
        $response->assertSee('book 1');
        $response->assertSeeInOrder(['book 1', 10]);
    }
    /** @test */
    public function ShowBook()
    {
        $book = factory(Book::class)->create();
        $response = $this->get('books/1');
        $response->assertStatus(200);
    }

    public function testDeleteBook()
    {
        $book = factory(Book::class)->create();
        $response = $this->delete('books/1');
        $response->assertStatus(200);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateBook()
    {
        $book = factory(Book::class)->create();
        $response = $this->call('PUT','books/1',['name' => 'alaa', 'price' => 50]);
        $response->assertStatus(200);
        $response->assertSee('alaa');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
