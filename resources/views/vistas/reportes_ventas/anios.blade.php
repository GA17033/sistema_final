@extends('layouts/app')
@section('titulo',"ventas de hoy")
@section('content')
<h4 class="text-center text-secondary">SALIDAS POR AÑOS</h4>

<div class="row container-fluid m-auto">
    <div class="col-12 col-md-6 mb-3">
        <label for="fecha1">Desde</label>
        <input type="text" id="fecha1" list="anio1" class="input input__text p-4" placeholder="Selecciona un año">
        <datalist id="anio1">
            @for ($i = 2020; $i <= 2030; $i++) <option value="{{$i}}">
                </option>
                @endfor
        </datalist>
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="fecha2">Hasta</label>
        <input type="text" id="fecha2" list="anio2" class="input input__text p-4" placeholder="Selecciona un año">
        <datalist id="anio2">
            @for ($i = 2020; $i <= 2030; $i++) <option value="{{$i}}">
                </option>
                @endfor
        </datalist>
    </div>
    <div class="mb-4 mt-1">
        <button type="button" id="buscar" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Buscar</button>
    </div>
</div>


<div class="overflow-auto row container-fluid m-auto px-3">
    <div class="pb-1 pt-2">
        <a href="" target="_blank" id="imprimir" class="btn btn-success"><i class="fas fa-print"></i>&nbsp;
            Imprimir</a>
    </div>
    <div>
        <table class="table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Suma total</th>
                    <th>Descuento</th>
                    <th>Total a pagar</th>
                </tr>
            </thead>

            <tbody id="body1">

            </tbody>
        </table>
    </div>
</div>


<script>
    let fecha=document.getElementById("fecha1");
    let fecha2=document.getElementById("fecha2");
    let boton=document.getElementById("buscar");
    fecha.addEventListener("change", buscarVenta)
    fecha2.addEventListener("change", buscarVenta)
    boton.addEventListener("click", buscarVenta)

    function buscarVenta(){
        let fecha1=document.getElementById("fecha1").value;
        let fecha2=document.getElementById("fecha2").value;

        var ruta = "{{ url('reporte-anios-search/') }}/" + fecha1 + "/"+ fecha2 +"";
        $.ajax({
            url: ruta,
            type: "get",
            success: function(data) {
                let imprimir=document.getElementById("imprimir");
                imprimir.href=`reporte-pdf-anios/${data[0].fecha1}/and/${data[0].fecha2}`;
                let tr=document.createElement("tr")
                let body=document.getElementById("body1")
                let div=""
                data[0].sql.forEach(function(el,index){                    
                    div+=`
                    <tr>
                        <td>${el.nomCliente}</td>
                        <td>${el.fecha}</td>
                        <td>${el.nomProducto}</td>
                        <td>${el.totVenta}</td>
                        <td>${el.descuento}</td>
                        <td>${el.pagoTotal}</td>
                    </tr>
                    `                    
                });
                div+=`
                    <tr>
                        <td colspan="3" class="font-weight-bold">Suma total de la venta :</td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">$ ${data[0].sql3[0].tot}</span>
                        </td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">$ ${data[0].sql3[0].desc}</span>
                        </td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">$ ${data[0].sql3[0].pagoTotal}</span>
                        </td>
                    </tr>
                `
                body.innerHTML=div

            },
            error: function(data) {
                
            }
        })
    }
</script>
@endsection