<?php

namespace App\Http\Controllers;

use App\Events\CreateLog;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class UserController extends Controller
{

    public function __construct(
        protected User $user
    )
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = User::query();
        $user = $this->filters($user, $request->all());

        Event::dispatch(new CreateLog('list-users', []));

        return response()->json($user->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\userRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = Arr::get($request->all(), 'name');
        $user->cpf = Arr::get($request->all(), 'cpf');
        $user->id_country = Arr::get($request->all(), 'id_country');
        $user->id_city = Arr::get($request->all(), 'id_city');
        $user->save();
        $user->refresh();

        Event::dispatch(new CreateLog('create-user', $user->toArray()));

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $object = User::query();

        $object->find($user);

        $object->with('country:id,name');
        $object->with('city:id,name');

        Event::dispatch(new CreateLog('show-user', $object->first()->toArray()));

        return response()->json($object->first());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->refresh();
        $user->with('country:id,name');
        $user->with('city:id,name');

        Event::dispatch(new CreateLog('update-user', $user->toArray()));

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        (new User())->where('id','=',$user)->delete();

        Event::dispatch(new CreateLog('destroy-user', [$user]));

        return response('', 200);
    }

    /**
     * Filters data
     *
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filters($query, $params)
    {

        $query->with('country:id,name');
        $query->with('city:id,name');

        if (Arr::has($params, 'name'))
        {
            $query->where('name','ilike', Arr::get($params, 'name'));
        }

        return $query;

    }

}
