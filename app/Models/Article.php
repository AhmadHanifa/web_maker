<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

class Article extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
        public $table="articles";
    // public $guarded=['id','created_at','updated_at'];
        public $fillable = ['id','post_type','post_date','description','description_en','title_en','title','post_status','post_parent','post_type','main_image','slug','meta_description','views'];

    public function getRouteKeyName(){
        return 'slug';
    }
    public function item_seens()
    {
        return $this->hasMany(\App\Models\ItemSeen::class,'type_id','id')->where('type',"ARTICLE");
    }
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
 

  
    public function comments(){
        return $this->hasMany(\App\Models\ArticleComment::class,'article_id');
    }
    public function main_image($type='thumb'){
        if($this->main_image==null)
            return env('DEFAULT_IMAGE');
        else
            return env("STORAGE_URL").'/'.\MainHelper::get_conversion($this->main_image,$type);
    }
    public function tags(){
        return $this->belongsToMany(\App\Models\Tag::class,'article_tags');

    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('tiny')
            ->fit(Manipulations::FIT_MAX, 120, 120)
            ->width(120)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_MAX, 350, 1000)
            ->width(350)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

        $this
            ->addMediaConversion('original')
            ->fit(Manipulations::FIT_MAX, 1200,10000)
            ->width(1200)
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();

    }
}
