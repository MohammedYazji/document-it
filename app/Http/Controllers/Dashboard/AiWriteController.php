<?php

namespace App\Http\Controllers\Dashboard;

use App\Ai\Agents\WriterAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiWriteController extends Controller
{
    public function __invoke(Request $request, WriterAgent $writerAgent)
    {
        $message = $request->validate(['message' => 'required|string'])['message'];

        return response()->stream(function () use ($writerAgent, $message) {
            try {
                $response = $writerAgent->stream(
                    "Write a complete blog post about: {$message}"
                );

                foreach ($response as $event) {
                    if ($event instanceof \Laravel\Ai\Streaming\Events\TextDelta) {
                        echo "data: " . json_encode(['delta' => $event->delta]) . "\n\n";
                        @ob_flush();
                        flush();
                    }
                }
            } catch (\Throwable $e) {
                echo "data: " . json_encode(['error' => $e->getMessage()]) . "\n\n";
                @ob_flush();
                flush();
            }

            echo "data: [DONE]\n\n";
            @ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
