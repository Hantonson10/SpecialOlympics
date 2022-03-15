<script src="js/Eventos.js"></script>
<script type="text/javascript" src="js/Eventos.js"></script>


<form role="form" id="formularioBuscar" name="formularioBuscar">
    <div id="div-busqueda"class="container">
        <div class="row">
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Producto/descripcion</label>
                <input type="text" id="texto" name="texto" class="form-control" placeholder="Buscar" value="" />
            </div>
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Activos</label>
                <select type="text" id="factivo" name="factivo" class="form-control" placeholder="Seleccionar">
                    <option value="">TODOS</option>
                    <option value="S">Activo</option>
                    <option value="N">No activo</option>
                </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Stock Minimo</label>
                <input type="number" id="stock_Minimo" name="stock_Minimo" class="form-control" placeholder="Buscar" value="" />     
            </div>
            <!-- <div class="form-group col-lg-4 col-md-6 col-xs-6">
                <label for="texto">Categoria</label>
                <input type="number" id="categoria" name="categoria" class="form-control" placeholder="Buscar" value="" />
            </div> -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Categoria</label>
                <select type="text" id="categoria" name="categoria" class="form-control" placeholder="Seleccionar">
                    <option value="">TODAS</option>
                    <?php
                        foreach($datos as  $ind=>$categoria){ ?> 
                            <option value="<?php echo $categoria['id_ProductoCategoria']; ?>"><?php echo $categoria['productoCategoria']; ?></option>
                        <?php } ?>
                </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Cantidad Productos</label>
                <select type="text" id="cantProduc" name="cantProduc" class="form-control" placeholder="Seleccionar">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <button type="button" class="btn btn-primary" onclick="buscar(1, $('#cantProduc').val());" style="margin-top:20px;">Buscar</button>
        <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
        <button type="button" class="btn btn-primary" onclick="addVistaInsertar('Productos', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
    </div>

</form>