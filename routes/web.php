<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ImovelController as SiteImovelController;
use App\Http\Controllers\Site\AgendamentoController as SiteAgendamentoController;
use App\Http\Controllers\Site\ContatoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImovelController;
use App\Http\Controllers\Admin\AgendamentoController;
use App\Http\Controllers\Admin\MensagemController;
use App\Http\Controllers\Admin\TipoController;
use App\Http\Controllers\Admin\FinalidadeController;
use App\Http\Controllers\Admin\ConfiguracaoController;

/*
|--------------------------------------------------------------------------
| Web Routes - Área Pública
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Imóveis
Route::prefix('imoveis')->name('imoveis.')->group(function () {
    Route::get('/', [SiteImovelController::class, 'index'])->name('index');
    Route::get('/{slug}', [SiteImovelController::class, 'show'])->name('show');
});

// Agendamentos
Route::post('/agendamentos', [SiteAgendamentoController::class, 'store'])->name('agendamentos.store');

// Contato
Route::get('/contato', [ContatoController::class, 'index'])->name('contato');
Route::post('/contato', [ContatoController::class, 'store'])->name('contato.store');

/*
|--------------------------------------------------------------------------
| Web Routes - Área Administrativa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Imóveis
    Route::resource('imoveis', ImovelController::class);
    Route::delete('imoveis/{imovel}/imagens/{id}', [ImovelController::class, 'deleteImage'])
        ->name('imoveis.imagens.delete');
    
    // Agendamentos
    Route::resource('agendamentos', AgendamentoController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    
    // Mensagens
    Route::resource('mensagens', MensagemController::class)
        ->only(['index', 'show', 'destroy']);
    Route::post('mensagens/{mensagem}/responder', [MensagemController::class, 'responder'])
        ->name('mensagens.responder');
    
    // Tipos
    Route::resource('tipos', TipoController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    
    // Finalidades
    Route::resource('finalidades', FinalidadeController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    
    // Configurações
    Route::get('configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
    Route::put('configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

require __DIR__.'/auth.php';
