<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     // store test
    public function testStoreFunctionality()
    {
        $testUser = User::factory()->create();

        $data = [
            'description' => 'Lorem ipsum dolor sit amet',
            'number' => '123',
            'category' => [1, 2, 3],
            'date' => '2023-07-05',
            'time' => '10:00',
        ];

        $response = $this->actingAs($testUser)
            ->post(route('post.store'), $data);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('posts', [
            'user_id' => $testUser->id,
            'description' => 'Lorem ipsum dolor sit amet',
            'number' => '123',
            'date' => '2023-07-05',
            'time' => '10:00:00',
        ]);

        $post = Post::latest()->first();

        $this->assertCount(3, $post->categoryPost);
        $this->assertEquals([1, 2, 3], $post->categoryPost->pluck('category_id')->toArray());
    }

    // change post status test
    public function testChangePostStatus()
    {
        $testUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $testUser->id]);

        $response = $this->actingAs($testUser)
            ->patch(route('post.changeStatus', ['id' => $post->id]));

        $response->assertRedirect('/');

        $updatedPost = $post->fresh();

        $this->assertEquals(2, $updatedPost->status);
    }
}
