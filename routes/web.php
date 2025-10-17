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
// Sobre (deve vir antes das rotas com {slug})
Route::get('/sobre', [App\Http\Controllers\Site\SobreController::class, 'index'])->name('sobre.index');

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

// Newsletter
Route::post('/newsletter/inscrever', [App\Http\Controllers\Site\NewsletterController::class, 'inscrever'])->name('newsletter.inscrever');

// CSRF Token
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf-token');

            // Favoritos
            Route::prefix('favoritos')->name('favoritos.')->middleware('auth')->group(function () {
                Route::get('/', [App\Http\Controllers\Site\FavoritoController::class, 'index'])->name('index');
                Route::post('/toggle', [App\Http\Controllers\Site\FavoritoController::class, 'toggle'])->name('toggle');
                Route::get('/check/{imovel}', [App\Http\Controllers\Site\FavoritoController::class, 'check'])->name('check');
                Route::delete('/{imovel}', [App\Http\Controllers\Site\FavoritoController::class, 'destroy'])->name('destroy');
            });

// Chat
Route::prefix('chat')->name('chat.')->group(function () {
    Route::post('/iniciar', [App\Http\Controllers\Site\ChatController::class, 'iniciarConversa'])->name('iniciar');
    Route::post('/enviar', [App\Http\Controllers\Site\ChatController::class, 'enviarMensagem'])->name('enviar');
    Route::get('/mensagens', [App\Http\Controllers\Site\ChatController::class, 'obterMensagens'])->name('mensagens');
    Route::get('/novas-mensagens', [App\Http\Controllers\Site\ChatController::class, 'verificarNovasMensagens'])->name('novas-mensagens');
    Route::post('/encerrar', [App\Http\Controllers\Site\ChatController::class, 'encerrarConversaCliente'])->name('encerrar');
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
    
    // Chat
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('index');
        Route::get('/{conversa}', [App\Http\Controllers\Admin\ChatController::class, 'show'])->name('show');
        Route::post('/enviar', [App\Http\Controllers\Admin\ChatController::class, 'enviarMensagem'])->name('enviar');
        Route::get('/{conversa}/mensagens', [App\Http\Controllers\Admin\ChatController::class, 'obterMensagens'])->name('mensagens');
        Route::get('/{conversa}/novas-mensagens', [App\Http\Controllers\Admin\ChatController::class, 'verificarNovasMensagens'])->name('novas-mensagens');
        Route::post('/{conversa}/encerrar', [App\Http\Controllers\Admin\ChatController::class, 'encerrarConversa'])->name('encerrar');
        Route::post('/{conversa}/reativar', [App\Http\Controllers\Admin\ChatController::class, 'reativarConversa'])->name('reativar');
        Route::get('/dashboard/dados', [App\Http\Controllers\Admin\ChatController::class, 'dashboard'])->name('dashboard');
    });

    // Página Sobre
    Route::resource('pagina-sobre', App\Http\Controllers\Admin\PaginaSobreController::class)
        ->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('pagina-sobre/{paginaSobre}/toggle-status', [App\Http\Controllers\Admin\PaginaSobreController::class, 'toggleStatus'])->name('pagina-sobre.toggle-status');
    
    // Galeria Sobre
    Route::get('pagina-sobre/{paginaSobre}/galeria', [App\Http\Controllers\Admin\GaleriaSobreController::class, 'index'])->name('galeria-sobre.index');
    Route::post('pagina-sobre/{paginaSobre}/galeria', [App\Http\Controllers\Admin\GaleriaSobreController::class, 'store'])->name('galeria-sobre.store');
    Route::put('galeria-sobre/{galeriaSobre}', [App\Http\Controllers\Admin\GaleriaSobreController::class, 'update'])->name('galeria-sobre.update');
    Route::delete('galeria-sobre/{galeriaSobre}', [App\Http\Controllers\Admin\GaleriaSobreController::class, 'destroy'])->name('galeria-sobre.destroy');
    Route::post('galeria-sobre/{galeriaSobre}/toggle-status', [App\Http\Controllers\Admin\GaleriaSobreController::class, 'toggleStatus'])->name('galeria-sobre.toggle-status');
    
    // Newsletter
    Route::resource('newsletter', App\Http\Controllers\Admin\NewsletterController::class)
        ->only(['index', 'store', 'destroy']);
    Route::post('newsletter/{newsletter}/toggle-status', [App\Http\Controllers\Admin\NewsletterController::class, 'toggleStatus'])->name('newsletter.toggle-status');
    Route::get('newsletter/enviar', [App\Http\Controllers\Admin\NewsletterController::class, 'showEnvioForm'])->name('newsletter.enviar');
    Route::post('newsletter/enviar', [App\Http\Controllers\Admin\NewsletterController::class, 'enviarNewsletter'])->name('newsletter.enviar.post');
    Route::get('newsletter/envio/{envio}', [App\Http\Controllers\Admin\NewsletterController::class, 'showEnvio'])->name('newsletter.show-envio');

    // Client Dashboard Routes
    Route::prefix('cliente')->name('cliente.')->middleware('auth')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Cliente\DashboardController::class, 'index'])->name('dashboard');
        Route::get('conversas', [App\Http\Controllers\Cliente\ConversaController::class, 'index'])->name('conversas.index');
        Route::get('conversas/{conversa}', [App\Http\Controllers\Cliente\ConversaController::class, 'show'])->name('conversas.show');
    });
});

require __DIR__.'/auth.php';
