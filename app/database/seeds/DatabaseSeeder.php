<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('PostTableSeeder');

	}  //end of function run
} //end of class DatabaseSeeder

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        for ($i = 1; $i <= 6; $i++)
        {
            $user = new User();
            $user->email = 'user'. $i . '@codeup.com';
            $user->password = Hash::make('password');
            $user->first_name = 'Code';
            $user->last_name = 'Up' . $i;
            $user->is_admin = 0;
            $user->save();
        }

    } //end of function run
} //end of class UserTableSeeder

class PostTableSeeder extends Seeder {

    public function run()
    {
        DB::table('posts')->delete();

        for ($i = 1; $i <= 10; $i++)
        {
        	$post = new Post();
            $post->title = 'Post Title ' .  $i;
            $post->body = "Post Body Stuff" . $i;
            $post->user_id = rand(1, 3);
            $post->slug = '';
            $post->save();
            sleep(1);
        } //end of for loop

    } //end of function run

} //end of class PostTableSeeder