<!DOCTYPE html>
<html lang="en">
    <?php include 'includes/head.php'; ?>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="index.php" style="color: #337ab7;">Consulta vuelos</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Inicio</a></li>

                    </ul>

                </div>
            </div>
        </nav>
        <div class="container">
            <h2>Itinerario Disponible</h2>
            <hr>
            <div class="well wmq" id="scroll_b">
                <table class="table table-striped" id="tablajson">
                    <thead>
                        <tr>
                            <th>codigo</th>
                            <th>ciudad_origen</th>
                            <th>ciudad_destino</th>
                            <th>fecha_salida</th>
                            <th>duracion</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>  
            </div>
            <div id="scroll_b">
            <h2>Consultar Disponibilidad Vuelos</h2>
            <hr> 
            <div class="well wmq">
                <form id="consultar_disponibilidad">
                    <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    Ciudad origen:
                                    <select class="form-control" name="ciu_origen" id="ciu_origen" required="">
                                        <option value="">Seleccione...</option>

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    Ciudad destino:
                                    <select class="form-control" name="ciu_destino" id="ciu_destino" required="">
                                        <option value="">Seleccione...</option>

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    Fecha Vuelo:
                                    <input name="fecha" type="date" class="form-control"  required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <input type="hidden" value="consul3" name="parametro">
                                    <br>
                                    <input type="submit" name="Filtrar" id="btn_s01" value="ver cantidad puestos libres" class="btn  btn-warning btn-block btn-xs">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div >
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div id="resultado_diponibilidad" class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                    </div> 
                </div>
                <div id="preguntar_edad">
                    <hr>

                    <div class="row">
                        <div class="col-sm-6"><small><b>Para validar costo de este trayecto, por favor ingrese su edad:</b></small><br></div>
                        <div class="col-sm-6">
                            <form class="form-inline" id="form_cotizar">
                                <div class="form-group">
                                    <label for="email">Edad:</label>
                                    <input type="number" placeholder="ingresar solo numeros" class="form-control" name="edad" required="">
                                </div>
                                <input name="idtrayecto" id="idtrayecto" hidden="">
                                <input id="parametro4" name="parametro" hidden="">
                                <button type="submit" id="btn_s02" class="btn btn-warning">Cotizar</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div id="resultado_cotizacion" class="col-sm-8"></div>
                        <div class="col-sm-2"></div>
                    </div> 
                </div>
            </div>
            </div>
            
        </div>  
        <br><br><br>
        <div id="footer">
            <center><p class="muted credit">Aerolineas Internacionales &copy; 2018</p></center>
        </div>
    </body>
</html>
<script type="text/javascript">

    function clearpn(clase) {
        $("." + clase).hide('fast').find('input,select').removeAttr('required').val("");
        $("#" + clase).hide('fast').find('input,select').removeAttr('required').val("");
    }
    function showpn(panel) {
        $("#" + panel).show('slow').find('input,select').attr('required', 'required');
    }

    clearpn("preguntar_edad");
    $(document).ready(function () {
        var url = "../backend/funciones/consultas.php?parametro=consul1";
        $("#tablajson tbody").html("");
        $.getJSON(url, function (clientes) {
            $.each(clientes, function (i, cliente) {
                var newRow =
                        "<tr>"
                        + "<td>" + cliente.idtrayectos + "</td>"
                        + "<td>" + cliente.ciudad_origen + "</td>"
                        + "<td>" + cliente.ciudad_destino + "</td>"
                        + "<td>" + cliente.fecha_salida + "</td>"
                        + "<td>" + cliente.duracion + "</td>"
                        + "</tr>";
                $(newRow).appendTo("#tablajson tbody");
            });
        });

    });

     $(document).ready(function ()  {
        var url = "../backend/funciones/consultas.php?parametro=consul2";
        $("#ciu_origen ").html("");
        $("#ciu_destino ").html("");
        $.getJSON(url, function (clientes) {
            $.each(clientes, function (i, cliente) {
                var newRow = "<option value='" + cliente.idciudades + "'>" + cliente.nombre + "</option>";
                $(newRow).appendTo("#ciu_origen");
                $(newRow).appendTo("#ciu_destino");
            });
        });
    });


    $("#consultar_disponibilidad").submit(function (e) {
        var url = "../backend/funciones/consultas.php";  // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#consultar_disponibilidad").serialize(), // serializes the form's elements.
            beforeSend: function () {
                document.getElementById('btn_s01').disabled = true;
            },
            success: function (data) {

                document.getElementById('btn_s01').disabled = false;
                if (data == "msm_tg6") {
                    $("#resultado_diponibilidad").html("<a class='list-group-item active'>para el trayecto selecionado o fecha escogida no hay disponibilidad</a>");
                    clearpn("preguntar_edad");
                } else {
                    var result = jQuery.parseJSON(data);
                    $.each(result, function (i, result) {
                        var newRow =
                                "<ul class='list-group'>"
                                + "<a class='list-group-item active'>Para el trayecto seleccionado</a>"
                                + "<li class='list-group-item list-group-item-warning'> Puesto " + result.estado + "<span class='badge'> cantidad " + result.cantidad + "</span></li>"
                                + "</ul>"
                                ;
                        $("#resultado_diponibilidad").html(newRow);
                        $("#idtrayecto").val(result.idtrayectos);
                        $("#parametro4").val("consul4");
                        showpn("preguntar_edad");
                    });

                }
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


    $("#form_cotizar").submit(function (e) {
        var url = "../backend/funciones/consultas.php";  // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#form_cotizar").serialize(), // serializes the form's elements.
            beforeSend: function () {
                document.getElementById('btn_s02').disabled = true;
            },
            success: function (data) {

                document.getElementById('btn_s02').disabled = false;
                if (data == "msm_tg6") {
                    $("#resultado_cotizacion").html("<a class='list-group-item active'>La edad ingresada no esta registrada en nuestra base intente de nuevo</a>");

                } else {
                    var result = jQuery.parseJSON(data);
                    $.each(result, function (i, result) {
                        if (result.descuento == 100) {
                            var total = 0;
                        } else if (result.descuento == 0) {
                            var total = result.valor;
                        } else {
                            var total = ((result.valor * result.descuento) / 100);
                        }
                        var newRow =
                                "<br><ul class='list-group'>"
                                + "<a class='list-group-item list-group-item-info'>Para el trayecto seleccionado</a>"
                                + "<li class='list-group-item list-group-item-warning'> valor vuelo $" + result.valor + "<span class='badge'> descuento del % " + result.descuento + "</span></li>"
                                + "<li class='list-group-item'> valor final de pasaje $" + total + "</li>"
                                + "</ul>"
                                ;
//                        $("#resultado_cotizacion").html(newRow);
                        $(newRow).appendTo("#resultado_cotizacion");



                    });
                    $("#idtrayecto").val(result.idtrayectos);
                }
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
</script>
