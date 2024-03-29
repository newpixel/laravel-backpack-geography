<?php

namespace Newpixel\GeographyCRUD\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Newpixel\GeographyCRUD\App\Models\City;

class CityController extends Controller
{
    // ajax return cities for edit form
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $form = collect($request->input('form'))->pluck('value', 'name');

        $options = City::query();

        if (! $form['county_id']) {
            return [];
        }

        // if a category has been selected, only show articles in that category
        if ($form['county_id']) {
            $options = $options->where('county_id', $form['county_id']);
        }

        // if a search term has been given, filter results to match the search term
        if ($search_term) {
            $options = $options->where('name', 'LIKE', '%'.$search_term.'%');
        }

        return $options->paginate(10)->toArray();
    }

    // ajax return cities for filter column
    public function citiesFilterOptions(Request $request)
    {
        $term = $request->input('term');
        $options = City::where('name', 'like', '%'.$term.'%')->get()->pluck('NameWithCountry', 'id');

        return $options;
    }

    public function show($id)
    {
        return City::find($id);
    }

    public function importUnitsFromBibi(Request $request)
    {
        $city = City::find($request->city);

        return Artisan::call('bibi:import-units', ['--citycode' => $city->operator_code]);
    }
}
