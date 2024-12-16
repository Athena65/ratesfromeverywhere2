<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'image_url',
        'status',
        'user_id',
        'description',
    ];

    // Statik durumlar için enum tanımı (opsiyonel)
    public static $statuses = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    // Kullanıcı ilişkisi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
