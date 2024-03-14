<?php

namespace Integrations;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function a_user_can_like_a_post()
    {
        // given
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);
        // then

        $post->like();
        // assert
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        // given
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);
        // then

        $post->like();

        $post->unlike();
        // assert
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_like_status()
    {
        // given
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);
        // then

        $post->toggle();
        // assert

        $this->assertTrue($post->isLiked());

        $post->toggle();

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        // given
        $post = Post::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);
        // then

        $post->toggle();

        $this->assertEquals(1, $post->likesCount);
    }
}
