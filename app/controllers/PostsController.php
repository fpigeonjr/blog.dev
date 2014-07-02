<?php

class PostsController extends \BaseController {

	public function __construct()
	{
    // call base controller constructor
    parent::__construct();

    // run auth filter before all methods on this controller except index and show
    $this->beforeFilter('auth.basic', array('except' => array('index', 'show')));
	} // end __construct

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return ('Show a list of all posts');
		$posts = Post::paginate(4);
		return View::make('posts.index')->with('posts', $posts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//return ('Show a form for creating a post');
		return View::make('posts.create-edit');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), Post::$rules);
		if($validator->fails()){
			Session::flash('errorMessage', 'Post failed');
			return Redirect::back()->withInput()->withErrors($validator);
		} // if it fails
		else{
			$post = new Post();
			$post->title = Input::get('title');
			$post->body = Input::get('body');
			$post->save();

			Session::flash('successMessage', 'Post successfully created');
			return Redirect::action('PostsController@index');
		} //end of else
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Post::findorFail($id);
		return View::make('posts.show')->with('post', $post);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Post::find($id);
		return View::make('posts.create-edit')->with('post', $post);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make(Input::all(), Post::$rules);
		if($validator->fails()){
			Session::flash('errorMessage', 'Post failed');
			return Redirect::back()->withInput()->withErrors($validator);
		} // if it fails
		else{
			$post = Post::find($id);
			$post->title = Input::get('title');
			$post->body = Input::get('body');
			$post->save();

			Session::flash('successMessage', 'Post updated created');
			return Redirect::action('PostsController@show', $post->id)->with('post', $post);
		} //end of else
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Post::findorFail($id);
		$post->delete();
		Session::flash('successMessage', 'Post successfully deleted');
		return Redirect::action('PostsController@index');
	}  //end of destroy

} //end of PostController
