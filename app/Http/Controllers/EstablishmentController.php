<?php

namespace App\Http\Controllers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\Establishment;
use App\Models\Region;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
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
        $establishments = $this->hele->paginate(Establishment::class)->call('establishment_index', $request->only(['q', 'p']));

        return view('establishment.index')->with('establishments', $establishments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = $this->hele->map(Region::class, 'data')->call('region_all')['data'];

        return view('establishment.create-or-edit')->with('regions', $regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('establishment_store', $request->all());

            return redirect()->route('establishments.index')->with('status', __('Etablissement créé avec succès'));
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
        $establishment = $this->hele->map(Establishment::class)->call(['establishment_show', ['id' => $id]])['data'];

        dd($establishment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $establishment = $this->hele->map(Establishment::class)->call(['establishment_show', 'id' => $id])['data'];
        $regions = $this->hele->map(Region::class, 'data')->call('region_all')['data'];

        return view('establishment.create-or-edit')->with('establishment', $establishment)->with('regions', $regions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $establishment = $this->hele->map(Establishment::class)->call(['establishment_update', 'id' => $id], $request->all());

            return back()->with('status', __('Etablissement mis à jour avec succès'));
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
            $this->hele->call(['establishment_destroy', 'id' => $id]);

            return redirect()->route('establishments.index')->with('status', __('Etablissement supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
