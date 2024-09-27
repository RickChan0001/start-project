<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\Autores;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index()
    {
        // Obtém todos os livros com seus autores associados
        $data = Livro::with("autores")->get();
        return view('livro.index', compact(['data']));
    }

    /**
     * Show the form for creating a new livro.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autor = Autores::orderBy("nome")->get();
        return view('livro.create', compact('autor'));
        // Obtém todos os autores para preencher o formulário de criação
       // $autores = Autores::orderBy('titulo')->get();
      //  return view('livro.create', compact('autores'));
    }

    /**
     * Store a newly created livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $autor = Autores::find($request->autor);

      
        $livro = new Livro();
        $livro->titulo = mb_strtoupper($request->titulo, "UTF-8");
        $livro->description = $request->description;
        $livro->autores()->associate($autor);
        $livro->save();


        return redirect()->route('livro.index');

    }

    /**
     * Display the specified livro.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $livro = Livro::find($id);

        if (isset($livro)) {
            return view('livro.show', compact('livro'));
        }

        return "<h1>Livro não encontrado</h1>";
    }

    /**
     * Show the form for editing the specified livro.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $livro = Livro::find($id);
        $autor = Autores::orderBy('nome')->get();

        if (isset($livro)) {
            return view('livro.edit', compact(['livro', 'autor']));
        }

        return "<h1>Livro não encontrado</h1>";
    }

    /**
     * Update the specified livro in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $livro = Livro::find($id);
        $autor = Autores::find($request->autor);

        if (isset($livro)) {
            $livro->titulo = mb_strtoupper($request->titulo, "UTF-8");
            $livro->description = $request->description;
            $livro->autores()->associate($autor);
            $livro->save();

            return redirect()->route('livro.index');
        }

        return "<h1>Autor não encontrado</h1>";
    }

    /**
     * Remove the specified livro from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $livro = Livro::find($id);

        if (isset($livro)) {
            $livro->delete();
            return redirect()->route('livro.index');
        }

        return "<h1>Livro não encontrado</h1>";
    }
}
