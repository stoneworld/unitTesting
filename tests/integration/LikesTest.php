<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTests extends TestCase
{
    use DatabaseTransactions;
    protected $post;
    public function setUp()
    {
        parent::setUp();
        $this->post = factory(App\Post::class)->create();
        $this->signIn();
    }

    /**
     * @test
     */
    public function a_user_can_like_a_post()
    {
        // given I have a post
        // add a user
        //$user = factory(App\User::class)->create();
        // and that user is logged in
        //$this->actingAs($user);
        // when they like a post
        $this->post->like();
        // then we should see evidence in the database, and the post should be liked.
        $this->seeInDatabase('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);
        $this->assertTrue($this->post->isLiked($this->user));
    }

    /** @test */

    public function a_user_unlike_a_post()
    {
        $this->post->unlike();
        $this->notSeeInDatabase('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);
        $this->assertFalse($this->post->isLiked($this->user));
    }
    /**
     * @test
     */
    public function a_user_may_toggle_a_posts_like_status()
    {
        $this->post->toggle();
        $this->assertTrue($this->post->isLiked($this->user));
        $this->post->toggle();
        $this->assertFalse($this->post->isLiked($this->user));
    }
    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {

        $this->post->toggle();
        $this->assertEquals(1, $this->post->likesCount);
    }


}