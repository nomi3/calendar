<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ScheduleController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mixtend Coding Test',
            'Accept' => 'application/json'
        ])->get('https://mixtend.github.io/schedule.json');

        if ($response->successful()) {
            $data = $response->json();
            Log::info($data);
            return view('schedule.index', ['data' => $data]);
        } else {
            $error = 'データを取得できませんでした。';
            return view('schedule.index', ['error' => $error]);
        }
    }
}
