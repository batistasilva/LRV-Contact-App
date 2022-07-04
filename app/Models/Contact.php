<?php

namespace App\Models;
use App\Scopes\FilterScope;
use App\Scopes\ContactSearchScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'company_id'
    ];

    public $filterColums = ['company_id'];
    
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function scopelatestFirst($query) {
        return $query->orderBy('id', 'desc');
    }
    
    protected static function boot() {
        parent::boot();
        static ::addGlobalScope(new FilterScope);
        static ::addGlobalScope(new ContactSearchScope);
    }
}
