<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visualizacao;
use Illuminate\Support\Facades\Auth;

class TrackVisualizacao
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Só rastrear visualizações de imóveis
        if ($request->routeIs('site.imoveis.show') && $request->route('imovel')) {
            $this->trackVisualizacao($request, $request->route('imovel'));
        }
        
        return $response;
    }
    
    /**
     * Rastrear visualização do imóvel
     */
    private function trackVisualizacao(Request $request, $imovel)
    {
        try {
            // Detectar origem
            $origem = $this->detectarOrigem($request);
            
            // Obter informações do IP
            $ipInfo = $this->obterInfoIP($request->ip());
            
            Visualizacao::create([
                'imovel_id' => $imovel->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'origem' => $origem,
                'cidade' => $ipInfo['city'] ?? null,
                'estado' => $ipInfo['region'] ?? null,
                'pais' => $ipInfo['country'] ?? null,
                'visualizado_em' => now(),
            ]);
        } catch (\Exception $e) {
            // Log do erro mas não interrompe a requisição
            \Log::error('Erro ao rastrear visualização: ' . $e->getMessage());
        }
    }
    
    /**
     * Detectar origem da visualização
     */
    private function detectarOrigem(Request $request)
    {
        $referer = $request->header('referer');
        $userAgent = $request->userAgent();
        
        // Verificar se veio do WhatsApp
        if (str_contains($userAgent, 'WhatsApp')) {
            return 'whatsapp';
        }
        
        // Verificar referer
        if ($referer) {
            if (str_contains($referer, 'facebook.com')) {
                return 'facebook';
            }
            
            if (str_contains($referer, 'instagram.com')) {
                return 'instagram';
            }
            
            if (str_contains($referer, 'google.com') || str_contains($referer, 'google.')) {
                return 'google';
            }
        }
        
        // Verificar parâmetros da URL
        if ($request->has('utm_source')) {
            $utmSource = $request->get('utm_source');
            
            if (in_array($utmSource, ['facebook', 'instagram', 'whatsapp', 'google'])) {
                return $utmSource;
            }
        }
        
        // Verificar se tem parâmetro de origem
        if ($request->has('origem')) {
            $origem = $request->get('origem');
            
            if (in_array($origem, ['site', 'whatsapp', 'instagram', 'facebook', 'google'])) {
                return $origem;
            }
        }
        
        return 'site'; // Padrão
    }
    
    /**
     * Obter informações do IP (simplificado)
     */
    private function obterInfoIP($ip)
    {
        // Em produção, você pode usar um serviço como ipapi.co ou similar
        // Por enquanto, retornamos dados básicos
        
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return [
                'city' => 'Local',
                'region' => 'Local',
                'country' => 'BR'
            ];
        }
        
        // Para IPs reais, você pode fazer uma requisição para um serviço de geolocalização
        // Exemplo com ipapi.co (requer chave de API):
        /*
        try {
            $response = Http::get("http://ipapi.co/{$ip}/json/");
            return $response->json();
        } catch (\Exception $e) {
            return [];
        }
        */
        
        return [];
    }
}
