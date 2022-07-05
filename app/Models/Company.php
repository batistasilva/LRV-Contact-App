<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model {

    use HasFactory;

    // protected $table = "companies";
    protected $fillable = ['name', 'address', 'email', 'website'];
    public $searchColumns = ['name', 'address', 'email', 'website'];  
    
    public function contacts() {
        return $this->hasMany(Contact::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function userCompanies() {
        return self::withoutGlobalScope(SearchScope::class)
                        ->where('user_id', auth()->id())
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->prepend('All Companies', '');
    }

}
