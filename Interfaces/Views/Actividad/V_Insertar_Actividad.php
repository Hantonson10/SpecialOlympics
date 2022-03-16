<div class="tituloFiltros">
    <h1 class="tituloFiltrosContent">Insertar - Actividades</h1>
</div>


<form role="form" id="formularioInsertar" name="formularioInsertar">
                <div id="div-busqueda"class="container">
                    <div class="row">
                        <!-- buscamos por nombre -->
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="" required/>
                        </div>
                        <!-- buscamos por descripcion -->
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripcion" value="" required/>
                        </div>
                        <!-- buscamos por descripcion -->
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Motivo</label>
                            <input type="text" id="motivo" name="motivo" class="form-control" placeholder="motivo" value="" required/>
                        </div>
                        <!-- buscamos por entidad -->
                        <div class="form-group col-lg-3 col-md-3 col-xs-3">
                            <label for="texto">Cantidad</label>
                            <input type="text" id="cantidad" name="cantidad" class="form-control" placeholder="cantidad" value="" required/>
                        </div>
                        
                        
                    </div>

                    <button type="button" class="btn btn-primary" onclick="checkearInsert();" style="margin-top:20px;">Crear</button>
                    <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
                    <button type="button" class="btn btn-primary" onclick="getVista('Material', 'getVistaFiltros');" style="margin-top:20px;">Filtros</button>
                </div>

            </form>