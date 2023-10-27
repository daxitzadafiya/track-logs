# About Logavel Track Logs

Add this line in App/Exceptions/Handler.php

## App/Exceptions/Handler.php

```php
use Logavel\TrackLogs\Log;
use Throwable;

public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            Log::log($exception->getMessage());
            parent::report($exception);
        }
    }
```