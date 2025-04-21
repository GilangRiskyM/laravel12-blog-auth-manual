<?php

namespace App\Http\Controllers\Front;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $lastData = $this->lastData();

        $data = Blog::where('status', 'publish')
            ->where('id', '!=', $lastData->id)
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('front.blog.berita', [
            'data' => $data,
            'lastData' => $lastData,
        ]);
    }

    public function lastData()
    {
        $data = Blog::where('status', 'publish')
            ->orderBy('id', 'desc')
            ->latest()
            ->first();

        return $data;
    }

    public function show($slug)
    {
        $data = Blog::where('status', 'publish')
            ->where('slug', $slug)
            ->firstOrFail();
        $pagination = $this->pagination($data->id);

        return view('front.blog.detail-berita', [
            'data' => $data,
            'pagination' => $pagination
        ]);
    }

    private function pagination($id)
    {
        $dataPrev = Blog::where('status', 'publish')
            ->where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        $dataNext = Blog::where('status', 'publish')
            ->where('id', '>', $id)
            ->orderBy('id', 'desc')
            ->first();

        $data = [
            'prev' => $dataPrev,
            'next' => $dataNext
        ];

        return $data;
    }
}
