@extends('layouts/app')
@section('titulo', "registrar producto")

@section('content')


{{-- notificaciones --}}

@if (session('DUPLICADO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"DUPLICADO",
        type:"warning",
        text:"{{session('DUPLICADO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif

@if (session('CORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"CORRECTO",
        type:"success",
        text:"{{session('CORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif



@if (session('INCORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"INCORRECTO",
        type:"error",
        text:"{{session('INCORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif


<h4 class="text-center text-secondary">ACTUALIZAR PRODUCTO</h4>

<div class="mb-0 col-12 bg-white p-5">
    @foreach ($sql as $item)
    <form action="{{route('producto.update',$item->id_producto)}}" method="POST">
        @csrf
        <div class="row">

        <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select class="input input__select" name="id_tipo" id="id_tipo">
                    <option value="">Seleccionar tipo Producto...</option>
                    @foreach ($sql3 as $item3)
                    <option {{$item->id_tipo == $item3->id_tipo ? 'selected' : ''}} value="{{$item3->id_tipo}}" >
                        {{$item3->nombre}}</option>
                    @endforeach
                </select>
                @error('nombre')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input hidden type="password" name="id" value="{{$item->id_producto}}">
                <select class="input input__select" name="cate" id="cate">
                  
                </select>
                @error('cate')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>

            
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre *"
                    value="{{old('nombre',$item->nombre)}}">
                @error('nombre')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" step="0.01" min="0" name="precio" class="input input__text" id="precio"
                    placeholder="Precio *" value="{{old('precio',$item->precio)}}">
                @error('precio')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" min="0" name="stock" class="input input__text" placeholder="Stock *"
                    value="{{old('stock',$item->stock)}}">
                @error('stock')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12">
                <textarea class="input input__text" name="descripcion" cols="30" rows="3"
                    placeholder="Descripcion del producto">{{old('descripcion',$item->descripcion)}}</textarea>
            </div>


            <div class="text-right mt-0">
                <a href="{{route('producto.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-success">Guardar</button>
            </div>
        </div>
        
    </form>
    @endforeach
</div>

<script>
    //llamar a la ruta para obtener las categorias /categoria-elemento/{id}
    $(document).ready(function () {
        $('#id_tipo').change(function () {
            var id_tipo = $(this).val();
            if (id_tipo == 1) {
                //si es id_tipo 1 precio 0
               let precio = document.getElementById('precio');
                precio.value = 1;
                //blockear precio
                precio.hidden = true;

                
                get_cat(id_tipo);
 
            } else {
                $('#precio').val('');
                $('#precio').attr('hidden', false);
            get_cat(id_tipo);
           
            }
        });
    });

    id_tipo = $('#id_tipo').val();

   const get_cat = (id_tipo)=>{
    $.get('/categoria-elemento/' + id_tipo, function (data) {
                    //console.log(data);
                
                    $('#cate').empty();
                    $('#cate').append("<option value=''>Seleccionar categoria...</option>");
                    $.each(data, function (index, value) {
                        $('#cate').append("<option value='" + value.id_categoria + "'>" + value.nombre +
                            "</option>");
                    });
                });
    

   }
</script>




@endsection