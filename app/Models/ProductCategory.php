<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;
    use HasRecursiveRelationships;
    protected $table = 'product_categories';

    protected $appends = ['key', 'image_url', 'thumb_url'];
    protected $fillable = ['title', 'slug', 'content', 'image', 'icon', 'description', 'parent_id', 'published', 'show_in_menu', 'seo_title', 'seo_description'];
    protected $guarded = false;

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function getLocalKeyName()
    {
        return 'id';
    }

    // Отношение «родительская категория»
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    // Отношение «дочерние категории»
    public function child()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    // Рекурсивное отношение для всех уровней вложенности
    public function children()
    {
        return $this->child()->with('children');
    }

    // Виртуальный атрибут
    public function getKeyAttribute()
    {
        return $this->id;
    }

    // Получение всех активных категорий
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getImageUrlAttribute(): string | null
    {
        if($this->image) {
            if (env('FILESYSTEM_DISK', 'public') === 'tws3') {
                return Storage::disk('tws3')->url($this->image);
            }
            return asset('storage/' . $this->image);
        }else{
            return null;
        }
    }

    public function getThumbUrlAttribute(): string | null
    {
        if($this->image) {
            if (env('FILESYSTEM_DISK', 'public') === 'tws3') {
                return Storage::disk('tws3')->url($this->thumbnail);
            }
            return asset('storage/' . $this->thumbnail);
        }else{
            return null;
        }
    }
}
