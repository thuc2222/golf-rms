<?php
// app/Models/Module.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'version',
        'is_active', 'is_core', 'dependencies', 'config', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_core' => 'boolean',
        'dependencies' => 'array',
        'config' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCore($query)
    {
        return $query->where('is_core', true);
    }
}