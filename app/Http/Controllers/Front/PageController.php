<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function detail($slug)
    {
        $data = Post::where('status', 'publish')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('front.page.detail', [
            'data' => $data
        ]);
    }
}
