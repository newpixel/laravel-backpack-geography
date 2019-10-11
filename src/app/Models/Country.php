<?php

namespace Newpixel\GeographyCRUD\App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Country extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($country) {
            \Storage::disk('public')->delete($country->feature_image);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geo_countries';
    public static $displayZone = ['top_destination' => 'Destinatie de top', 'homepage' => 'Prima pagina'];
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'continent_id', 'operator_code', 'full_details', 'feature_image', 'display_zone', 'meta', 'show_on_homepage', 'active', 'slug'];
    protected $fakeColumns = ['meta'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'meta' => 'object',
        'display_zone' => 'array',
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
    public function continent()
    {
        return $this->belongsTo('Newpixel\GeographyCRUD\App\Models\Continent');
    }

    public function cities()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\City');
    }

    public function seasideCities()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\City')->onlyOnSeaside();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeShowOnHome($query)
    {
        return $query->where('show_on_homepage', true);
    }

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
        return '/t/'.$this->slug;
    }

    public function getMainImageAttribute()
    {
        ($this->image && \File::exists(public_path('images/storage/'.$this->feature_image)))
        ? $url = \URL::asset('images/storage/'.$this->feature_image)
        : $url = \URL::asset('images/template/nopic.jpg');

        return $url;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setFeatureImageAttribute($file)
    {
        $attribute_name = 'feature_image';
        $disk = 'public';
        $destination_path = 'countries';

        // if the image was erased
        if ($file == null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($file, 'data:image')) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $filename = str_slug($this->slug_or_name.time()).'.jpg';

            $img = \Image::make($file)->resize(800, 600, function ($pict) {
                $pict->aspectRatio();
                $pict->upsize();
            });
            $img->resizeCanvas(800, 600, 'center', false, '#fff');
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $img->stream());

            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }
}
