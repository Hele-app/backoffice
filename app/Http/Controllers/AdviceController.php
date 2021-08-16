<?php

namespace App\Http\Controllers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\Advice;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class AdviceController extends Controller
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
        $advices = $this->hele->paginate(Advice::class)->call('advice_index', $request->only(['q', 'p']));

        $advices->setPath('advices')->setPageName('p');

        return view('advice.index')->with('advices', $advices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('advice.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('advice_store', $request->all());

            return redirect()->route('advices.index')->with('status', __('Conseil créé avec succès'));
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
        $advice = $this->hele->map(Advice::class)->call(['advice_show', ['id' => $id]])['data'];

        dd($advice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $advice = $this->hele->map(Advice::class)->call(['advice_show', 'id' => $id])['data'];

        return view('advice.create-or-edit')->with('advice', $advice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $advice = $this->hele->map(Advice::class)->call(['advice_update', 'id' => $id], $request->all());

            return back()->with('status', __('Conseil mis à jour avec succès'));
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
            $this->hele->call(['advice_destroy', 'id' => $id]);

            return redirect()->route('advices.index')->with('status', __('Conseil supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
