<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SlugCreator;
use Log;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->excerpt = $validated['excerpt'];
        $post->content = $validated['content'];
        $post->slug = SlugCreator::createSlug($validated['title']);
        $post->content = $validated['content'];
        $post->user_id = auth()->id();
        $post->save();

        $post->categories()->attach($validated['categories']);

        $post->load(['categories', 'user']);

        $formattedOutputPost = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'content' => $post->content,
            'categories' => $post->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
            'user' => [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'email' => $post->user->email,
            ],
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];

        return response()->json($formattedOutputPost, 201);

    }
    public function index(Request $request)
    {
        try {
            $query = Post::where('user_id', Auth::id());

            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'like', "%$searchTerm%")
                        ->orWhere('content', 'like', "%$searchTerm%");
                });
            }

            // Paginación de los posts
            $posts = $query->orderBy('title')->with(['categories', 'user'])->paginate(10);

            // Devolviendo la respuesta con la estructura esperada
            return response()->json([
                'status' => 'success',  // Estado de la respuesta
                'data' => $posts->items(),  // Los items de la página actual
                'meta' => [
                    'current_page' => $posts->currentPage(),
                    'from' => $posts->firstItem(),
                    'last_page' => $posts->lastPage(),
                    'path' => $posts->url(1),
                    'per_page' => $posts->perPage(),
                    'to' => $posts->lastItem(),
                    'total' => $posts->total(),
                ],
            ]);
        } catch (\Exception $e) {
            // Log de errores detallado
            Log::error("Error al obtener los posts: " . $e->getMessage(), ['exception' => $e]);

            // Respuesta de error
            return response()->json(['error' => 'Error al obtener los posts: ' . $e->getMessage()], 500);
        }
    }

}
