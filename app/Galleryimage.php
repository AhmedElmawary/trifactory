<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galleryimage extends Model
{

    protected $table='galleryimages';

    protected $primaryKey='id';

    protected $fillable = [
       'gallery_id','image','created_at','updated_at'
    ];
    //
    public function gallery()
    {
        return $this->belongsTo('App\Gallery', 'gallery_id');
    }
}
