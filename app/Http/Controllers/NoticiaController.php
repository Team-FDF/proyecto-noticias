<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::all();
        return view('noticias.index', ['noticias' => $noticias]);
    }

    public function create()
    {
        return view('noticias.create');
    }

    public function store(Request $request)
    {
        $bannerPath = '';
        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(storage_path('app/public/noticias/'), $filename);
            $bannerPath = url('storage/noticias/' . $filename);
        }

        Noticia::create([
            'titulo' => $request->titulo,
            'lead' => $request->lead,
            'descripcion' => $request->descripcion,
            'banner' => $bannerPath,
            'imagen_lateral' => $request->imagen_lateral ?? '',
            'estado' => $request->estado,
        ]);
        return redirect(url('/noticias'));
    }

    public function edit($id)
    {
        $noticia = Noticia::find($id);
        return view('noticias.edit', ['noticia' => $noticia]);
    }

    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);
        $imagenVieja = $noticia->banner;
        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;
        $noticia->estado = $request->estado;

        
        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(storage_path('app/public/noticias/'), $filename);
            $noticia->banner = url('storage/noticias/' . $filename);

            
            if ($imagenVieja) {
                $this->eliminarImagenFisica($imagenVieja);
            }
        }

        $noticia->save();
        return redirect(url('/noticias'));
    }

    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        
        
        if ($noticia->banner) {
            $this->eliminarImagenFisica($noticia->banner);
        }
        
        $noticia->delete();
        return redirect(url('/noticias'));
    }

    private function eliminarImagenFisica($urlImagen)
    {
      
        if (!str_starts_with($urlImagen, url('storage'))) {
            return;
        }
        
    
        $rutaFisica = str_replace(
            url('storage/'),
            storage_path('app/public/'),
            $urlImagen
        );
        

        if (file_exists($rutaFisica)) {
            unlink($rutaFisica);
        }
    }
} 