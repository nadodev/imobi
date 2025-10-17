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
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CRMController;
use App\Http\Controllers\Admin\GestaoImovelController;

/*
|--------------------------------------------------------------------------
| Web Routes - Área Pública
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Imóveis
Route::prefix('imoveis')->name('imoveis.')->group(function () {
    Route::get('/', [SiteImovelController::class, 'index'])->name('index');
    Route::get('/{slug}', [SiteImovelController::class, 'show'])->name('show')->middleware('track.visualizacao');
});

// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [App\Http\Controllers\Site\BlogController::class, 'index'])->name('index');
    Route::get('/categoria/{categoria}', [App\Http\Controllers\Site\BlogController::class, 'categoria'])->name('categoria');
    Route::get('/{slug}', [App\Http\Controllers\Site\BlogController::class, 'show'])->name('show');
});

// Avaliações
Route::prefix('avaliacoes')->name('avaliacoes.')->group(function () {
    Route::post('/', [App\Http\Controllers\Site\AvaliacaoController::class, 'store'])->name('store');
    Route::get('/{imovelId}', [App\Http\Controllers\Site\AvaliacaoController::class, 'getAvaliacoes'])->name('get');
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
    
    // Imóveis - Rotas explícitas
    Route::get('imoveis', [ImovelController::class, 'index'])->name('imoveis.index');
    Route::get('imoveis/create', [ImovelController::class, 'create'])->name('imoveis.create');
    Route::post('imoveis', [ImovelController::class, 'store'])->name('imoveis.store');
    Route::get('imoveis/{imovel}', [ImovelController::class, 'show'])->name('imoveis.show');
    Route::get('imoveis/{imovel}/edit', [ImovelController::class, 'edit'])->name('imoveis.edit');
    Route::put('imoveis/{imovel}', [ImovelController::class, 'update'])->name('imoveis.update');
    Route::delete('imoveis/{imovel}/delete', [ImovelController::class, 'destroy'])->name('imoveis.destroy');
    
    Route::delete('imoveis/{imovel}/imagens/{id}', [ImovelController::class, 'deleteImage'])
        ->name('imoveis.imagens.delete');
    
    // Agendamentos
    Route::get('agendamentos/calendario', [AgendamentoController::class, 'calendario'])->name('agendamentos.calendario');
    Route::get('agendamentos/data', [AgendamentoController::class, 'getAgendamentosData'])->name('agendamentos.data');
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
    
    // Banners
    Route::resource('banners', BannerController::class);
    
    // CRM
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('/', [CRMController::class, 'dashboard'])->name('dashboard');
        
        // Leads
        Route::get('leads', [CRMController::class, 'leads'])->name('leads');
        Route::get('leads/create', [CRMController::class, 'createLead'])->name('leads.create');
        Route::post('leads', [CRMController::class, 'storeLead'])->name('leads.store');
        Route::get('leads/{lead}/edit', [CRMController::class, 'editLead'])->name('leads.edit');
        Route::put('leads/{lead}', [CRMController::class, 'updateLead'])->name('leads.update');
        Route::delete('leads/{lead}', [CRMController::class, 'destroyLead'])->name('leads.destroy');
        
        // Tarefas
        Route::get('tarefas', [CRMController::class, 'tarefas'])->name('tarefas');
        Route::get('tarefas/create', [CRMController::class, 'createTarefa'])->name('tarefas.create');
        Route::post('tarefas', [CRMController::class, 'storeTarefa'])->name('tarefas.store');
        Route::post('tarefas/{tarefa}/concluir', [CRMController::class, 'concluirTarefa'])->name('tarefas.concluir');
        
        // Funil de vendas
        Route::get('funil', [CRMController::class, 'funilVendas'])->name('funil');
        
        // Relatórios
        Route::get('relatorios', [CRMController::class, 'relatorios'])->name('relatorios');
    });
    
    // Gestão de Imóveis
    Route::prefix('gestao-imoveis')->name('gestao-imoveis.')->group(function () {
        Route::get('/', [GestaoImovelController::class, 'index'])->name('index');
        Route::get('dashboard', [GestaoImovelController::class, 'dashboard'])->name('dashboard');
        Route::get('{imovel}', [GestaoImovelController::class, 'show'])->name('show');
        Route::get('{imovel}/edit', [GestaoImovelController::class, 'edit'])->name('edit');
        Route::put('{imovel}', [GestaoImovelController::class, 'update'])->name('update');
        Route::get('{imovel}/relatorio', [GestaoImovelController::class, 'relatorio'])->name('relatorio');
    });
    
    // Blog
    Route::resource('artigos', App\Http\Controllers\Admin\ArtigoController::class);
    Route::resource('categorias', App\Http\Controllers\Admin\CategoriaController::class);
    
    // Avaliações
    Route::resource('avaliacoes', App\Http\Controllers\Admin\AvaliacaoController::class)
        ->only(['index', 'show', 'update', 'destroy']);
    Route::post('avaliacoes/{avaliacao}/aprovar', [App\Http\Controllers\Admin\AvaliacaoController::class, 'aprovar'])->name('avaliacoes.aprovar');
    Route::post('avaliacoes/{avaliacao}/rejeitar', [App\Http\Controllers\Admin\AvaliacaoController::class, 'rejeitar'])->name('avaliacoes.rejeitar');
});

require __DIR__.'/auth.php';
