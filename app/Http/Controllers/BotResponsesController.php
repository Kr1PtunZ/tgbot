<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\MessageService;
use App\Services\FileService;
use App\Services\ButtonService;
use Illuminate\Http\Request;
class BotResponsesController extends Controller
{
    protected $token;
    protected $botId;
    protected $userService;
    protected $messageService;
    protected $fileService;
    protected $buttonService;

    public function __construct(UserService $userService, MessageService $messageService, FileService $fileService, ButtonService $buttonService)
    {
        $this->userService = $userService;
        $this->messageService = $messageService;
        $this->fileService = $fileService;
        $this->buttonService = $buttonService;
    }

    public function handle(Request $request)
    {
        $data = $request->all();

        $userId = $data['message']['from']['id'] ?? null;
        $chatId = $data['message']['chat']['id'] ?? null;
        $usertext = $data['message']['text'] ?? null;

        $userClick = $this->userService->firstOrCreateUserClick($userId, $chatId);

        if (isset($data['message']['new_chat_member']) && $data['message']['new_chat_member']['id'] == $this->botId) {
            $this->userService->updateUserStatus($userClick, 'kicked');
        }

        if (isset($data['my_chat_member'])) {
            $chatMember = $data['my_chat_member'];
            if ($chatMember['new_chat_member']['status'] === 'kicked' && $chatMember['new_chat_member']['user']['id'] === $this->botId) {
                $this->userService->updateUserStatus($userClick, 'kicked');
                return;
            }
        }

        $responseMessage = $this->messageService->formatResponseMessage($userId, $usertext);

        if (isset($data['message']['photo'])) {
            $fileId = end($data['message']['photo'])['file_id'];
            $responseMessage = $this->fileService->getFileInfo($fileId, 'photo', $this->token);
        } elseif (isset($data['message']['document'])) {
            $fileId = $data['message']['document']['file_id'];
            $responseMessage = $this->fileService->getFileInfo($fileId, 'document', $this->token);
        }

        if (isset($data['callback_query'])) {
            $callbackData = $data['callback_query']['data'];
            $userId = $data['callback_query']['from']['id'];
            $chatId = $data['callback_query']['message']['chat']['id'];
            $responseMessage = $this->messageService->handleCallback($callbackData, $userClick);
        }

        $keyboard = $this->buttonService->createKeyboard();

        $this->sendMessage($chatId, $responseMessage, $keyboard);
    }
}

