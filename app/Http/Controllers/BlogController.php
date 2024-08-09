<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
	public function blog(Request $request): Response
	{
		$page = Page::with('banners')->where('type', 'blog')->firstOrFail();
		$banner = $page->banners->where('position', 'middle')->where('active', 1)->where('type', 'banner')->first();

		$posts = Blog::with('category', 'author')->where('active', 1)->orderBy('id', 'desc')
			->when($request->q, function (Builder $query) use ($request) {

				$query->where(function ($sub_query) use ($request) {
					$sub_query->orWhere('title', 'like', "%$request->q%");
					$sub_query->orWhere('entry', 'like', "%$request->q%");
					$sub_query->orWhere('desc', 'like', "%$request->q%");
				});
			})
			->when($request->category, function (Builder $query) use ($request) {
				$query->whereHas('category', function (Builder $sub_query) use ($request) {
					$sub_query->where('slug', $request->category);
				});
			})->paginate(6)->withQueryString();

		//dd($this->categories_blog());

		return Inertia::render('Blog/Blog', [
			'posts' => PostResource::collection($posts),
			'recent_post' => $this->recent_post(),
			'categories_blog' => $this->categories_blog(),
			'filters' => $request->only(['q', 'category']),
			'banner' => $banner,
			'page' => $page,

		]);
	}

	public function post($slug): Response
	{
		$post = Blog::with('category', 'author')->where('slug', $slug)->where('active', 1)->firstOrFail();

		return Inertia::render('Blog/Post', [
			'post' => new PostResource($post),
			'recent_post' => $this->recent_post(),
			'categories_blog' => $this->categories_blog(),
		]);
	}

	public function recent_post()
	{
		$recent_post = Blog::where('active', 1)->orderBy('id', 'desc')->limit(5)->get();

		return PostResource::collection($recent_post);
	}

	public function categories_blog()
	{
		return Category::withCount('posts')->has('posts')->orderBy('name')->get();
	}
}
