<?php

use App\Jobs\FetchProxyCloudResponses;

Schedule::job(FetchProxyCloudResponses::class, [])->cron(sprintf('*/%s * * * *', intval(config('services.trmnl.proxy_refresh_minutes', 15))));
