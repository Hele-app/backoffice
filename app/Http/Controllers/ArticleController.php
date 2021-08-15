<?php

namespace App\Http\Controllers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\Article;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * An instance of HeleApiWrapper.
     *
     * @var HeleApiWrapper
     */
    private $hele = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->hele = new HeleApiWrapper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->hele->paginate(Article::class)->call('article_index', $request->only(['q', 'p']));

        $articles->setPath('articles')->setPageName('p');

        return view('article.index')->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('article.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('article_store', $request->all(), [], [
                'Content-Type' => 'multipart/form-data',
                'Accept' => 'application/json'
            ]);

            return redirect()->route('articles.index')->with('status', __('Article créé avec succès'));
        } catch (RequestException $e) {
            return back()->withInput($request->input())->withErrors($this->hele->errors($e->response));
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $article = $this->hele->map(Article::class)->call(['article_show', ['id' => $id]])['data'];

        dd($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $article = $this->hele->map(Article::class)->call(['article_show', 'id' => $id])['data'];

        return view('article.create-or-edit')->with('article', $article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $article = $this->hele->map(Article::class)->call(['article_update', 'id' => $id], $request->all());

            return back()->with('status', __('Article mis à jour avec succès'));
        } catch (RequestException $e) {
            return back()->withInput($request->input())->withErrors($this->hele->errors($e->response));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->hele->call(['article_destroy', 'id' => $id]);

            return redirect()->route('articles.index')->with('status', __('Article supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
