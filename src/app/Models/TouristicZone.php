<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class TouristicZone extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geo_touristic_zones';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'full_details', 'feature_image', 'meta', 'active', 'slug'];
    protected $fakeColumns = ['meta'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'meta' => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function sluggable()
    {
        return [
            'slug' => ['source' => 'slug_or_name'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function cities()
    {
        return $this->hasMany('App\Models\City', 'touristic_zone_id');
    }

    public function romanianCities()
    {
        return $this->hasMany('App\Models\City', 'touristic_zone_id')->OnlyRomania();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getSlugOrNameAttribute()
    {
        ($this->slug != '') ? $slug = $this->slug : $slug = $this->name;

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
