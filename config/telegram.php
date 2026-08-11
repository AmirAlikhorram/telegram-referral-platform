<?php

return [
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'bot_username' => env('TELEGRAM_BOT_USERNAME'),
    'required_channel' => env('TELEGRAM_REQUIRED_CHANNEL'),
    'channel_url' => env('TELEGRAM_CHANNEL_URL'),
    'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
];
