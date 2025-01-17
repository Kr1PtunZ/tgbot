<?php
namespace App\Services;

use App\Models\ButtonEncounter;

class UserService
{
    public function firstOrCreateUserClick($userId, $chatId)
    {
        return ButtonEncounter::firstOrCreate(
            ['user_id' => $userId],
            ['button_pressed' => 0, 'status' => 'active', 'chat_id' => $chatId]
        );
    }

    public function updateUserStatus($userClick, $status)
    {
        $userClick->status = $status;
        $userClick->save();
    }
}