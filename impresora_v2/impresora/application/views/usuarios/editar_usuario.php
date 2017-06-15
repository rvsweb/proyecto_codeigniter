<!-- Esta vista va dentro 'conjunto_vistas'  como $pagina -->
<!--VISTA PARA ACTUALIZAR LOS DATOS MEDIANTE UN FORMULARIO -->
<div class="">
 <div class="">
  <!--ACTUALIZAR DATOS-->
  <!-- CREO UN FORMULARIO y LE DIGO DONDE LO ENVIO -->
  <form method="post" action="<?php echo base_url('controlador_usuarios/actualizar_usuario') ?>">

   <!-- OBTENGO TODOS LOS DATOS del 'MODELO' -->
   <?php foreach ($datosUsuario as $value) { ?>
       <!-- Oculto el 'ID'
       SELECCIONO PARA ENVIARLO al metodo del "CONTROLADOR"
       y asi referenciar "usuario" que estoy actualizando -->
       <input type="hidden" name="usuario_id" value="<?php echo $value->usuario_id; ?>">

       <div class="">
        <label for="">Tipo de Usuario</label>

<!--        < ?php
        $lista = array();
//Objeto viene 'controlador_usuarios:editar_usuario(id)'
        foreach ($todos_usuarios as $registro) {
//Dentro de la posicion del id = almacenamos el nombre del usuarios actualizado
            $lista[$registro->tipo] = $registro->tipo;
        }
        echo form_dropdown('tipo', $lista, $value->tipo, 'class=""');
        ?>-->

        <select name="tipo" class="">
         <option value="0">Administrador</option>       
         <option value="1">Usuario</option>    
        </select>
       </div>

       <div class="">
        <label for="">Nombre</label>
        <input type="text" name="nombre" class="" id="" value="<?php echo $value->nombre; ?>">
       </div>

       <div class="">
        <label for="">Apellidos</label>
        <input type="text" name="apellidos" class="" id="" value="<?php echo $value->apellidos; ?>">
       </div>

       <div class="">
        <label for="">Password</label>
        <input type="text" name="password" class="" id="" value="<?php echo $value->password; ?>">
       </div>

       <div class="">
        <label for="">Activo</label>
        <input type="text" name="activo" class="" id="" value="<?php echo $value->activo; ?>">
       </div>


       <div class="">
        <label for="">Email</label>
        <input type="text" name="email" class="" id="" value="<?php echo $value->email; ?>">
       </div>


   <?php } ?>

   <button type="submit" class="">Actualizar Usuario</button>
  </form>
 </div>
</div>


