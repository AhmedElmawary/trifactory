<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table='gallery';

    protected $primaryKey='id';

    protected $fillable = [
       'name','created_at','updated_at'
    ];
    //
    public function galleryimage()
    {
        return $this->hasMany('App\Galleryimage');
    }
}
