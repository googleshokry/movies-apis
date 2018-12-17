<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelBasic;


class Actor extends ModelBasic
{

    protected $table = "actors";
    protected $primaryKey = "id";
    protected $fillable =['name'];
    public $timestamps = true;

}
