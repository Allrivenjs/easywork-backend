<?php

namespace App\Traits;

trait AsRead
{
    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsReadTo(): void
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }
}
