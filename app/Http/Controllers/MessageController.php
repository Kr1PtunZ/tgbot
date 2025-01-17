<?php

namespace App\Http\Controllers;

use App\Models\ButtonEncounter;
use App\Http\Controllers\BotResponsesController;
use Illuminate\Http\Request;
class MessageController extends BotResponsesController
{
    protected $token;
    public function __construct(){
        $this->token = env("TELEGRAM_BOT_TOKEN");
    }
    function sendMassMessage(Request $request) {
        
        $users = ButtonEncounter::all();
    
        foreach ($users as $user) {
            try {
                // Отправляем сообщение
                $user->sendMessage([
                    'chat_id' => $user['chat_id'],
                    'text' => $request['message']
                ]);
            } catch (\Exception $e) {
                error_log("Failed to send message to user {$user['chat_id']}: " . $e->getMessage());
            }
        }
        return redirect(route("admin.mass_message"))->with("success","Сообщения успешно отправленны");
    }

}
