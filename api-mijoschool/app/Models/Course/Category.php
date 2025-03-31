<?php

namespace App\Models\Course;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable =
    [
        'name',
        'image',
        "state",
        'category_id'
    ];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"] = Carbon::now();
    }
    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function children()
    {
        return $this->hasMany(Category::class, "category_id");
    }
    public function father()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
    function scopeFilterAdvance($query, $search, $state)
    {
        if ($search) {
            $query->where("name", "like", "%" . $search . "%");
        }
        if ($state !== null && $state !== "") {
            $query->where("state", $state);
        }
        return $query;
    }
}
