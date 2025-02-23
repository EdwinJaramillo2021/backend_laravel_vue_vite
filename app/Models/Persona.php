<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function documentos()
    {
        return $this->hasOne(Documento::class);
    }
}
