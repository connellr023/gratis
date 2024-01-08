<?php
declare(strict_types = 1);

namespace Gratis\Tests\Unit\Stubs;

abstract class AbstractTriggerTracker
{
    private bool $triggered;

    public function __construct()
    {
        $this->triggered = false;
    }

    public function trigger(): void
    {
        $this->triggered = true;
    }

    public function is_triggered(): bool
    {
        return $this->triggered;
    }
}