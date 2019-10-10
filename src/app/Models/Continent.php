<?php

namespace Newpixel\GeographyCRUD\App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Continent extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($continent) {
            \Storage::disk('public')->delete($continent->feature_image);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geo_continents';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'details', 'feature_image', 'meta', 'slug'];
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
    public function countries()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\Country');
    }

    public function cities()
    {
        return $this->countries->cities;
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

    public function getLinkAttribute()
    {
        return '/continent-'.$this->slug;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    // public function setFeatureImageAttribute($file)
    // {
    //     $attribute_name = "feature_image";
    //     $disk = "public";
    //     $destination_path = "continents";

    //     // if the image was erased
    //     if ($file == null) {
    //         \Storage::disk($disk)->delete($this->image);
    //         $this->attributes[$attribute_name] = null;
    //     }

    //     if (starts_with($file, 'data:image')) {
    //         \Storage::disk($disk)->delete($this->image);
    //         $filename = str_slug($this->slug_or_name.time()).'.jpg';

    //         $img = \Image::make($file)->resize(800, 600, function ($pict) {
    //             $pict->aspectRatio();
    //             $pict->upsize();
    //         });
    //         $img->resizeCanvas(800, 600, 'center', false, '#fff');
    //         \Storage::disk($disk)->put($destination_path.'/'.$filename, $img->stream());

    //         $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
    //     }
    // }
}
