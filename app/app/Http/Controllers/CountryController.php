<?php

namespace App\Http\Controllers;

use App\Events\CreateLog;
use App\Models\Country;
use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class CountryController extends Controller
{

    public function __construct(
        protected Country $country
    )
    {
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $country = Country::query();
        $country = $this->filters($country, $request->all());

        Event::dispatch(new CreateLog('list-countries', []));

        return response()->json($country->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $country = new Country();
        $country->name = Arr::get($request->all(), 'name');
        $country->code = Arr::get($request->all(), 'code');
        $country->save();
        $country->refresh();

        Event::dispatch(new CreateLog('create-country', $country->toArray()));

        return response()->json($country);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $country
     * @return \Illuminate\Http\Response
     */
    public function show($country)
    {

        $object = Country::query();

        $object->find($country);

        Event::dispatch(new CreateLog('show-country', $object->first()->toArray()));

        return response()->json($object->first());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $country)
    {
        $country->name = Arr::get($request->all(), 'name');
        $country->code = Arr::get($request->all(), 'code');
        $country->save();
        $country->refresh();

        Event::dispatch(new CreateLog('update-country', $country->toArray()));

        return response()->json($country);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($country)
    {
        (new Country())->where('id','=',$country)->delete();

        Event::dispatch(new CreateLog('destroy-country', [$country]));

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

        if (Arr::has($params, 'name'))
        {
            $query->where('name','ilike', Arr::get($params, 'name'));
        }

        if (Arr::has($params, 'code'))
        {
            $query->where('code','ilike', Arr::get($params, 'code'));
        }

        return $query;

    }
}
