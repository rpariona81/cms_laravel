<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticias';

    /**
     * Los atributos que son mas asignables
     * 
     * @var array
     */
    protected $fillable = [
        'titulo','slug','entradilla','texto','fecha','autor','imagen'
    ];
}
