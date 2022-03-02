<?php

namespace App\Http\Controllers;

use App\Events\CreateLog;
use App\Models\City;
use App\Http\Requests\CityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class CityController extends Controller
{

    public function __construct(
        protected City $city
    )
    {
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $city = City::query();
        $city = $this->filters($city, $request->all());

        Event::dispatch(new CreateLog('list-cities', []));

        return response()->json($city->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = new City();
        $city->id_country = Arr::get($request->all(), 'id_country');
        $city->name = Arr::get($request->all(), 'name');
        $city->save();
        $city->refresh();

        Event::dispatch(new CreateLog('create-city', $city->toArray()));

        return response()->json($city);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cityId
     * @return \Illuminate\Http\Response
     */
    public function show($city)
    {
        $object = City::query();

        $object->find($city);

        $object->with('country:id,name');

        Event::dispatch(new CreateLog('show-city', $object->first()->toArray()));

        return response()->json($object->first());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        $city->id_country = Arr::get($request->all(), 'id_country');
        $city->name = Arr::get($request->all(), 'name');
        $city->save();
        $city->refresh();

        Event::dispatch(new CreateLog('update-city', $city->toArray()));

        return response()->json($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($city)
    {
        (new City())->where('id','=',$city)->delete();

        Event::dispatch(new CreateLog('destroy-city', [$city]));

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

        if (Arr::has($params, 'name'))
        {
            $query->where('name','ilike', Arr::get($params, 'name'));
        }

        return $query;

    }

    /**
     * Verifica se cidade existe
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function existsCity(Request $request)
    {
        $nameCity = Arr::get($request->all(), 'name');

        $city = (new City())->where('name','like', $nameCity)->first();

        if ($city === null)
        {
            return response()->json(false);
        }

        return response()->json(true);
    }

}
