<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Article;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_fetches_trending_article()
    {
        factory(Article::class, 2)->create();
        factory(Article::class)->create(['reads' => 10]);
        $mostPopular = factory(Article::class)->create(['reads' => 20]);
        $articles = Article::trending();
        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(4, $articles);
    }
}
