<?php
//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\JsonResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\Log;
//use App\Services\TelegramUserService;
//
//class TelegramWebhookController extends Controller
//{
//    public function __construct(
//        private TelegramUserService $telegramUserService
//    ) {
//    }
//    public function handle(Request $request): JsonResponse
//    {
//        $update = $request->all();
//
//        Log::info('Telegram webhook received', [
//            'update_id' => $update['update_id'] ?? null,
//            'update' => $update,
//        ]);
//
//        $message = $update['message'] ?? null;
//
//        if (! $message) {
//            return response()->json(['ok' => true]);
//        }
//
//        $text = trim($message['text'] ?? '');
//        $chatId = $message['chat']['id'] ?? null;
//
//        if (! $chatId) {
//            return response()->json(['ok' => true]);
//        }
//
//        if (str_starts_with($text, '/start')) {
//            $user = $this->telegramUserService->createOrUpdate(
//                $message['from']
//            );
//            $this->sendMessage(
//                $chatId,
//                "سلام {$user->first_name} 👋\n\n"
//                . "حساب شما با موفقیت ثبت شد.\n\n"
//                . "کد دعوت شما:\n{$user->referral_code}"
//            );
//        }
//
//        return response()->json(['ok' => true]);
//    }
//
//    private function sendMessage(int|string $chatId, string $text): void
//    {
//        $token = config('telegram.bot_token');
//
//        if (blank($token)) {
//            Log::error('Telegram bot token is missing.');
//
//            return;
//        }
//
//        $response = Http::post(
//            config('telegram.api_url') . "/bot{$token}/sendMessage",
//            [
//                'chat_id' => $chatId,
//                'text' => $text,
//            ]
//        );
//
//        if ($response->failed()) {
//            Log::error('Telegram sendMessage failed', [
//                'status' => $response->status(),
//                'body' => $response->body(),
//            ]);
//        }
//    }
//}


namespace App\Http\Controllers;

use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\Handlers\CommandHandler;
use App\Telegram\Handlers\CallbackHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function __construct(
        private CommandHandler $commandHandler,
        private CallbackHandler $callbackHandler,
    )
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $update = $request->all();

        Log::info('Telegram webhook received', [
            'update' => $update,
        ]);

        $telegramUpdate = new TelegramUpdate($update);
        if ($telegramUpdate->callbackQuery()) {

            $this->callbackHandler->handle($telegramUpdate);

            return response()->json([
                'ok' => true,
            ]);

        }

        $this->commandHandler->handle($telegramUpdate);

        return response()->json([
            'ok' => true,
        ]);
    }
}
