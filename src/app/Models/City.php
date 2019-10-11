<?php

namespace Newpixel\GeographyCRUD\App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class City extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($city) {
            \Storage::disk('public')->delete($city->feature_image);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geo_cities';
    public static $displayZone = ['top_destination' => 'Destinatie de top'];
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'operator_code', 'country_id', 'touristic_zone_id', 'short_details', 'full_details', 'feature_image', 'display_zone', 'meta', 'active', 'slug', 'parent_id', 'lft', 'rgt', 'depth'];
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
    public function country()
    {
        return $this->belongsTo('Newpixel\GeographyCRUD\App\Models\Country');
    }

    public function touristicZone()
    {
        return $this->belongsTo('Newpixel\GeographyCRUD\App\Models\TouristicZone');
    }

    public function continent()
    {
        return $this->country->continent();
    }

    public function hotels()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\Hotel');
    }

    public function hotelsAllInclusive()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\Hotel')->isAllInclusive();
    }

    public function offers()
    {
        return $this->hasMany('Newpixel\GeographyCRUD\App\Models\Package');
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

    public function scopeOnlyRomania($query)
    {
        return $query->where('country_id', 200);
    }

    public function scopeOnlyOnSeaside($query)
    {
        return $query->where('touristic_zone_id', 1);
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
        return url('cazare-'.$this->slug);
    }

    public function getMainImageUrlAttribute()
    {
        ($this->image && \File::exists(public_path('images/storage/'.$this->feature_image)))
        ? $url = \URL::asset('images/storage/'.$this->feature_image)
        : $url = \URL::asset('images/template/nopic400.png');

        return $url;
    }

    public function getNameWithCountryAttribute($value)
    {
        return $this->name.' - ( '.$this->country->name.' )';
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
        $destination_path = 'cities';

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
