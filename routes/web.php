<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


// ROTAS PARA ACESSAR PRODUTOS e DEPARTAMENTOS
Route::get('/produtos', 'ProdutoControlador@index')->name('produtos');

Route::get('/departamentos', 'DepartamentoControlador@index')->name('departamentos');

Route::get('/usuario', function(){
    return view('usuario');
});

Route::get('/negado', function(){
    return 'Acesso negado!';
})->name('negado');


// FORMA de SALVAR o USUÁRIO REGISTRADO na SESSÃO
Route::post('/login',function(Request $request){

    $login_ok = false;
    $admin = false;
    
    switch($request->input('user')){
        case 'joao':
            $login_ok = $request->input('passwd') === "senhajoao";
            $admin = true;
        break;
        case 'marcos':
            $login_ok = $request->input('passwd') === "senhamarcos";
            break;
        case 'default':
            $login_ok = false;
    }

    if($login_ok){
        $login = ['user' => $request->input('user'), 'admin' => $admin];
        $request->session()->put('login', $login); //Põe na sessão a variável 'login'
        return response('Login OK', 200);
    }else{
        $request->session()->flush(); // Apaga tudo que estiver na sessao deste usuário caso estivesse logado e errou a senha ao entrar novamente
        return response('Erro no Login', 404);
    }
});


Route::get('/logout', function(Request $request){
    $request->session()->flush();
    return response('Deslogado com sucesso', 200);
});

// Rotas criadas pelo 'auth' do laravel
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
