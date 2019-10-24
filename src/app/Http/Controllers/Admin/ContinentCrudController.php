<?php

namespace Newpixel\GeographyCRUD\App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Newpixel\GeographyCRUD\app\Http\Requests\ContinentRequest as StoreRequest;
use Newpixel\GeographyCRUD\app\Http\Requests\ContinentRequest as UpdateRequest;

/**
 * Class ContinentCrudController.
 * @property-read CrudPanel $crud
 */
class ContinentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        $this->crud->setModel('Newpixel\GeographyCRUD\App\Models\Continent');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/continent');
        $this->crud->setEntityNameStrings('continent', 'continente');
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
        ]);

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
                    'name'              => 'feature_image',
                    'label'             => 'Imagine',
                    'type'              => 'image',
                    'upload'            => true,
                    'crop'              => true,
                    'aspect_ratio'      => 1,
                    'prefix'            => 'storage/',
                    'tab'               => 'Imagine',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
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
