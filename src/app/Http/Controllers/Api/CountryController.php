<?php

namespace Newpixel\GeographyCRUD\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newpixel\GeographyCRUD\App\Models\Country;

class CountryController extends Controller
{
    // ajax return countries for backpack filter column
    public function backpackCountryFilterOptions(Request $request)
    {
        $term = $request->input('term');
        $options = Country::where('name', 'like', '%'.$term.'%')->get();

        return $options->pluck('name', 'id');
    }
}
