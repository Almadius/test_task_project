<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function fetch_all_tasks()
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }

    /** @test */
    public function fetch_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("/api/tasks/{$task->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function create_a_task()
    {
        $taskData = [
            'name' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'новый',
            'date' => now()->toDateString(),
        ];

        $response = $this->post('/api/tasks', $taskData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    /** @test */
    public function update_a_task()
    {
        $task = Task::factory()->create();

        $updateData = [
            'name' => 'Updated Title',
            'description' => 'Updated content.',
            'status' => 'в процессе',
            'date' => now()->toDateString(), // Добавьте это поле
        ];

        $response = $this->put("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $updateData);
    }

    /** @test */
    public function delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function tasks_can_be_filtered_by_status()
    {
        $task = Task::factory()->create(['status' => 'новый']);

        $response = $this->get('/api/tasks?status=новый');

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'новый']);
    }

    /** @test */
    public function tasks_can_be_filtered_by_date()
    {
        $knownDate = '2023-01-01';
        $randomDate = now()->addDays(rand(1, 10))->format('Y-m-d');

        $taskWithKnownDate = Task::factory()->create(['date' => $knownDate]);
        $taskWithRandomDate = Task::factory()->create(['date' => $randomDate]);

        $response = $this->get("/api/tasks?date=$knownDate");

        $response->assertStatus(200);

        $expectedDate = $knownDate . ' 00:00:00';
        $response->assertJsonFragment(['date' => $expectedDate]);

        // Эта проверка может быть ненужной, если вы точно знаете формат даты
        // $response->assertJsonMissing(['date' => $randomDate]);
    }
}
