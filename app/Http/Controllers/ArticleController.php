<?php

namespace App\Http\Controllers;

use App\Article;
use Response, DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

	public function listAll(){
		$toReturn = Article::orderBy('created_at','ASC')->get();

		return $toReturn;
	}

	public function view($id){
		$article = Article::where('id', $id)->first();
		return $article;
	}

	public function viewAuthor($id){
		$article = Article::where('id', $id)->first();
		$uid = $article->author;
		//$author = DB::connection('drupal')->select( "SELECT * FROM users WHERE uid = ? ORDER BY uid DESC", array( $uid ) );
		$author = DB::connection('drupal')->table('users')->where('uid', $uid)->select('uid', 'name', 'mail')->get();

		return $author;
	}

	public function create(){
		if(Article::where('name',trim(Input::get('name')))->count() > 0){
			return json_encode( array("message"=>"Name already used" ) );
			exit;
		}

		$author = ( null !== Input::get('author') ) ? Input::get('author') : 0;
		$status = ( null !== Input::get('status') ) ? Input::get('status') : 'pending';

		$Article = new Article();
		$Article->author = (int)$author;
		$Article->name = Input::get('name');
		$Article->title = Input::get('title');
		$Article->content = Input::get('content');
		$Article->status = $status;
		$Article->save();
		return json_encode( array("message"=>"Article created." ) );
		exit;
	}

	public function edit($id){
		if(Article::where('name',trim(Input::get('name')))->where('id','<>',$id)->count() > 0){
			return json_encode( array("message"=>"Name already used" ) );
			exit;
		}

		$Post = Article::find($id);
		$Post->name = Input::get('name');
		$Post->title = Input::get('title');
		$Post->content = Input::get('content');
		$Post->save();
		return json_encode( array("message"=>"Article saved." ) );
		exit;
	}

	public function delete($id){
		Article::find($id)->delete();	
		return 1;
	}

	public function viewAuthorsArticles($uid){
		$article = Article::where('author', $uid)->first();
		return $article;
	}
}