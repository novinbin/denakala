<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class AdvCategory extends Model
{
    use HasFactory, HasRecursiveRelationships;

    protected $table = 'categories';
    protected $fillable = [
        'title',
        'show_in_menu',
        'status',
        'parent_id'];



    public function getParentKeyName()
    {
        return 'parent_id';
    }
    public function isParent(): bool
    {
        return $this->parent_id != null;
    }


    public function parent()
    {
        return $this->belongsTo(AdvCategory::class, 'parent_id')->with('parent');
    }

    public function child()
    {
        return $this->HasMany(AdvCategory::class, 'parent_id')->with('child');
    }

    public static function getParent($parent_id)
    {
        return self::where('id', $parent_id)->first();
    }

    // for many to many with products table
    public function products()
    {
        return $this->belongsToMany(Advertisement::class, 'category_product');
        // ->orderby('created_at','ASC');
    }


}
