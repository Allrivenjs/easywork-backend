<?php

namespace App\Traits;

trait AsReadTrait
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
