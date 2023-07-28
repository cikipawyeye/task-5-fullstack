<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    private function getAccessToken() {
        $userData = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', 'http://localhost:8000/api/v1/login', $userData);

        $responseData = $response->decodeResponseJson();

        return 'Bearer' . $responseData['access_token'];
    }
    
    private function getHeader() {
        $userData = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', 'http://localhost:8000/api/v1/login', $userData);

        $responseData = $response->decodeResponseJson();

        return [
            'Authorization' => 'Bearer ' . $responseData['access_token'],
            'Accept' => 'application/json'
        ];
    }

    public function test_login_with_valid_credentials()
    {
        $userData = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', 'http://localhost:8000/api/v1/login', $userData);

        $response->assertStatus(200);
    }
    
    public function test_login_with_invalid_credentials()
    {
        $userData = [
            'email' => 'invalidtest@test.com',
            'password' => 'falsepassword',
        ];

        $response = $this->json('POST', 'http://localhost:8000/api/v1/login', $userData);
        
        $response->assertStatus(401);
    }
    
    public function test_write_post() {
        $body = [
            'title' => 'Feature Test',
            'content' => 'Feature Test Content',
            'category_id' => '1',
        ];
        $response = $this->json('POST', 'http://localhost:8000/api/v1/posts', $body, $this->getHeader());

        $response->assertStatus(200);

    }
    
    public function test_show_post() {
        $post = Article::factory()->create();
        $response = $this->json('GET', 'http://localhost:8000/api/v1/posts/' . $post->id, [], $this->getHeader());
        
        $response->assertStatus(200);
        
        $this->assertArrayHasKey('id', $response->decodeResponseJson());
        $this->assertArrayHasKey('title', $response->decodeResponseJson());
        $this->assertArrayHasKey('content', $response->decodeResponseJson());
        $this->assertArrayHasKey('user_id', $response->decodeResponseJson());
        $this->assertArrayHasKey('category_id', $response->decodeResponseJson());
    }

    public function test_update_post() {
        $post = Article::factory()->create();
        $body = [
            'title' => 'Feature Test Update',
            'content' => 'Feature Test Update Content',
            'category_id' => '1',
            '_method' => 'put',
        ];
        $response = $this->json('POST', 'http://localhost:8000/api/v1/posts/' . $post->id, $body, $this->getHeader());

        $response->assertStatus(200);

    }
    
    public function test_get_all_posts() {
        $response = $this->json('GET', 'http://localhost:8000/api/v1/posts', [], $this->getHeader());
        
        $response->assertStatus(200);
    }
    
    public function test_delete_posts() {
        $post = Article::factory()->create();
        $response = $this->json('DELETE', 'http://localhost:8000/api/v1/posts/' . $post->id, [], $this->getHeader());
        
        $response->assertStatus(200);
    }
}
