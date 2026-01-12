<?php
// app/Models/GolfHole.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class GolfHole extends Model
{
    use Translatable;

    protected $fillable = [
        'golf_course_id', 'hole_number', 'name', 'description',
        'par', 'yardage', 'coordinates', 'image', 'handicap',
        'hazards', 'tips', 'sort_order'
    ];

    protected $casts = [
        'yardage' => 'array',
        'coordinates' => 'array',
        'hazards' => 'array',
    ];

    protected $translatable = ['name', 'description', 'tips'];

    public function golfCourse()
    {
        return $this->belongsTo(GolfCourse::class);
    }
}