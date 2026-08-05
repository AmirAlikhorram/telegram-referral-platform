<?php

namespace App\Telegram\Handlers;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\Commands\CheckMembershipCommand;
use App\Telegram\Commands\DepositCommand;
use App\Telegram\Commands\DepositNetworkCommand;
use App\Telegram\Commands\HelpCommand;
use App\Telegram\Commands\InviteCommand;
use App\Telegram\Commands\MyAccountCommand;
use App\Telegram\Commands\WalletCommand;
use App\Telegram\Commands\WithdrawalCommand;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\InlineKeyboards\DashboardKeyboard;
use App\Telegram\UI\Home\HomePage;
use App\Telegram\UI\Withdraw\WithdrawalNetworkPage;

class CallbackHandler
{
    public function __construct(
        private CheckMembershipCommand $checkMembershipCommand,
        private WalletCommand $walletCommand,
        private InviteCommand $inviteCommand,
        private MyAccountCommand $myAccountCommand,
        private WithdrawalCommand $withdrawalCommand,
        private MessageLifecycleService $messageLifecycleService,
        private DepositCommand $depositCommand,
        private DepositNetworkCommand $depositNetworkCommand,
        private TelegramStateService $stateService,
        private TelegramService $telegramService,
        private HelpCommand $helpCommand,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {

        if ($update->callbackQueryId()) {

            $this->telegramService->answerCallbackQuery(

                $update->callbackQueryId()

            );

        }

        $data = $update->callbackData();

        switch ($data) {

            case 'check_membership':

                $this->checkMembershipCommand->handle($update);

                break;

            case 'dashboard:wallet':

                $this->walletCommand->handle($update);

                break;

            case 'dashboard:invite':

                $this->inviteCommand->handle($update);

                break;

            case 'dashboard:account':

                $this->myAccountCommand->handle($update);

                break;

            case 'dashboard:withdraw':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->messageLifecycleService->replace(

                    $user,

                    \App\Telegram\UI\Withdraw\WithdrawalPage::render(),

                    \App\Telegram\UI\Withdraw\WithdrawalPage::keyboard(),

                );

                break;

            case 'withdraw:network:TRC20':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->stateService->set(

                    $user,

                    'withdraw_amount',

                    [

                        'network' => 'TRC20',

                    ]

                );

                $this->messageLifecycleService->replace(

                    $user,

                    \App\Telegram\UI\Withdraw\WithdrawalAmountPage::render($user)

                );

                break;

            case 'withdraw:network:ERC20':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->stateService->set(

                    $user,

                    'withdraw_amount',

                    [

                        'network' => 'ERC20',

                    ]

                );

                $this->messageLifecycleService->replace(

                    $user,

                    \App\Telegram\UI\Withdraw\WithdrawalAmountPage::render($user)

                );

                break;


            case 'withdraw:start':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->messageLifecycleService->replace(

                    $user,

                    <<<HTML
━━━━━━━━━━━━━━━━━━

💸 <b>WITHDRAW</b>

Select withdrawal network.

━━━━━━━━━━━━━━━━━━
HTML,

                    [
                        'inline_keyboard' => [

                            [
                                [
                                    'text' => '🟢 TRC20',
                                    'callback_data' => 'withdraw:network:TRC20',
                                ],
                                [
                                    'text' => '🔵 ERC20',
                                    'callback_data' => 'withdraw:network:ERC20',
                                ],
                            ],

                            [
                                [
                                    'text' => '⬅️ Back',
                                    'callback_data' => 'dashboard:home',
                                ]
                            ],

                        ]
                    ]

                );

                break;

            case 'withdraw:confirm':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $state = $this->stateService->get($user);

                if (! $state) {
                    return;
                }

                app(\App\Telegram\Conversations\WithdrawalConversation::class)
                    ->confirm(
                        $user,
                        $state
                    );

                break;

            case 'dashboard:home':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->messageLifecycleService->replace(
                    $user,
                    HomePage::render($user),
                    DashboardKeyboard::make()
                );

                break;

            case 'deposit:network':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->messageLifecycleService->replace(
                    $user,
                    \App\Telegram\UI\Deposit\DepositNetworkPage::render(),
                    \App\Telegram\UI\Deposit\DepositNetworkPage::keyboard(),
                );

                break;

            case 'dashboard:deposit':

                $this->depositCommand->handle($update);

                break;
            case 'deposit:TRC20':

                $this->depositNetworkCommand->handle(
                    $update,
                    'TRC20'
                );

                break;

            case 'deposit:BEP20':

                $this->depositNetworkCommand->handle(
                    $update,
                    'BEP20'
                );

                break;

            case 'deposit:ERC20':

                $this->depositNetworkCommand->handle(
                    $update,
                    'ERC20'
                );

                break;

            case 'deposit:done':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (!$user) {
                    return;
                }

                $state = app(TelegramStateService::class)->get($user);

                if (!$state) {
                    return;
                }

                app(TelegramStateService::class)->set(

                    $user,

                    'deposit_amount',

                    $state->data,

                );

                app(MessageLifecycleService::class)->replace(

                    $user,

                    $text = "💳 Please enter the deposit amount:"

                );

                break;

            case 'dashboard:help':

                $this->helpCommand->handle($update);

                break;

            case 'help:support':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->stateService->set(

                    $user,

                    'support_message'

                );

                $this->messageLifecycleService->replace(

                    $user,

                    <<<HTML
━━━━━━━━━━━━━━━━━━

🆘 <b>CONTACT SUPPORT</b>

━━━━━━━━━━━━━━━━━━

Please type your message.

It will be delivered directly to our support team.

━━━━━━━━━━━━━━━━━━
HTML

                );

                break;

            case 'help:faq':

                $telegramId = $update->callbackFrom()['id'];

                $user = User::where(
                    'telegram_id',
                    $telegramId
                )->first();

                if (! $user) {
                    return;
                }

                $this->messageLifecycleService->replace(

                    $user,

                    \App\Telegram\UI\Help\FaqPage::render(),

                    [

                        'inline_keyboard' => [

                            [
                                [
                                    'text' => '⬅️ Back',
                                    'callback_data' => 'dashboard:help',
                                ],
                            ],

                        ],

                    ]

                );

                break;

        }
    }
}
