<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;

class SlugCreator
{
    public static function createSlug($title)
    {
        $slugBase = Str::slug($title);

        if(!Post::where('slug', $slugBase)->exists()) {
            return $slugBase;
        }

        $counter = 1;
        $newSlug = $slugBase;
        
        while (Post::where('slug', $newSlug)->exists()) {
            $newSlug = $slugBase . '-' . $counter;
            $counter++;
        }
        
        return $newSlug;
    }
}