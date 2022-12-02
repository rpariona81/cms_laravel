<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticiaRequest;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        //Creo una nueva noticia vacía
        $row = new Noticia();

        return view('admin.noticias.editar',[
            'row' => $row,
        ]);
    }

    /**
     * Guardar un nuevo elemento en la BBDD
     * 
     * @param \App\Http\Requests\NoticiaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(NoticiaRequest $request)
    {
        $row = Noticia::create([
            'titulo' => $request->titulo,
            'entradilla' => $request->entradilla,
            'slug' => $this->getSlug($request->titulo),
            'texto' => $request->texto,
            'fecha' => \DateTime::createFromFormat('d-m-Y', $request->fecha)->format('Y-m-d H:i:s'),
            'autor' => $request->autor,
        ]);

        //Imagen
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = $archivo->getClientOriginalName();
            $archivo->move(public_path().'/img/', $nombre);
            Noticia::where('id', $row->id)->update(['imagen' => $nombre]);
            $texto = ' e imagen subida.';
        }else{
            $texto = '.';
        }

        return redirect('admin/noticias')->with('success', 'Noticia <strong>'.$request->titulo.'</strong> creada'.$texto);
    }
    
    /**
     * Mostrar formulario para editar un elemento
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        //Obtengo la noticia o muestro error
        $row = Noticia::where('id', $id)->firstOrFail();

        return view('admin.noticias.editar',[
            'row' => $row,
        ]);
    }

    /**
     * Actualizar un elemento en la bbdd
     * 
     * @param \App\Http\Requests\NoticiaRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(NoticiaRequest $request, $id)
    {
        $row = Noticia::findOrFail($id);

        Noticia::where('id', $row->id)->update([
            'titulo' => $request->titulo,
            'entradilla' => $request->entradilla,
            'slug' => $this->getSlug($request->titulo),
            'texto' => $request->texto,
            'fecha' => \DateTime::createFromFormat('d-m-Y', $request->fecha)->format('Y-m-d H:i:s'),
            'autor' => $request->autor,
        ]);

        //Imagen
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = $archivo->getClientOriginalExtension();
            $archivo->move(public_path().'/img/', $nombre);
            Noticia::where('id', $row->id)->update(['imagen' => $nombre]);
            $texto = ' e imagen subida.';
        }else{
            $texto = '.';
        }

        return redirect('admin/noticias')->with('success', 'Noticia <strong>'.$request->titulo.'</strong> guardada'.$texto);
    }

    /**
     * Activar o desactivar elemento
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activar($id)
    {
        $row = Noticia::findOrFail($id);
        $valor = ($row->activo) ? 0 : 1;
        $texto = ($row->activo) ? 'desactivada' : 'activada';

        Noticia::where('id', $row->id)->update(['activo' => $valor]);

        return redirect('admin/noticias')->with('success', 'Noticias <strong>'.$row->titulo.'</strong> '.$texto.'.');
    }

    /**
     * Mostrar o no elemento en la home
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function home($id)
    {
        $row = Noticia::findOrFail($id);
        $valor = ($row->home) ? 0 : 1;
        $texto = ($row->activo) ? 'desactivada' : 'activada';

        Noticia::where('id', $row->id)->update(['home' => $valor]);

        return redirect('admin/noticias')->with('success', 'Noticia <strong>'.$row->titulo.'</strong> '.$texto.'.');
    }


    /**
     * Borrar elemento (e imagen asociada si es que existe)
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function borrar($id)
    {
        $row = Noticia::findOrFail($id);

        Noticia::destroy($row->id);

        //Borrar imagen
        $imagen = public_path().'/img/'.$row->imagen;
        if (file_exists($imagen)) {
            unlink($imagen);
        }

        return redirect('admin/noticias')->with('success','Noticia <strong>'.$row->titulo.'</strong> borrada.');
    }

    //Función para generar el slug a partir de un string
    public function getSlug($str)
    {
        //Quito acentos y caracteres extraños
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë',
            'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø',
            'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å',
            'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò',
            'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā',
            'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č',
            'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę',
            'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ',
            'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ',
            'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ',
            'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ',
            'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ',
            'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ',
            'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů',
            'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż',
            'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ',
            'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ',
            'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a',
            'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o',
            'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A',
            'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C',
            'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E',
            'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H',
            'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I',
            'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L',
            'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n',
            'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r',
            'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't',
            'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u',
            'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z',
            'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I',
            'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U',
            'u', 'A', 'a', 'AE', 'ae', 'O', 'o');

        $sin_acentos = str_replace($a, $b, $str);

        //genero slug
        return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $sin_acentos),'UTF-8');

    }


}