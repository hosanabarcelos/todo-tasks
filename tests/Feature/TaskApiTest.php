<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_all_tasks(): void
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/todo/api/tasks');

        $response
            ->assertOk()
            ->assertJsonCount(2, 'tasks');
    }

    public function test_it_returns_a_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/todo/api/tasks/{$task->id}");

        $response
            ->assertOk()
            ->assertJsonPath('task.id', $task->id);
    }

    public function test_it_returns_404_for_missing_task(): void
    {
        $response = $this->getJson('/todo/api/tasks/999999');

        $response
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonPath('message', 'Resource not found.');
    }

    public function test_it_creates_a_task(): void
    {
        $payload = [
            'title' => 'Test the web service',
            'description' => 'You should test the web service considering all possible invocations.',
        ];

        $response = $this->postJson('/todo/api/tasks', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('task.title', $payload['title'])
            ->assertJsonPath('task.description', $payload['description'])
            ->assertJsonPath('task.done', false);
    }

    public function test_it_validates_create_payload(): void
    {
        $response = $this->postJson('/todo/api/tasks', [
            'description' => 'Missing required title field',
        ]);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', 'Validation failed.');
    }

    public function test_it_updates_an_existing_task(): void
    {
        $task = Task::factory()->pending()->create([
            'title' => 'Old title',
        ]);

        $response = $this->putJson("/todo/api/tasks/{$task->id}", [
            'title' => 'New title',
            'done' => true,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('task.title', 'New title')
            ->assertJsonPath('task.done', true);
    }

    public function test_it_validates_empty_update_payload(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/todo/api/tasks/{$task->id}", []);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', 'Validation failed.');
    }

    public function test_it_deletes_a_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/todo/api/tasks/{$task->id}");

        $response
            ->assertOk()
            ->assertJson(['result' => true]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
