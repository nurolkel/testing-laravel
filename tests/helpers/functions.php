<?php

use App\Models\Post;

function createPost($attributes = [])
{
    return Post::factory()->create($attributes);
}
