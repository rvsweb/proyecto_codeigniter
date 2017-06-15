<?php
//este es el mensaje que se envia desde el controlador a realizar una accion
//añadir actualizar borrar
echo $mensaje;
?>
<div class="w6 STBBody Arial">
 <div id="menu" class="tag-agroup">
  <nav>
   <ul class="tabs">
    <li class="controlBase Inline tag-btn fondoCeleste bordesArriba">
     <a class="padding3" href="#tab1">USUARIOS</a></li>

    <li class="controlBase Inline tag-btn fondoCeleste bordesArriba">
     <a id="pestania2" class="padding3" href="#tab2">REGISTROS</a></li>

    <li class="controlBase Inline tag-btn fondoCeleste bordesArriba">
     <a class="padding3" href="#tab3">DOCUMENTOS</a></li>

    <br clear="all" />
   </ul>
   <a id="pull" class="labelBase txtcentro" href="#">MENU</a>
  </nav>

  <div class="clear"></div>
  <!-- Boton cerrar sesion : Funciona -->
  <div>
   <br>
   <a href="<?php echo base_url('controlador_usuarios/cerrar_sesion') ?>" title="Salir de la sesion">
    <i class="fa fa-window-close fa-2x"></i>
   </a> 
  </div>
  <br>
 </div>

 <!-- ESTA ES LA PRIMERA PESTAÑA -->
 <div id='tab1' class="contenido_tab w10 bordesGris" >
  <div class="STBAgroup w10">
   <table id='table_id' class="STBTabla w10">
    <thead>
     <tr>
      <th>TIPO</th>
      <th>ID</th>
      <th>NOMBRE</th>
      <th>APELLIDOS</th>
      <th>ACTIVO</th>
      <th>EMAIL</th>
      <th>ACCIONES</th>
     </tr>
    </thead>
    <?php
// Contiene todos los datos de la BD    
//    var_dump($resultados);
    foreach ($resultados as $value) {
        ?>
        <tbody>
         <tr>
          <td data-label="TIPO"><?php echo $value->tipo; ?><br></td>
          <td data-label="ID"><?php echo $value->usuario_id; ?><br></td>
          <td data-label="NOMBRE"><?php echo $value->nombre; ?><br></td>
          <td data-label="APELLIDOS"><?php echo $value->apellidos; ?><br></td>
          <td data-label="ACTIVO"><?php echo $value->activo; ?><br></td>
          <td data-label="EMAIL"><?php echo $value->email; ?><br></td>
          <td data-label="ACCIONES"> 

           <!--Cuando pulso en el enlace se ejecuta la llamada a AJAX 
               Trae los datos del servidor--> 
           <button onclick="aniadir_usuario()" title="Añadir">Añadir
            <i class="fa fa-address-card"></i>
           </button>

           <a onclick="editar_usuario(<?php echo $value->usuario_id; ?>)" title="Editar">
            <i class="fa fa-pencil"></i>
           </a>

           <a href="<?php echo base_url('controlador_usuarios/user_delete') . "/" . $value->usuario_id; ?>" title="Eliminar">
            <i class="fa fa-trash-o"></i>
           </a>

          </td>
         </tr>
     <?php } ?>
    </tbody>
   </table>
  </div>
 </div>

 <!--  AQUI ESTA EL JQUERY Y EL AJAX QUE TRAE LOS DATOS DEL SERVIDOR PARA METERLOS DENTRO DE LOS CAMPOS  -->
 <script type="text/javascript">

// Variable para guardar el tipo de metodo que se ejecutara
     var save_method;

// Funciona : Quita los datos y vuelve a la tabla     
     function quitar_datos_formulario() {
         $('#form')[0].reset(); // Borra desde 
     }

     function aniadir_usuario()
     {
         save_method = 'add';
     }


     function editar_usuario(id)
     {
         save_method = 'update';

         $('#form')[0].reset(); // reset form on modals
         $('#pestania2').click().select();


         //Ajax Load data from ajax 
         //TRAE LOS DATOS DEL SERVIDOR
         $.ajax({
             url: "<?php echo site_url('index.php/controlador_usuarios/ajax_edit_user') ?>/" + id, // recibe los datos del controlador
             type: "POST", // metodo get
             dataType: "JSON", // por JSON
             success: function (data) // Aquí estan los datos del SERVIDOR que luego iran añadiendose en el formulario
                     // si funciona el envio desde el controlador "metodo json_encode" ejecuta lo de abajo
                     {
                         $('[name="usuario_id"]').val(data.usuario_id);
                         $('[name="tipo"]').val(data.tipo);
                         $('[name="nombre"]').val(data.nombre);
                         $('[name="apellidos"]').val(data.apellidos);
                         $('[name="password"]').val(data.password);
                         $('[name="activo"]').val(data.activo);
                         $('[name="email"]').val(data.email);
                     },
             error: function (jqXHR, textStatus, errorThrown)
             {
                 alert('Error al obtener los datos');
             }
         });
     }

     // Cuando pincha guardar en el formulario
     function save()
     {
         var url; // la variable 'url' almacena el tipo de metodo a lanzar

         if (save_method == 'add') {

             alert("añadir");
             // usa la variable global para ejecutar un metodo u otro
             url = "<?php echo site_url('index.php/controlador_usuarios/add_user_ajax') ?>";

         } else {
             alert("actualizar");
             url = "<?php echo site_url('index.php/controlador_usuarios/actualizar_usuario') ?>";
         }
         // ajax adding data to database
         $.ajax({
             url: url,
             type: "POST",
             data: $('#form').serialize(),
             dataType: "JSON",
             success: function (data)
             {
                 //if success close modal and reload ajax table
//                 $('#form').modal('hide');
//                 location.reload();// for reload a page
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
                 alert('Error al Añadir o al Actualizar');
             }
         });
     }


 </script> 

 <!-- ESTA ES LA SEGUNDA PESTAÑA
      FORMULARIO PARA AÑADIR UN NUEVO USUARIO -->
 <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">

     <div id="tab2" id="capa2" class="contenido_tab w10 bordesGris">
      <div class="STBAgroup w10">

       <div class="modal-body form">
        <!-- Formulario de envio -->
        <!-- -- --><!-- -- --><!-- -- -->
        <form id="form" id="modal_form" class="STBTab w5" action="#">

         <select name="tipo" class="STBInput STBTab allline margin5 txs6 margin7">
          <option value="0">Administrador</option>       
          <option value="1">Usuario</option>    
         </select>

         <input type="text" name="nombre" class="STBInput STBTab allline margin5 txs6" placeholder="Nombre">
         <input type="text" name="apellidos" class="STBInput STBTab allline margin5 txs6" placeholder="Apellidos">
         <input type="text" name="email" class="STBInput STBTab allline margin5 txs6" placeholder="Email">
         <input type="text" name="activo" class="STBInput STBTab allline margin5 txs6" placeholder="Activo" value="">
         <input type="text" name="password" class="STBInput STBTab allline margin5 txs6" placeholder="contrase&ntilde;a">

        </form>
        <!-- -- --><!-- -- --><!-- -- -->

       </div>

       <!--Al pulsar este boton lanza la funcion Jquery para borrar los datos-->
       <button class="STBInput STBSombra STBSombraOut STBTab allline margin5 txs6 margin2" onclick="quitar_datos_formulario()" title="Editar">
        <i class="fa fa-trash-o"></i>
       </button>

       <div class="modal-footer">
        <button type="submit" onclick="save()" class="STBInput STBSombra STBSombraOut STBTab allline margin5 txs6 margin2">Registrar Usuario</button>
       </div>


      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>

</div>


<!-- ESTA ES LA TERCERA PESTAÑA -->
<div id="tab3" class="contenido_tab w10" >
 <div  class="STBAgroup w10">
     <?php $info = json_decode($info, true); ?>
  <p id="report"></p>
  <table id="tabla_documentos" class="STBTabla w10">
   <thead>
    <tr>
     <th>ID</th>
     <th>TITULO</th>
     <th>NOMBRE DEL ARCHIVO</th>
     <th>ESTADO</th>
     <th>FECHA DE SUBIDA</th>
     <th>FECHA DE IMPRESION</th>
     <th>NOTAS</th>		
     <th>ID DOCUMENTOS</th>
     <th>ID ARCHIVO</th>
     <th></th>
    </tr>
   </thead>

   <!--Para el envio usa JSON --> 
   <?php foreach ($info as $info) { ?>
       <tbody>
        <tr class="row">
         <td data-label="ID"> <?php echo $info["usuario_id"] ?><br></td>
         <td data-label="TITULO">
          <a class="enlace" href=<?php echo site_url('controlador_documentos/downloadDocument/' . $info["titulo"]) ?> > 
              <?php echo $info["titulo"] ?> 
          </a>
          <br>
         </td>
         <td data-label="NOMBRE DEL ARCHIVO"> <?php echo $info["nombre_archivo"] ?><br></td>
         <td data-label="ESTADO" class="status" value="<?php echo $info["estado"] ?>"><br></td>
         <td data-label="FECHA DE SUBIDA"> <?php echo $info["fecha_creacion"] ?><br></td>
         <td data-label="FECHA DE IMPRESION" class="fechaImpresion"> <?php echo $info["fecha_impresion"] ?><br></td>
         <td data-label="NOTAS"><?php echo $info["notas"] ?><br></td>
         <td data-label="ID DOCUMENTOS" class="id_documento"><?php echo $info["id_documento"] ?><br></td>
         <td data-label="ID ARCHIVOS"><?php echo $info["id_archivo"] ?><br></td>
         <td class="boton" value="1"> <button class="cambiar_estado">Marcar Impreso</button><br></td>
        </tr>
    <?php } ?>
   </tbody>
  </table>
 </div>
</div>
<div id="clear" class="clear"></div>
</div>

<script>
    $(document).ready(function () {
        $(".status").each(function (index, value) {
            if ($(this).attr("value") == "1") {
                $(this).text("Terminado");
                $(this).parent().find(".boton").html("Ya esta impreso");
            } else {
                $(this).text("En espera");
            }
        });
        $(".cambiar_estado").click(function () {
            var d = new Date();
            var di = d.getDate();
            var me = d.getMonth();
            var an = d.getFullYear();
            var id = $(this).parent().parent().find(".id_documento").text();
            $(this).parent().parent().find(".status").text("Terminado");
            $(this).parent().parent().find(".fechaImpresion").text(di + "/" + me + "/" + an);
            $(this).parent().html("Ya esta impreso");
            $.ajax({
                url: "<?php echo site_url('controlador_documentos/cambiar_estado/') ?>" + id,
                success: function () {
                    $("#report").html("Estado modificado correctamente");
                }
            });
        });
    });
</script>