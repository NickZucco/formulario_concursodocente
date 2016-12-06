<?php

/*
  |---------------------------------------------------------------
  | Application routes
  |---------------------------------------------------------------
 */

Route::get('/', function() {
    if (Auth::guest()) {
        return Redirect::to('auth/login');
    } else {
        return Redirect::to('datos');
    }
});
Route::get('/home', function() {
    if (Auth::guest()) {
        return Redirect::to('auth/login');
    } else {
        return Redirect::to('datos');
    }
});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
//Route::group(['domain' => 'ingenieria.bogota.unal.edu.co'], function () {
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('user/activation/{token}', 'Auth\AuthController@activateUser');

//});
//Información general de aspirantes
Route::get('datos', ['middleware' => 'auth', 'uses' => 'AspiranteController@show_info']);
Route::post('datos', ['middleware' => 'auth', 'uses' => 'AspiranteController@insert']);

Route::get('perfiles', ['middleware' => 'auth', 'uses' => 'PerfilController@show_info']);
Route::post('perfiles', ['middleware' => 'auth', 'uses' => 'PerfilController@insert']);
//Ensayos por perfil
Route::get('perfiles/ensayos', ['middleware' => 'auth', 'uses' => 'PerfilController@show_essays']);
Route::post('perfiles/ensayos', ['middleware' => 'auth', 'uses' => 'PerfilController@insertEssays']);

Route::get('vinculaciones', ['middleware' => 'auth', 'uses' => 'VinculacionController@show_info']);
Route::post('vinculaciones', ['middleware' => 'auth', 'uses' => 'VinculacionController@insert']);
Route::post('vinculaciones/delete', ['middleware' => 'auth', 'uses' => 'VinculacionController@delete']);

Route::get('estudios', ['middleware' => 'auth', 'uses' => 'EstudioController@show_info']);
Route::post('estudios', ['middleware' => 'auth', 'uses' => 'EstudioController@insert']);
Route::post('estudios/delete', ['middleware' => 'auth', 'uses' => 'EstudioController@delete']);

Route::get('distinciones', ['middleware' => 'auth', 'uses' => 'DistincionController@show_info']);
Route::post('distinciones', ['middleware' => 'auth', 'uses' => 'DistincionController@insert']);
Route::post('distinciones/delete', ['middleware' => 'auth', 'uses' => 'DistincionController@delete']);

Route::get('experiencia_laboral', ['middleware' => 'auth', 'uses' => 'ExperienciaLaboralController@show_info']);
Route::post('experiencia_laboral', ['middleware' => 'auth', 'uses' => 'ExperienciaLaboralController@insert']);
Route::post('experiencia_laboral/delete', ['middleware' => 'auth', 'uses' => 'ExperienciaLaboralController@delete']);

Route::get('experiencia_docente', ['middleware' => 'auth', 'uses' => 'ExperienciaDocenteController@show_info']);
Route::post('experiencia_docente', ['middleware' => 'auth', 'uses' => 'ExperienciaDocenteController@insert']);
Route::post('experiencia_docente/delete', ['middleware' => 'auth', 'uses' => 'ExperienciaDocenteController@delete']);

Route::get('experiencia_investigativa', ['middleware' => 'auth', 'uses' => 'ExperienciaInvestigativaController@show_info']);
Route::post('experiencia_investigativa', ['middleware' => 'auth', 'uses' => 'ExperienciaInvestigativaController@insert']);
Route::post('experiencia_investigativa/delete', ['middleware' => 'auth', 'uses' => 'ExperienciaInvestigativaController@delete']);

Route::get('produccion_intelectual', ['middleware' => 'auth', 'uses' => 'ProduccionIntelectualController@show_info']);
Route::post('produccion_intelectual', ['middleware' => 'auth', 'uses' => 'ProduccionIntelectualController@insert']);
Route::post('produccion_intelectual/delete', ['middleware' => 'auth', 'uses' => 'ProduccionIntelectualController@delete']);

Route::get('areas_interes', ['middleware' => 'auth', 'uses' => 'AreasInteresController@show_info']);
Route::post('areas_interes', ['middleware' => 'auth', 'uses' => 'AreasInteresController@insert']);
Route::post('areas_interes/delete', ['middleware' => 'auth', 'uses' => 'AreasInteresController@delete']);

Route::get('idiomas', ['middleware' => 'auth', 'uses' => 'IdiomaCertificadoController@show_info']);
Route::post('idiomas', ['middleware' => 'auth', 'uses' => 'IdiomaCertificadoController@insert']);
Route::post('idiomas/delete', ['middleware' => 'auth', 'uses' => 'IdiomaCertificadoController@delete']);

Route::get('cerrar_formulario', ['middleware' => 'auth', 'uses' => 'AspiranteController@show_close_form']);
Route::post('cerrar_formulario', ['middleware' => 'auth', 'uses' => 'AspiranteController@close_form']);

//Interfaz de consulta de registrados
Route::get('admin/login', 'Admin\AdminController@getLogin');
Route::get('admin/logout', 'Admin\AdminController@getLogout');
Route::post('admin/login', 'Admin\AdminController@postLogin');

Route::get('admin/logout', 'Admin\AdminController@getLogout');
Route::get('admin/candidatos', 'Admin\AdminController@showCandidates');
//Detalle de candidatos
Route::get('admin/candidato/{id}', 'Admin\AdminController@showCandidateDetails');
//Reportes
Route::get('admin/candidato/{id}/reporte/', 'Admin\ReporteController@reportePrueba');
