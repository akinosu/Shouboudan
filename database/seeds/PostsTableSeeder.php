<?php
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\Post::class, 50)
            ->create()
            ->each(
                function ($post) {
                $comments = factory(App\Models\Comment::class, 2)->make();
                $post->comments()->saveMany($comments);
            }
            );
    }
}
