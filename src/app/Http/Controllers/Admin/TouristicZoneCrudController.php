<?php

namespace Newpixel\GeographyCRUD\App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Newpixel\GeographyCRUD\App\Http\Requests\TouristicZoneRequest as StoreRequest;
use Newpixel\GeographyCRUD\App\Http\Requests\TouristicZoneRequest as UpdateRequest;

/**
 * Class TouristicZoneCrudController.
 * @property-read CrudPanel $crud
 */
class TouristicZoneCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\GeographyCRUD\App\Models\TouristicZone');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/touristiczone');
        $this->crud->setEntityNameStrings('touristiczone', 'touristic_zones');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns

        // add asterisk for fields that are required in TouristicZoneRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
