<?php
declare(strict_types=1);

namespace App\Helper\Sentry;

class SentryHelper
{
    /**
     * Sentry constructor.
     * @param string $dsn
     */
    public function __construct(private string $dsn)
    {
        \Sentry\init(['dsn' => $this->dsn]);
    }

    /**
     * @param \Throwable $throwable
     */
    public function capture(\Throwable $throwable) {
        \Sentry\captureException($throwable);
    }
}
