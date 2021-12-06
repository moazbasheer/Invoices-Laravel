<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'Value_Status',
        'note',
        'Payment_Date'
    ];
    public function section() {
        return $this->belongsTo(Section::class);
    }
}
