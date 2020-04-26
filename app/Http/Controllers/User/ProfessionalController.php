<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Wrapper\HeleApiWrapper;
use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
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
        $users = $this->hele->paginate(User::class)->call('users.professionals_index', $request->only(['q', 'p']));

        return view('user.professional.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.professional.create-or-edit')->with('roles', User::getRoles());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->hele->call('users.professionals_store', $request->all());

            return redirect()->route('professionals.index')->with('status', __('Professionnel créé avec succès'));
        } catch (RequestException $e) {
            return back()->withInput($request->input())->withErrors($this->hele->errors($e->response));
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $professional)
    {
        $user = $this->hele->map(User::class)->call(['users.professionals_show', 'id' => $professional]);

        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $professional)
    {
        $user = $this->hele->map(User::class)->call(['users.professionals_show', 'id' => $professional]);

        return view('user.professional.create-or-edit')->with('user', $user)->with('roles', User::getRoles());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $professional)
    {
        try {
            $user = $this->hele->map(User::class)->call(['users.professionals_update', 'id' => $professional], $request->all());

            return back()->with('status', __('Professionnel mis à jour avec succès'));
        } catch (RequestException $e) {
            return back()->withInput($request->input())->withErrors($this->hele->errors($e->response));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $professional)
    {
        try {
            $this->hele->call(['users.professionals_destroy', 'id' => $professional]);

            return redirect()->route('professionals.index')->with('status', __('Professionnel supprimé avec succès'));
        } catch (RequestException $e) {
            return back()->withErrors($this->hele->errors($e->response));
        }
    }
}
