<?php

namespace App\Providers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

class BasicProvider extends ServiceProvider
{
    /**
     * @param RequestException $e
     * @return RedirectResponse|Redirector
     */
    protected function isExpired(RequestException $e)
    {
        if ($e->getCode() == 419/*fai il controllo del token*/) {
            session()->invalidate();
            session()->flush();
            return redirect('login');
        }
    }

    protected function setHeaders()
    {
        return [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ];
    }
}
