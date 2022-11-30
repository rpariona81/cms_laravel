<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    //
    public function __construct()
    {
        /**
         * Asigno el middleware auth al controlador
         * de modo que sea necesario estar al menos autenticado
         */
        $this->middleware('auth');
    }

    /**
     * Mostrar un listado de elementos
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtengo todas las noticias ordenadas por fecha más reciente
        $rowset = Noticia::orderBy('fecha','DESC')->get();

        return view('admin.noticias.index',[
            'rowset' => $rowset,
        ]);
    }

    /**
     * Mostrar el formulario para crear un nuevo elemento
     * 
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        
    }
    
}
