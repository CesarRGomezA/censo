<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Casa;

class CasasApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //cada respuesta regresa 20 casas
        $paginaActual = intval($request->input('pagina'));
        if (!$paginaActual) {
            $paginaActual = 1;
        }

        $numeroCasas = Casa::count();
        $numeroPaginas = ceil($numeroCasas / 20);
        $casas = Casa::where('id_user',$request->user()->id)->skip(($paginaActual - 1) * 20)->take(20)->get();
        
        $respuesta = array();
        $respuesta['total'] = $numeroCasas;
        $respuesta['paginas'] = $numeroPaginas;
        $respuesta['pagina_actual'] = $paginaActual;
        $respuesta['casas'] = $casas;

        return $respuesta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevaCasa = new Casa();
        $nuevaCasa->id_user = $request->user()->id;
        $nuevaCasa->calle = $request->input('calle');
        $nuevaCasa->numero = $request->input('numero');
        $nuevaCasa->numero_interno = $request->input('numero_interior');
        $nuevaCasa->colonia = $request->input('colonia');
        $nuevaCasa->numero_banos = $request->input('numero_banos');
        $nuevaCasa->numero_habitantes = $request->input('numero_habitantes');
        
        $respuesta = array();
        $respuesta['exito']= false;
        if ($nuevaCasa->save())
        {
            $respuesta['exito'] = true;
        }
        return $respuesta;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
