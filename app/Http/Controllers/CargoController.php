//funcion para editar los datos
    public function edit($id){
        $cargo = Cargo::findOrFail($id);
        return view('cargos.formularioEditarCargo')->with('cargo', $cargo);

    }

    //funcion para actualizar los datos
    public function update(Request $request, $id){

        $cargo = Cargo::findOrFail($id);
        $request->validate([
            'NombreDelCargo'=> [
                'required',
                'string',
                'max:40',
                'min:5',
                Rule::unique('cargos')->ignore($cargo->id),
            ],
            'DescripciónDelCargo'=>'required|string|max:150',
            'Sueldo'=>'required|numeric|min:1000.00|max:30000.00'
        ]);

        $cargo->NombreDelCargo = $request->input('NombreDelCargo');
        $cargo->DescripciónDelCargo = $request->DescripciónDelCargo;
        $cargo->Sueldo = $request->input('Sueldo');

        $creado = $cargo->save();

        if($creado){
            return redirect()->route('cargo.index')
                ->with('mensaje', 'El cargo fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }