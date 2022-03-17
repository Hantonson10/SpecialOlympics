<div class="tituloFiltros">
    <h1 class="tituloFiltrosContent">Filtros - Voluntario - <?php echo $datos['voluntario_nombre'];?></h1>
</div>
<script src="/js/voluntarios.js"></script>
<form role="form" id="formularioBuscar" name="formularioBuscar">
                <div id="div-busqueda"class="container">
                    <div class="row">
                        <!-- buscamos por nombre -->
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="" />
                        </div>
                        

                        <!-- buscamos por rango Fecha alta 
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Código Postal</label>
                            <i class="fa-solid fa-calendar-days"></i>
                            <input type="text" id="rangoFechaAlta" class="form-control" name="daterange" value="" />
                        </div>-->

                        <!-- script para el buscador de fecha 
                        <script>
                        $(function() {
                        $('input[name="daterange"]').daterangepicker({
                            opens: 'left'
                        }, function(start, end, label) {
                            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        });
                        });
                        </script>-->
                        
                    </div>
                    <!-- Boton para buscar -->         
                    <button type="button" class="btn btn-primary" onclick="buscarInfo();" style="margin-top:20px;">Buscar</button>
                    <!-- Boton para limpiar filtros -->
                    <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
                    <!--
                    <button type="button" class="btn btn-primary" onclick="addVistaInsertar('Voluntarios', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
                    -->
                </div>

            </form>

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