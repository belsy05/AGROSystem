
Route::get('/Servicio', [ServicioController::class, 'index'])
->name('servicio.index');

Route::get('/Servicio/buscar', [ServicioController::class, 'index2'])
->name('servicio.index2');

Route::get('/Servicio/{id}', [ServicioController::class, 'show'])
->name('servicio.mostrar')->where('id', '[0-9]+');

Route::get('/Servicio/crear', [ServicioController::class, 'crear'])
->name('servicio.crear');

Route::post('Servicior/crear', [ServicioController::class, 'store'])
->name('servicio.guardar');

Route::get('/Servicio/{id}/editar', [ServicioController::class, 'edit'])
->name('servicio.edit')->where('id', '[0-9]+');

Route::put('/Servicio/{id}/editar', [ServicioController::class, 'update'])
->name('servicio.update')->where('id', '[0-9]+');

Route::get('/estado/{id}', [ServicioController::class, 'updateStatus'])
->name('status.update')->where('id', '[0-9]+');
