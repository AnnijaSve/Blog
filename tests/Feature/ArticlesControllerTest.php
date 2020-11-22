<?php

namespace Tests\Feature;


use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/articles');

        $response->assertStatus(200);

        $response->assertSee($article->title, $article->content);

    }

    public function testCreateAndStoreFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->followingRedirects();

        $response = $this->post(route('articles.store'), [
            'title' => 'Example title',
            'content' => 'Example content'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Example title',
            'content' => 'Example content'
        ]);
    }

    public function testShowFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $article = Article::factory()->create();

        $response = $this->get('/articles/' . $article->id);

        $response->assertSee($article->title);

        $response->assertSee($article->content);

    }

    public function testEditFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $article = Article::factory()->create();

        $response = $this->get('/articles/' . $article->id . '/edit');

        $response->assertStatus(200);

        $response->assertSee($article->title);

        $response->assertSee($article->content);

    }

    public function testUpdateFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $article = Article::factory()->create();

        $this->followingRedirects();

        $response = $this->put(route('articles.update', $article), [
            'title' => 'Updated title',
            'content' => 'Updated content',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'title' => 'Updated title',
            'content' => 'Updated content',
        ]);

    }

    public function testDeleteFunction(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);

        $this->followingRedirects();

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);
    }
}
