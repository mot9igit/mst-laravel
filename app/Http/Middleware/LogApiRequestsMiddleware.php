<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequestsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        if(!$user) return $next($request);

        $startTime = microtime(true);

        $log = RequestLog::create([
            'user_id' => $user->id,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'duration' => 0,
            'user_agent' => $request->userAgent(),
            'request_body' => json_encode($request->all(), true),
        ]);

        $request->attributes->add([
            'api_log_id' => $log->id,
            'api_log_start_time' => $startTime
        ]);

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $logId = $request->attributes->get('api_log_id');
        $startTime = $request->attributes->get('api_log_start_time');

        if($logId) {
            $log = RequestLog::find($logId);
            $duration = (microtime(true) - $startTime) * 1000;

            $updateData = [
                'status_code' => $response->getStatusCode(),
                'duration' => $duration,
            ];

            $content = $response->getContent();

            if (!empty($content)) {
                $decoded = json_decode($content, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $updateData['response_body'] = $decoded;
                } else {
                    $updateData['response_body'] = [
                        'raw_response' => $content,
                        'is_json' => false
                    ];
                }
            } else {
                $updateData['response_body'] = ['message' => 'Empty response'];
            }

            $log->update($updateData);

        }
    }
}
