<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\FamiliaProducto;
use App\Models\LineaProducto;
use App\Models\ProductoImagen;
use App\Models\TasaIva;
use App\Models\Item;
use Auth;
use DB;

class Producto extends Model
{

    use SoftDeletes;
   

    #Tabla asociada
    protected $table = 'productos';

    protected $fillable = [
        'codigo', 'codigo_de_barras','stock', 'nombre','descripcion', 'precio', 'tasa_iva_id','photo'
    ];

    public $sortable = [
        'codigo', 'codigo_de_barras','stock', 'nombre','descripcion', 'precio', 'tasa_iva_id'
    ];

    protected $dates = ['deleted_at'];

    public function LineasProducto(){
        return $this->hasMany(LineaProducto::class);
    }

    public function familia(){
        return $this->belongsTo(FamiliaProducto::class, 'familia_producto_id');
    }

    public function iva(){
        return $this->belongsTo(TasaIva::class, 'tasa_iva_id');
    }

     // $product->images
    public function images()
    {
        return $this->hasMany(ProductoImagen::class);
    }

   // accessor
    public function getUrlAttribute()
    {
        if (substr($this->image, 0, 4) === "http") {
            return $this->image;
        }

        return '/images/productos/' . $this->image;
    }



    public function scopeBuscarPorCodigo($query, $codigo){
        return $query->where('codigo','=',$codigo);
    }

    public function scopeBuscarPorCodigoDeBarras($query, $codigo_de_barras){
        if($codigo_de_barras == null){
            return $query->where('codigo','=',$codigo_de_barras);
        }else{
            return $query->where('codigo_de_barras','=',$codigo_de_barras);
        }
    }

    public function scopeBuscarPorId($query, $id){
        return $query->where('id','=', $id);
    }

    public function registrarCambioStock($cantidad, $descripcion){
        $lineaProducto = new LineaProducto();
        $lineaProducto->producto()->associate($this);
        $lineaProducto->usuario()->associate(Auth::user());
        $lineaProducto->stock = $this->stock;
        $lineaProducto->descripcion = $descripcion;
        $lineaProducto->cantidad = $cantidad;
        $lineaProducto->fecha = date("Y-m-d H:i:s");
        $lineaProducto->save();
    }

    public function registrarCambioPrecio(){
        DB::table('producto_precio')->insert([
            'producto_id' => $this->id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date("Y-m-d H:i:s"),
            'precio' => $this->precio
        ]);
    }

    public function preciosHistorico(){
        return DB::table('producto_precio')->select(
            'fecha',
            'usuario_id',
            'precio'
        )->where('producto_id', $this->id)
        ->orderBy('fecha', 'desc')->get();
    }

    public function scopeFiltrar($query, $texto){
        return $query
        ->where(DB::Raw("CONCAT(productos.codigo, ' ', productos.nombre)"),'like', '%'.$texto.'%');
    }

    public function scopeFiltrarPorNombre($query, $texto, $boolean = 'or'){
        return $query->where('nombre', 'like', '%'.$texto.'%', $boolean);
    }


      public function payments()
    {
        return $this->hasMany(PagoRutas::class);
    }

}
