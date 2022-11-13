<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    //
    public function index()
    {
        //Obtengo las noticias a mostrar en la home
        $rowset = Noticia::where('activo', 1)->where('home', 1)->orderBy('fecha', 'DESC')->get();
        
        return view('app.index',[
        'rowset' => $rowset,
        ]);
    }

    public function noticias()
    {
        //obtener noticias a mostrar en el listado de noticias
        $rowset = Noticia::where('activo',1)->orderBy('fecha','DESC')->get();

        return view('app.noticias',[
            'rowset' => $rowset,
        ]);
    }

    public function noticia($slug)
    {
        //obtener una noticia o mostrar error
        $row = Noticia::where('activo',1)->where('slug',$slug)->firstOrFail();

        return view('app.noticia',[
            'row' => $row,
        ]);
    }

    public function acercade()
    {
        //$row = new \stdClass();
        //$row['version'] = DB::select( DB::raw("select @@version as version"));
        $row = DB::select( DB::raw("select @@version as version"));
        //$row = DB::connection()->getDatabaseName();
        $result = array_map(function ($value) {
            return (array)$value;
        }, $row);

        //return dd($result['0']['version']);

        //$ArrayRow = array('versionDB' => json_decode(json_encode($row)));

        return view('app.acerca-de',[
            'row' => $result['0']['version'],
        ]);
    }
}
