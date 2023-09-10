<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Models\Stock;
use Database\Seeders\BlogSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_pages(): void
    {
        $this->seed(PageSeeder::class);

        $pages = [
            'home',
            'offers',
            'contact',
            'search',
            'blog',
        ];

        foreach ($pages as $page) {
            $response = $this->get(route($page));
            $response->assertStatus(200);
        }
    }

    public function test_can_view_page_product(): void
    {
        $this->seed();

        $product = Product::get()->random();
        $response = $this->get(route('product', $product->slug));
        $response->assertStatus(200)->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Product/Product'));
    }
    public function test_can_view_page_department(): void
    {
        $this->seed([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
        $department = Department::inRandomOrder()->limit(1)->first();
        $response = $this->get(route('department', $department->slug));
        $response->assertStatus(200)->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Department/Department'));
    }

    public function test_can_view_page_blog_and_post(): void
    {
        $this->seed();
        //blog
        $response = $this->get(route('blog'));
        $response->assertStatus(200)->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Blog/Blog'));

        //post
        $post = Blog::inRandomOrder()->get()->first();
        $response = $this->get(route('post', $post->slug));
        $response->assertStatus(200)->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Blog/Post'));
    }
}
