<div class="tituloFiltros">
    <h1 class="tituloFiltrosContent">Filtros - Actividades</h1>
</div>
<script src="./js/actividad.js"></script>

<form role="form" id="formularioBuscar" name="formularioBuscar">
                <div id="div-busqueda"class="container">
                    <div class="row">
                        <!-- buscamos por lugar -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Lugar</label>
                            <input type="text" id="lugar" name="lugar" class="form-control" placeholder="lugar" value="" />
                        </div>
                        <!-- buscamos por duracion -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Duracion</label>
                            <input type="text" id="duracion" name="duracion" class="form-control" placeholder="duracion" value="" />
                        </div>
                        <!-- buscamos por temporada -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Temporada</label>
                            <input type="text" id="temporada" name="temporada" class="form-control" placeholder="temporada" value="" />
                        </div>
                        
                        <!-- buscamos por fecha
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Fecha</label>
                            <i class="fa-solid fa-calendar-days"></i>
                            <input type="text" id="rangoFecha" class="form-control" name="daterange" value="" />
                        </div>

                        script para el buscador de fecha
                        <script>
                        $(function() {
                        $('input[name="daterange"]').daterangepicker({
                            opens: 'left'
                        }, function(start, end, label) {
                            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        });
                        });
                        </script> -->
                        
                        
                    </div>
                    <!-- Boton para buscar -->
                    <button type="button" class="btn btn-primary" onclick="buscar();" style="margin-top:20px;">Buscar</button>
                    <!-- Boton para limpiar filtros -->
                    <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
                    <!-- Boton para cambiar de filtros a insertar -->
                    <button type="button" class="btn btn-primary" onclick="getVista('Actividad', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
                </div>

            </form>



    <!-- cuando carga los filtros, activa una función que llama a la función buscar-->
    <!-- Estaría interesante guardar la variable en un localStorage -->        
    <script type="text/javascript">
        var onLoadPage = (function() {
            var executed = false;
            return function() {
                if (!executed) {
                    executed = true;
                    buscar();
                }
            };
        })();

        onLoadPage();
        onLoadPage();
    </script>