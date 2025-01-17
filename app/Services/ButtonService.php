<?php

namespace App\Services;


class ButtonService
{
    public function createKeyboard()
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Нажми меня',
                        'callback_data' => 'button_pressed'
                    ]
                ]
            ]
        ];
    }
}