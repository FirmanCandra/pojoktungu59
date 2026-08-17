<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\PageView;
use App\Models\WorkProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getStatsData();

        return view('admin.dashboard', array_merge($stats, [
            'recentArticles' => Article::with('user')->latest()->take(5)->get(),
        ]));
    }

    public function apiData(): JsonResponse
    {
        $stats = $this->getStatsData();
        $recent = Article::with('user')->latest()->take(5)->get()->map(function ($art) {
            return [
                'id'         => $art->id,
                'title'      => \Illuminate\Support\Str::limit($art->title, 35),
                'edit_url'   => route('admin.artikel.edit', $art->id),
                'date'       => $art->created_at->format('d M Y'),
                'status'     => $art->status,
                'status_str' => strtoupper($art->status),
            ];
        });

        return response()->json(array_merge($stats, [
            'recent_articles' => $recent,
            'timestamp'       => now()->format('H:i:s'),
        ]));
    }

    private function getStatsData(): array
    {
        $totalArticles     = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles     = Article::where('status', 'draft')->count();
        $totalPrograms     = WorkProgram::count();
        $runningPrograms   = WorkProgram::where('status', 'berjalan')->count();
        $completedPrograms = WorkProgram::where('status', 'selesai')->count();
        $unreadMessages    = ContactMessage::unread()->count();

        // Visitor stats
        $totalVisitors   = PageView::totalUniqueVisitors();
        $todayVisitors   = PageView::todayUniqueVisitors();

        // 7-day daily visitor chart
        $dailyData     = PageView::dailyVisitors(7);
        $visitorLabels = array_keys($dailyData);
        $visitorCounts = array_values($dailyData);

        // 6 Month Article & Message chart
        $chartLabels     = [];
        $chartArticles   = [];
        $chartMessages   = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');

            $chartArticles[] = Article::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartMessages[] = ContactMessage::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return [
            'totalArticles'     => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'draftArticles'     => $draftArticles,
            'totalPrograms'     => $totalPrograms,
            'runningPrograms'   => $runningPrograms,
            'completedPrograms' => $completedPrograms,
            'unreadMessages'    => $unreadMessages,
            'totalVisitors'     => $totalVisitors,
            'todayVisitors'     => $todayVisitors,
            'visitorLabels'     => $visitorLabels,
            'visitorCounts'     => $visitorCounts,
            'chartLabels'       => $chartLabels,
            'chartArticles'     => $chartArticles,
            'chartMessages'     => $chartMessages,
        ];
    }
}
