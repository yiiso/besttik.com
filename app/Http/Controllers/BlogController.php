<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category')->published();
        
        // 分类筛选
        if ($request->has('category') && $request->category) {
            $category = BlogCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // 搜索
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = BlogCategory::where('is_active', true)
            ->withCount('publishedPosts')
            ->orderBy('sort_order')
            ->get();
        
        $recentPosts = BlogPost::published()->recent(5)->get();
        
        return view('blog.index', compact('posts', 'categories', 'recentPosts'));
    }
    
    public function show(BlogPost $post)
    {
        if ($post->status !== 'published' || !$post->published_at || $post->published_at > now()) {
            abort(404);
        }
        
        // 增加浏览量
        $post->incrementViews();
        
        // 相关文章
        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(4)
            ->get();
        
        $recentPosts = BlogPost::published()->recent(5)->get();
        
        return view('blog.show', compact('post', 'relatedPosts', 'recentPosts'));
    }
    
    public function category(BlogCategory $category)
    {
        $posts = $category->publishedPosts()
            ->orderBy('published_at', 'desc')
            ->paginate(12);
        
        $categories = BlogCategory::where('is_active', true)
            ->withCount('publishedPosts')
            ->orderBy('sort_order')
            ->get();
        
        $recentPosts = BlogPost::published()->recent(5)->get();
        
        return view('blog.category', compact('category', 'posts', 'categories', 'recentPosts'));
    }
}
