<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdministracionController as admin ;
use App\Http\Controllers\ProductoController as Producto;
use App\Http\Controllers\CategoriaController as Categoria;
use App\Http\Controllers\EspecificacionController as Especificacion;
use App\Http\Controllers\ProductoEspecificacionController as ProductoEsp;
use App\Http\Controllers\DescuentoController as Descuento;
use App\Http\Controllers\CatalogoController as Catalogo;
use App\Http\Controllers\CarritoController as Carrito;
use App\Http\Controllers\PedidoController as Pedido;
use App\Http\Controllers\FacturaController as Factura;


Auth::routes();

Route::fallback(function () {
    return redirect()->back()->with('error', 'ruta no encontrada, redirigido a la ruta anterior.');
});

Route::get('/', [Catalogo::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/producto/{id}', [Catalogo::class, 'show'])->name('catalogo.producto');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['rol:Cliente'])->group(function () {
        
        Route::prefix('cliente')->group(function () {
            Route::get('/', [ClienteController::class, 'index'])->name('cliente.index');
            Route::get('historial', [ClienteController::class, 'historial'])->name('cliente.historial');

            Route::prefix('perfil')->group(function () {
                Route::get('/', [ClienteController::class, 'perfil'])->name('cliente.perfil'); 
                Route::get('edit', [ClienteController::class, 'editarPerfil'])->name('cliente.editarPerfil');
                Route::post('update', [ClienteController::class, 'actualizarPerfil'])->name('cliente.actualizarPerfil');
            });

            Route::prefix('carrito')->group(function () {
                Route::get('/', [Carrito::class, 'index'])->name('carrito.index');
                Route::post('adiOact', [Carrito::class, 'adicionarOactualizarCarrito'])->name('carrito.adicionarOactualizarCarrito');
                Route::post('remove', [Carrito::class, 'remove'])->name('carrito.remove');
                Route::post('clear', [Carrito::class, 'clear'])->name('carrito.clear');
            });

            Route::prefix('pedido')->group(function () {
                Route::get('/', [Pedido::class, 'index'])->name('cliente.pedido');
                Route::get('create', [Pedido::class, 'create'])->name('cliente.pedido.create');
                Route::post('store', [Pedido::class, 'store'])->name('cliente.pedido.store');
                Route::post('cancel', [Pedido::class, 'cancel'])->name('cliente.pedido.cancel');
                Route::get('show/{id}', [Pedido::class, 'show'])->name('cliente.pedido.show');
                Route::delete('{idPedido}', [Pedido::class, 'eliminarPedido'])->name('cliente.pedido.eliminar');
            });

            Route::prefix('factura')->group(function () {
                Route::get('/', [Factura::class, 'index'])->name('cliente.factura');
                Route::get('create/{idPedido}', [Factura::class, 'create'])->name('cliente.factura.create');
                Route::post('store/{idPedido}', [Factura::class,'store'])->name('cliente.factura.store');
                Route::get('show/{idFactura}', [Factura::class,'show'])->name('cliente.factura.show');
                Route::get('cancel/{idFactura}', [Factura::class,'cancel'])->name('cliente.factura.cancel');
                Route::post('confirmar/{idFactura}', [Factura::class, 'confirmarEntrega'])->name('cliente.factura.confirmar');
            });
            
        });
    });


    // rutas para Administrador
    Route::middleware(['rol:Admin,JefeAlmacen'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [Admin::class, 'index'])->name('admin.index');

            Route::prefix('usuarios')->group(function () {
                Route::get('/', [Admin::class, 'usuarios'])->name('admin.usuarios');
                Route::get('{id}/edit', [Admin::class, 'editUsuario'])->name('admin.edit-usuario');
                Route::put('{id}', [Admin::class, 'updateUsuario'])->name('admin.update-usuario');

            });
            Route::get('pedidos', [Admin::class, 'pedidos'])->name('admin.pedidos');
            Route::get('pedido/{id}/edit', [Admin::class, 'editPedido'])->name('admin.pedido.edit');
            Route::put('pedidos/{id}/estado', [Admin::class, 'updateEstadoPedido'])->name('admin.pedido.updateEstado');


            Route::resource('clientes', ClienteController::class);
            Route::resource('categorias', Categoria::class);
            Route::resource('especificaciones', Especificacion::class);
            Route::resource('productos', Producto::class);

            Route::prefix('productos')->group(function () {
                Route::get('{idProducto}/especificaciones/create', [ProductoEsp::class, 'create'])->name('productos.especificaciones.create');
                Route::post('{idProducto}/especificaciones', [ProductoEsp::class, 'store'])->name('productos.especificaciones.store');
                Route::get('especificaciones/{idProducto}/{idEspecificacion}/edit', [ProductoEsp::class, 'edit'])->name('productos.especificaciones.edit');
                Route::put('especificaciones/{idProducto}/{idEspecificacion}', [ProductoEsp::class, 'update'])->name('productos.especificaciones.update');
                Route::delete('especificaciones/{idProducto}/{idEspecificacion}', [ProductoEsp::class, 'destroy'])->name('productos.especificaciones.destroy');
                Route::get('{idProducto}/descuentos/create', [Descuento::class, 'create'])->name('productos.descuentos.create');
                Route::post('{idProducto}/descuentos', [Descuento::class, 'store'])->name('productos.descuentos.store');
                Route::get('descuentos/{id}/edit', [Descuento::class, 'edit'])->name('productos.descuentos.edit');
                Route::put('descuentos/{id}', [Descuento::class, 'update'])->name('productos.descuentos.update');
                Route::delete('descuentos/{id}', [Descuento::class, 'destroy'])->name('productos.descuentos.destroy');
            });
        });
    });
});