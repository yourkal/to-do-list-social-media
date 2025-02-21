<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Post",
 *     title="Post",
 *     description="Model for social media post",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="New Campaign"),
 *     @OA\Property(property="brand", type="string", example="Brand A"),
 *     @OA\Property(property="platform", type="string", example="Instagram"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2025-03-10"),
 *     @OA\Property(property="payment", type="number", format="float", example=100.50),
 *     @OA\Property(property="status", type="string", example="pending"),
 * )
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'brand', 'platform', 'due_date', 'payment', 'status',
    ];
}
