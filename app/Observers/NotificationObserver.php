<?php

namespace App\Observers;

class NotificationObserver
{
    public function creating($model)
    {
        \Log::info("model ". json_encode( $model ) );
        // here set the column data for your new column
    }
}
