<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Endereco;
use App\Models\Startup;
use App\Http\Requests\StoreEnderecoRequest;
use Illuminate\Support\Facades\Storage;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     * @param Startup $startup : id startup
     * @return \Illuminate\Http\Response
     */

    public function create($startup)
    {
        $startup = Startup::find($startup);
        $this->authorize('update', $startup);

        if ($startup->endereco == null){
            return view('enderecos.create', compact('startup'));
        }
        else{
            return redirect(route('startups.index', $startup))->with(['error' => 'Endereço já foi criado!']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($startup, StoreEnderecoRequest $request)
    {
        $startup = Startup::find($startup);
        $this->authorize('update', $startup);

        $endereco = new Endereco();
        $this->set_attributes($endereco, $request->all());
        $endereco->startup_id = $startup->id;
        $endereco->save();

        if(!is_null($startup->documentos->first()) && !is_null($startup->telefones->first())){
            return redirect()->route('startups.index')->with('message', 'Startup criada com sucesso!');
        }

        return redirect()->back()->with(['message' => 'Endereço salvo com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($startup, $endereco)
    {
        $startup = Startup::find($startup);
        $endereco = Endereco::find($endereco);

        return $endereco;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($startup, $endereco)
    {
        $endereco = Endereco::find($endereco);
        $this->authorize('update', $endereco);

        $startup = Startup::find($startup);
        $this->authorize('update', $startup);

        return view('enderecos.edit', compact('startup','endereco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEnderecoRequest  $request
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEnderecoRequest $request, $startup, $endereco)
    {
        $endereco = Endereco::find($endereco);
        $this->authorize('update', $endereco);

        $startup = Startup::find($startup);
        $this->authorize('update', $startup);

        $this->set_attributes($endereco, $request->all());

        $endereco->update();

        if(is_null($startup->documentos->first()) || is_null($startup->telefones->first())){
            return redirect()->back()->with(['message' => 'Endereço atualizado com sucesso!']);
        }

        return redirect(route('startups.show', $startup))->with(['message' => 'Endereço atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return abort(404);
    }

    private function set_attributes(Endereco $endereco, $array_inputs)
    {
        $endereco->rua = $array_inputs['rua'];
        $endereco->bairro = $array_inputs['bairro'];
        $endereco->numero = $array_inputs['numero'];
        $endereco->cidade = $array_inputs['cidade'];
        $endereco->estado = $array_inputs['estado'];
        $endereco->complemento = $array_inputs['complemento'];
        $endereco->cep = $array_inputs['cep'];
    }
}





