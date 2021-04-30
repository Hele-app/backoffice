<?php

namespace App\Http\Controllers;

use App\Http\Wrapper\HeleApiWrapper;
use App\Models\MapPOI;
use App\Models\Region;
use Illuminate\Http\Request;

class MapPOIController extends Controller
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
        $pois = $this->hele->paginate(MapPOI::class)->call('pois_index', $request->only(['q', 'p']));

        return view('map.index')->with('pois', $pois);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = $this->hele->map(Region::class, 'data')->call('region_all')['data'];

        return view('map.create-or-edit')->with('regions', $regions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('pois_store', $request->all());

            return redirect()->route('map.index')->with('status', __('Point d\'intérêt créé avec succès'));
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
        $poi = $this->hele->map(MapPOI::class)->call(['pois_show', ['id' => $id]])['data'];

        dd($poi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $poi = $this->hele->map(MapPOI::class)->call(['pois_show', 'id' => $id])['data'];
        $regions = $this->hele->map(Region::class, 'data')->call('region_all')['data'];

        return view('map.create-or-edit')->with('poi', $poi)->with('regions', $regions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $poi = $this->hele->map(MapPOI::class)->call(['pois_update', 'id' => $id], $request->all());

            return back()->with('status', __('Point d\'intérêt mis à jour avec succès'));
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
            $this->hele->call(['pois_destroy', 'id' => $id]);

            return redirect()->route('map.index')->with('status', __('Point d\'intérêt supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
