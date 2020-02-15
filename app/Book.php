<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';      
    protected $guarded = ['id'];

    public function loan()
    {
        return $this->hasMany('App\Loan');
    }
}