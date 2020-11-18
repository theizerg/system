<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notificacion;
use App\Models\User;
use Auth;
use DB;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'titulo', 'texto', 'link', 'fecha', 'tipo'
    ];    

    public function usuarios(){
        return $this->belongsToMany(User::class, 'notificacion_usuarios', 'notificacion_id', 'usuario_id','tipo');
    }

    public static function crearNotificacion($titulo, $texto ,$link, $link_texto,$tipo){
        $usuario = Auth::user();

        $notificacion = new Notificacion();
        $notificacion->titulo = $titulo;
        $notificacion->texto = $texto;
        $notificacion->link = $link;
        $notificacion->link_texto = $link_texto;
        $notificacion->fecha = date("Y-m-d H:i:s");
        $notificacion->tipo = $tipo;
        $notificacion->save();
       
    
    }

   
}