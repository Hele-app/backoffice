<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Wrapper\HeleApiWrapper;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class YoungController extends Controller
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
        $users = $this->hele->paginate(User::class)->call('users.youngs_index', $request->only(['q', 'p']));

        return view('user.young.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = $this->hele->map(Establishment::class, 'data')->call('establishment_all')['data'];

        return view('user.young.create-or-edit')->with('roles', User::getRoles())->with('establishments', $establishments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('users.youngs_store', $request->all());

            return redirect()->route('youngs.index')->with('status', __('Jeune créé avec succès'));
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
        $user = $this->hele->map(User::class)->call(['users.youngs_show', 'id' => $id])['data'];

        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $user = $this->hele->map(User::class)->call(['users.youngs_show', 'id' => $id])['data'];
        $establishments = $this->hele->map(Establishment::class, 'data')->call('establishment_all')['data'];

        return view('user.young.create-or-edit')->with('user', $user)->with('roles', User::getRoles())->with('establishments', $establishments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $user = $this->hele->map(User::class)->call(['users.youngs_update', 'id' => $id], $request->all());

            return back()->with('status', __('Jeune mis à jour avec succès'));
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
            $this->hele->call(['users.youngs_destroy', 'id' => $id]);

            return redirect()->route('youngs.index')->with('status', __('Jeune supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
