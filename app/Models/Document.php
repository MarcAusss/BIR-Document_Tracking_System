<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'taxpayer_name',
        'taxable_period',
        'docket_owner',
        'document_type',
        'RDO', // Add RDO to fillable fields
        'status',
        'date_received',
    ];

    // Cast date_received as a date
    protected $casts = [
        'date_received' => 'date',
    ];
}
