<?php

use App\Models\Article;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /** @test */
    function it_fetches_trending_articles()
    {
        // Given
        Article::factory(2)->create();
        Article::factory()->create([
            'reads' => 10
        ]);
        $mostPopular = Article::factory()->create([
            'reads' => 20
        ]);
        // When

        $articles = Article::trending();
        // Then

        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }
}
