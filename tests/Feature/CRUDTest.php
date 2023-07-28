<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CRUDTest extends TestCase
{
    use WithFaker;

    public function test_user_can_create_post()
    {
        $this->actingAs(User::factory()->create());

        $postData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => 1,
        ];

        $response = $this->post('/home', $postData);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('articles', $postData); 
    }

    public function test_user_can_view_all_posts()
    {
        $this->actingAs(User::factory()->create());

        $posts = Article::factory()->count(3)->create();

        $response = $this->get('/home');

        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }

    public function test_user_can_update_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Article::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => 1,
        ];

        $response = $this->put("/home/{$post->id}", $updatedData);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('articles', $updatedData); 
    }

    public function test_user_can_delete_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->delete("/home/{$post->id}");

        $response->assertStatus(302); 
        $this->assertDatabaseMissing('articles', ['id' => $post->id]); 
    }
}
