<?php

namespace Newpixel\GeographyCRUD\App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Newpixel\GeographyCRUD\app\Http\Requests\TouristicZoneRequest as StoreRequest;
use Newpixel\GeographyCRUD\app\Http\Requests\TouristicZoneRequest as UpdateRequest;

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

    public function setupListOperation()
    {
        // calls to addColumn, addFilter, addButton, etc
    }

    public function setupCreateOperation()
    {
        $this->crud->setValidation(StoreRequest::class);

        // calls to addField
    }

    public function setupUpdateOperation()
    {
        $this->crud->setValidation(UpdateRequest::class);

        // calls to addField
        $this->setupCreateOperation(); // if it's the same as Create
    }

    public function setupShowOperation()
    {
        // calls to addColumn
        $this->setupListOperation(); // if you want it to have the same columns as List
    }

    public function store(StoreRequest $request)
    {
        // ..
        $redirect_location = $this->traitStore($request);
        // ..
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // ..
        $redirect_location = $this->traitUpdate($request);
        // ..
        return $redirect_location;
    }
}
