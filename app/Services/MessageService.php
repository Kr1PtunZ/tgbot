<?php

namespace App\Services;

class MessageService
{
    public function formatResponseMessage($userId, $usertext)
    {
        return "$userId сказал: $usertext";
    }

    public function handleCallback($callbackData, $userClick)
    {
        if ($callbackData === 'button_pressed') {
            $userClick->increment('button_pressed');
            return "Вы нажали кнопку {$userClick->button_pressed} раз!";
        }
        return null;
    }
}