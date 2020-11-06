<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Telegram;
class sprite extends Model
{
    use HasFactory;

    // public $chat_id = 819803208;
   
    public function sendBack($chat_id)
    {

        if($this->back == null)
        {
            ///si no tengo el file id lo creo aca
            $file = Telegram\Bot\FileUpload\InputFile::create("http://api.sambrana.com.ar/sprites/back/".$this->numero.".webp","nro_".$this->numero);
        }
        else
        {
            $file = $this->back;
        }

        $message = Telegram::sendSticker(
            [
                "chat_id"=>$chat_id,
                "sticker"=>$file
            ]
            );


        if($this->back == null)
        {
            $this->back = $message->sticker->file_id;
            $this->save();          
        }
        return $message;
    }

    

    public function sendFront($chat_id)
    {
       
       if($this->front == null)
        {
            ///si no tengo el file id lo creo aca
            $file = Telegram\Bot\FileUpload\InputFile::create("http://api.sambrana.com.ar/sprites/".$this->numero.".webp","nro_".$this->numero);
        }
        else
        {
            $file = $this->front;
        }

        $message = Telegram::sendSticker(
            [
                "chat_id"=>$chat_id,
                "sticker"=>$file
            ]
            );


        if($this->front == null)
        {
            $this->front = $message->sticker->file_id;
            $this->save();          
        }
        return $message;
    }


    public function actualizar()
    {

        if($this->nombre == null)
        {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/".$this->numero);
            $response["species"]["name"];
            $this->nombre = $response["species"]["name"];
            $this->hp = $response["stats"][0]["base_stat"];
            $this->atk = $response["stats"][1]["base_stat"];
            $this->def = $response["stats"][2]["base_stat"];
            $this->spa = $response["stats"][3]["base_stat"];
            $this->spd = $response["stats"][4]["base_stat"];
            $this->spe = $response["stats"][5]["base_stat"];
            $this->save();
        }



    }
}
