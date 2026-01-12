<?php
// app/Models/Currency.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code', 'name', 'symbol', 'exchange_rate',
        'is_active', 'is_default', 'format', 'decimal_places'
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:4',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'decimal_places' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function convert($amount, $toCurrency)
    {
        $to = self::where('code', $toCurrency)->first();
        if (!$to) return $amount;
        
        return ($amount / $this->exchange_rate) * $to->exchange_rate;
    }

    public function format($amount)
    {
        $formatted = number_format($amount, $this->decimal_places);
        return str_replace(['{symbol}', '{amount}'], [$this->symbol, $formatted], $this->format);
    }
}