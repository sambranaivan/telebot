<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\update;
use App\Models\User;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Keyboard\InlineKeyboard;
use Hash;
class ApiController extends Controller
{
    //

    // public $chat_id = 819803208;
    public function test(request $request)
    {

        $updates = Telegram::getWebhookUpdates();

        foreach ($updates as $key => $value) {
            $update = new update();
            $update->update_id = $value->update_id;
            $update->save();
        }
        
        return response()->json(["test"=>"ok"],200);
    }

    public function sprite()
    {
        $file = Telegram\Bot\FileUpload\InputFile::create("http://api.sambrana.com.ar/sprites/left_articuno.webp",'moltres_sprite');
        // return $file->file_id;
        // $moltres = "CAACAgEAAxkDAAMGX5y-eRvxyddVry-74DfeZch9jSMAAsoAA0Bw6EQs17Wr5EAwpBs";
        // CAACAgEAAxkDAAMGX5y-eRvxyddVry-74DfeZch9jSMAAsoAA0Bw6EQs17Wr5EAwpBsE

        $message = Telegram::sendSticker(
            [
                "chat_id"=>$this->chat_id,
                "sticker"=>$file
            ]
            );

        return $message;
    }

    public function menu()
    {
        $keyboard = [
            ['Atacar','Item'],
            ["Cambio",'Huir'],
                       
                 
        ];
        
        $reply_markup =Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true
        ]);
        
        $response = Telegram::sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'Elige una opción', 
            'reply_markup' => $reply_markup
        ]);
        
        $messageId = $response->getMessageId();

        return $response;
    }
    public function inline()
    {
        $keyboard = Keyboard::make()
        ->inline()
        ->row(
            Keyboard::inlineButton(['text' => 'Test', 'callback_data' => 'data']),
            Keyboard::inlineButton(['text' => 'Btn 2', 'callback_data' => 'data_from_btn2']),
            Keyboard::inlineButton(['text' => 'Btn 3', 'callback_data' => 'data_from_btn2']),
            Keyboard::inlineButton(['text' => 'Btn 3', 'callback_data' => 'data_from_btn2'])
        );
    
        // $this->replyWithMessage(['text' => 'Start command', 'reply_markup' => $keyboard]);

        $response = Telegram::sendMessage([
            'chat_id' => $this->chat_id,
            'text' => 'Elige una opción', 
            'reply_markup' => $keyboard
        ]);
    }


    public function start(request $request)
    {

        
        $user = User::where('chat_id',$request->chatId)->first();
       
        if($user == null)///usuario nuevo
        {
            $user = new User();
            $user->name = "dummy";
            $user->email = $request->chatId;
            $user->chat_id = $request->chatId;
            $user->password = Hash::make("1234");
            $user->save();
            
            $request->request->add(["new"=>true]);
         
            
        }
        else
        {

            $request->request->add(["new"=>false]);
        }

        $request->request->add(["user"=>$user]);
        

        return response()->json($request,200);

        // existe usuario?
        
    }

    public function update(request $request)
    {

        
        $user = User::where('chat_id',$request->chatId)->first();

        // return response()->json($request->content["chat"]['username'],200);
        
       if($user)
       {
           $user->email = $request->content["chat"]['username'];
           $user->save();
       }

      
        

        return response()->json($user,200);

        // existe usuario?
        
    }

    public function explore(request $request)
    {
        $user = User::where('chat_id',$request->chatId)->first();

        $r = rand(0,100);
        $p = rand(1,151);

        if($r > 50)
        {
            $request->request->add(['explore'=>'wild']);
            $request->request->add(['poke'=>'Rayquaza']);
            $request->request->add(['sticker'=>'https://raw.githubusercontent.com/sambranaivan/telebot/main/public/sprites/'.$p.'.webp']);
        }
        else
        {
            $request->request->add(['explore'=>'item']);
            $request->request->add(['item'=>'Pepita']);
        }

        return response()->json($request,200);     

        

    }

    

    // public function menu_principal(request $request)
    // {
    //     $keyboard = Keyboard::make()
    //     ->inline()
    //     ->row(
    //         Keyboard::inlineButton(['text' => 'Explorar', 'callback_data' => '/explore']),
    //         Keyboard::inlineButton(['text' => 'Equipo', 'callback_data' => '/team']),
    //         Keyboard::inlineButton(['text' => 'Mochila', 'callback_data' => '/bag'])
    //     );
    
    //    $response = Telegram::sendMessage([
    //         'chat_id' => $request["user"]["chat_id"],
    //         'text' => 'Que quieres hacer?', 
    //         'reply_markup' => $keyboard
    //     ]);

    //     return response()->json($reponse,200);
    // }
}
