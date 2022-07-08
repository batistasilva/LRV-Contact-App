<?php

namespace App\Models;

use App\Scopes\FilterSearchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, FilterSearchScope;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'company_id', 'company->name'];
    public $searchColumns = ['first_name', 'last_name', 'email'];
    public $filterColumns = ['company_id'];

    /**
     * This function get a company that belongs to Contact
     * @return type
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('id', 'desc');
    }
}