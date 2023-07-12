<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Chat;

class ChatControllerTest extends TestCase
{
    use  DatabaseTransactions, WithFaker;

    // Show chat and retrieve chat data test
    public function testShowChatFunctionality()
    {
        $testUser = User::factory()->create();
        $chatUser = User::factory()->create();

        Chat::factory()->create([
            'sender' => $testUser->id,
            'receiver' => $chatUser->id,
            'message' => 'Test Message 1',
            'created_at' => now()->subDay(),
        ]);

        Chat::factory()->create([
            'sender' => $chatUser->id,
            'receiver' => $testUser->id,
            'message' => 'Test Message 2',
            'created_at' => now(),
        ]);

        $this->actingAs($testUser);

        $response = $this->get(route('chat.showChat', ['id' => $chatUser->id]));

        $response->assertStatus(200);

        $response->assertViewHas('chat_user', $chatUser);
        $response->assertViewHas('messages');

        $messages = $response->viewData('messages');
        $this->assertEquals('Test Message 1', $messages[0]->message);
        $this->assertEquals('Test Message 2', $messages[1]->message);
    }

    // get chatted users and they are not duplicates
    public function testGetChattedUserFunctionality()
    {
        $testUser = User::factory()->create();
        $chatUser1 = User::factory()->create();
        $chatUser2 = User::factory()->create();

        Chat::factory()->create([
            'sender' => $testUser->id,
            'receiver' => $chatUser1->id,
            'message' => 'Test Message 1',
            'created_at' => now()->subDay(),
        ]);

        Chat::factory()->create([
            'sender' => $testUser->id,
            'receiver' => $chatUser1->id,
            'message' => 'Test Message 2',
            'created_at' => now()->subDay(),
        ]);

        Chat::factory()->create([
            'sender' => $chatUser2->id,
            'receiver' => $testUser->id,
            'message' => 'Test Message 3',
            'created_at' => now(),
        ]);

        $this->actingAs($testUser);

        $response = $this->get(route('chat.getChattedUser'));

        $response->assertStatus(200);
        $response->assertViewHas('chattedUsers');

        $chattedUsers = $response->viewData('chattedUsers');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $chattedUsers);
        $this->assertTrue($chattedUsers->contains($chatUser1));
        $this->assertTrue($chattedUsers->contains($chatUser2));

        $uniqueUserNames = $chattedUsers->pluck('name')->unique();
        $this->assertCount($uniqueUserNames->count(), $chattedUsers, 'Duplicate user names found in the chat user list');
    }

}
