<?php

namespace App\Models;

// use Carbon\Carbon;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Casts\AsCollection;
class Advertisement extends Model
{
    use HasPersianSlug, SoftDeletes, Rateable;

    protected $table = 'products';
    protected $fillable = [
        'admin_id',
        'user_id',
        'title',
        'address',
        'province_id',
        'city_id',
        'description',
        'advertiser_phone',
        'email',
        'images',
        'video_link',
        'status',
        'owner',
        'slug',
        'keywords',
        'seo_desc',
        'advertisement_location_id',
        'adv_category_id',
        'website',
        'eitaa',
        'rubika',
        'instagram',
        'telegram'
    ];

    protected $casts = [

        'images' => AsCollection::class,
        'keywords' => 'array',

    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    //    public function getSlugOptions(): SlugOptions
    //    {
    //        return SlugOptions::create()
    //            ->generateSlugsFrom('title')
    //            ->saveSlugsTo('slug');
    //    }

    // for many to many with categories table
    public function categories()
    {
        return $this->belongsToMany(AdvCategory::class, 'category_product');
    }


    // relation with productImage table / model
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    // relation with comments table / model
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    // one product belongs to many  users
    public function user()
    {
        return $this->belongsToMany(User::class, 'product_user');
    }

    public static function search($search)
    {
        return empty($search)
            ? static::query()
            : static::query()
                ->where('id', 'like', '%' . $search . '%')
                ->orWhere('title_persian', 'like', '%' . $search . '%')
                ->orWhere('title_english', 'like', '%' . $search . '%');
    }


    //    public function tags()
    //    {
    //        return $this->belongsToMany(Tag::class);
    //    }




}
