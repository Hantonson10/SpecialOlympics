<div class="tituloFiltros">
    <h1>Filtros</h1>
</div>
<script src="./js/material.js"></script>

<form role="form" id="formularioBuscar" name="formularioBuscar">
                <div id="div-busqueda"class="container">
                    <div class="row">
                        <!-- buscamos por nombre -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="" />
                        </div>
                        <!-- buscamos por descripcion -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripcion" value="" />
                        </div>
                        <!-- buscamos por entidad -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Motivo</label>
                            <input type="text" id="motivo" name="motivo" class="form-control" placeholder="motivo" value="" />
                        </div>
                        <!-- buscamos por Cantidad -->
                        <div class="form-group col-lg-4 col-md-4 col-xs-4">
                            <label for="texto">Cantidad</label>
                            <input type="text" id="cantidad" name="cantidad" class="form-control" placeholder="cantidad" value="" />
                        </div>
                        
                        
                    </div>
                    <!-- Boton para buscar -->
                    <button type="button" class="btn btn-primary" onclick="buscar();" style="margin-top:20px;">Buscar</button>
                    <!-- Boton para limpiar filtros -->
                    <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
                    <!-- Boton para cambiar de filtros a insertar -->
                    <button type="button" class="btn btn-primary" onclick="getVista('Material', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
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