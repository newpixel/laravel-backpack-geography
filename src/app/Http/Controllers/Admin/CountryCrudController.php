<?php

namespace Newpixel\GeographyCRUD\App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Newpixel\GeographyCRUD\app\Http\Requests\CountryRequest as StoreRequest;
use Newpixel\GeographyCRUD\app\Http\Requests\CountryRequest as UpdateRequest;

/**
 * Class CountryCrudController.
 *
 * @property-read CrudPanel $crud
 */
class CountryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\GeographyCRUD\App\Models\Country');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/country');
        $this->crud->setEntityNameStrings('tara', 'tari');
    }

    public function setupListOperation()
    {
        // calls to addColumn, addFilter, addButton, etc
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
                'orderable' => false,
            ],
            [
                'name' => 'name',
                'label' => 'Denumire',
            ],
            [
                'name' => 'continent_id',
                'label' => 'Continent',
                'type' => 'select',
                'entity' => 'continent',
                'attribute' => 'name',
                'model' => 'Newpixel\GeographyCRUD\App\Models\Continent',
            ],
            [
                'name' => 'display_zone',
                'label' => 'Afisare in',
                'type' => 'array',
                // 'options' => $this->crud->model::$displayZone,
            ],
            [
                'name' => 'image',
                'label' => 'Imagine',
                'type' => 'image',
                'prefix' => 'images/storage/',
            ],
            [
                'name' => 'active',
                'label' => 'Activ',
                'type' => 'radio',
                'options' => [0 => 'Nu', 1 => 'Da'],
                'inline' => false,
            ],
        ]);

        $this->crud->addFilter(
            [
                'name' => 'continent',
                'type' => 'dropdown',
                'label'=> 'Continent',
            ],
            function () {
                return \Newpixel\GeographyCRUD\App\Models\Continent::whereHas('countries')->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('whereHas', 'continent', function ($query) use ($value) {
                    $query->where('continent_id', $value);
                });
            }
        );

        $this->crud->addFilter(
            [
                'name' => 'active',
                'type' => 'dropdown',
                'label'=> 'Status',
            ],
            [
                1 => 'Activ',
                0 => 'Inactiv',
            ],
            function ($value) {
                $this->crud->addClause('where', 'active', $value);
            }
        );

        $this->crud->addFilter(
            [
                'type' => 'simple',
                'name' => 'trashed',
                'label'=> 'Sterse',
            ],
            false,
            function ($values) {
                $this->crud->query = $this->crud->query->onlyTrashed();
            }
        );
    }

    public function setupCreateOperation()
    {
        $this->crud->setValidation(StoreRequest::class);

        // calls to addField
        $this->crud->addFields(
            [
                [
                    'name'              => 'name',
                    'label'             => 'Denumire',
                    'type'              => 'text',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-7'],
                ],
                [
                    'name'              => 'continent_id',
                    'label'             => 'Continent',
                    'type'              => 'select',
                    'entity'            => 'continent',
                    'attribute'         => 'name',
                    'model'             => 'Newpixel\GeographyCRUD\App\Models\Continent',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'              => 'active',
                    'label'             => 'Activ',
                    'type'              => 'radio',
                    'options'           => [0 => 'Nu', 1 => 'Da'],
                    'inline'            => true,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-2'],
                ],
                [
                    'name'        => 'display_zone',
                    'label'       => 'Afisare in',
                    'type'        => 'select2_from_array',
                    'options'     => $this->crud->model::$displayZone,
                    'allows_null' => false,
                    // 'default' => 'one',
                    'allows_multiple' => true,
                    'tab' => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'              => 'full_details',
                    'label'             => 'Detalii',
                    'type'              => 'wysiwyg',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'         => 'feature_image',
                    'label'        => 'Imagine',
                    'type'         => 'image',
                    'upload'       => true,
                    'crop'         => true,
                    'aspect_ratio' => 1,
                    'prefix'       => 'storage/',
                    'tab'          => 'Imagine',
                ],
                [
                    'name'              => 'title',
                    'label'             => 'Meta Title',
                    'fake'              => true,
                    'store_in'          => 'meta',
                    'tab'               => 'SEO',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'              => 'description',
                    'label'             => 'Meta Description',
                    'type'              => 'textarea',
                    'fake'              => true,
                    'store_in'          => 'meta',
                    'tab'               => 'SEO',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'              => 'keywords',
                    'label'             => 'Meta Keywords',
                    'fake'              => true,
                    'store_in'          => 'meta',
                    'tab'               => 'SEO',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
            ]
        );
    }

    public function setupUpdateOperation()
    {
        $this->crud->setValidation(UpdateRequest::class);

        // calls to addField
        // $this->crud->setValidation(UpdateRequest::class);

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
