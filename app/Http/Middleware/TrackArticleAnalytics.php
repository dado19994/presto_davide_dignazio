<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ArticleAnalytics;
use Carbon\Carbon;

class TrackArticleAnalytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->routeIs('article.show')) {
            $article = $request->route('article');
            if ($article) {
                $today = Carbon::today()->toDateString();

                $analytics = ArticleAnalytics::firstOrCreate(
                    ['article_id' => $article->id, 'date' => $today],
                    ['views' => 0, 'clicks' => 0, 'favorites' => 0]
                );

                $analytics->increment('views');
            }
        }

        return $response;
    }
}
