<script>

    var $temp       = null;
    var scada       = null;
    var device      = '<?= $deviceInfo ?>';
    var conf        = null;
    var variables   = '<?= $variablesInfo ?>';
    var scadaInf    = '<?= $scadaInfo ?>';
    var scadaData   =  '<?php
                $data = str_replace('\n' ,'_space_',json_encode($scadaData , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE  ));
                $data = str_replace('\\"' , '"' , $data);
                //$data = str_replace("'" , '"' , $data);
                $data = str_replace('\t' , " " , $data);
                $data = str_replace('\/' , '/' , $data);
                echo $data ;
        ?>';


    var scadaws = JSON.parse('<?= $scadaws; ?>');


    for (var i in scadaws) {
        eval("var " + i + " = '" + JSON.stringify(scadaws[i]) + "'");
    }


</script>



<h3  class="page-title">
    <span id="proyect_title"> .... </span>
    <small id="proyect_subtitle" >
        (Cargando ... )
    </small>
</h3>

<style>

    .select2-results__options{
        padding: 20px !important;
    }

</style>

<div id="overview" class="toolsDrag" style="margin-top:10% ;width: 100%; height:200px;"></div>
<div  id="controls-pipes" class="toolsDrag" style="  "></div>
<div  id="controls-data" class="toolsDrag2 " style="">
    <!--<div style="display: none;" class="alert alert-info cdata">Seleccione un control </div>-->
    <div style="margin-left: -3%;margin-right: 2%;" class="row">
        <div  class="col-md-12 col-sm-12">
            <h5><b>Fechas de datos :</b></h5>
            <div class="input-group select2-bootstrap-append">
                <select id="control-dates" class="form-control select2-allow-clear">
                    <option></option>
                </select>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="scada-id" value="0" />

<div class="row">
    <div style="" class="col-md-12">


        <div class="portlet light bordered ">



            <div class="portlet-title ">
                <div class="col-md-9">
                    <div id="controls" style="width:100%; min-height:260px;margin:0;padding:0;border:none;font-size:50px;color:#FF0000; "></div>
                </div>

                <div class="col-md-3">
                    <div class="scada-margin m-heading-1 border-green m-bordered">

                        <div class="page-title">
                            <span>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="scada_name" placeholder="Nombre de tu SCADA">
                                </div>
                            </span>
                            <small id="scada_save_label" >
                                <span id="efunctions">
                                    <div  class="objview">
                                        <a id=""  onclick="$('#scada-help').modal()" class="ancl-info" href="javascript:void(0);" >
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </span>
                            </small>
                        </div>

                        <a id="save_scada" class="btn blue btn-outline theMargin" href="javascript:void(0);" >
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            <span>Guardar Cambios </span>
                        </a>
                        <div class="nav-divider"></div>
                        <a href="javascript:void(0);" onclick="$('#scada-modal-delete-project').modal({'backdrop': false });" class="btn red btn-outline theMargin" href="" >
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            <span>Eliminar Scada &nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </a>
                    </div>
                </div>


            </div>



            <div class="portlet-body ">

                <div id="frame" style="
                                position: relative;
                                border: solid 1px gray;
                                height: 100%;
                                min-height:800px;
                                background-color:white">
                </div>

            </div>
        </div>




    </div>


</div>
</div>

<!--modal elementos flotantes -->
<div style="display:none;" id='scada-show'>
    <a id="scada-show-more" class="" href="javascript:void(0);" >
        <i  style="cursor:pointer;" class="fa fa-plus" aria-hidden="true">
        </i>
    </a>
    <a  id="scada-delete-node" class="" href="javascript:void(0);" >
        <i  style="cursor:pointer;" class="fa fa-trash" aria-hidden="true">
        </i>
    </a>
</div>







<!-- MODAL DE PROPIEDADES DEL OBJETO -->
<div id="scada-modal" class="modal fade " role="dialog">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">...</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"  href="#_general">
                            <i class="fa fa-certificate" aria-hidden="true"></i>
                            General
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab"  href="#_props">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            Propiedades
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab"  href="#_others">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            Otros
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab"  href="#_func">
                            <i class="fa fa-code" aria-hidden="true"></i>
                            Algoritmo
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab"  href="#_graph">
                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                            Graficos
                        </a>
                    </li>
                </ul>


                <div class="tab-content">


                    <div id="_general" class="tab-pane fade in active">


                        <form style="margin-top:20px;" class="form-horizontal">

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">ID</label>
                                <div class="col-sm-4">
                                    <input disabled="disabled" type="text" class="form-control" id="obj_id" />
                                </div>

                                <label for="" class="col-sm-1 control-label">Key</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="obj_key" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="obj_name" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Categoria</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="obj_cat" />
                                </div>

                                <label for="" class="col-sm-1 control-label">Activo</label>
                                <div class="col-sm-5">
                                    <input id="obj_active" type="checkbox" checked="checked" />
                                </div>
                            </div>


                        </form>
                    </div>
                    <div id="_props" class="tab-pane fade">

                        <form style="margin-top:20px;" class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">PosX</label>
                                <div class="col-sm-4">
                                    <input disabled="disabled" type="text" class="form-control" id="obj_x" />
                                </div>

                                <label for="" class="col-sm-1 control-label">PosY</label>
                                <div class="col-sm-4">
                                    <input disabled="disabled" type="text" class="form-control" id="obj_y" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Texto</label>
                                <div class="col-sm-5">
                                    <input  type="text" class="form-control" id="obj_text" />
                                </div>

                                <label for="" class="col-sm-1 control-label">Var</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="obj_var" />
                                     <option value="-1">/</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Descripcion</label>
                                <div class="col-sm-9">
						<textarea  type="text" class="form-control" id="obj_description">
						</textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Restricciones</label>
                                <div class="col-sm-9">
                                    <input  type="text" class="form-control" id="obj_restrict" />
                                    <small>Las restricciones es el "Key" del objeto separadas por comas (,)</small>
                                </div>
                            </div>


                        </form>

                    </div>
                    <div id="_others" class="tab-pane fade">
                        <form id="_others_frm" style="margin-top:20px;" class="form-horizontal">
                        </form>
                    </div>
                    <div id="_func" class="tab-pane fade">
                        <form id="_func_frm" style="margin-top:20px;" class="form-horizontal">
                        </form>
                    </div>
                    <div id="_graph" class="tab-pane fade">
                        <h3>Menu 3</h3>
                        <p>Some content in menu 3.</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                <button id="save_modal_data" type="button" data-dismiss="modal" class="btn btn-primary">Guardar</button>
            </div>

        </div>
    </div>
</div>




<!-- MODAL DE ELIMINACION DEL OBJETO -->
<div id="scada-modal-delete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Eliminar Objeto </h4>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea eliminar {object} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
                <button id="delete-action-scada" type="button" data-dismiss="modal" class="btn btn-primary">Eliminar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL DE ELIMINACION DEL SCADA  -->
<div id="scada-modal-delete-project" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Eliminar SCADA </h4>
            </div>
            <div class="modal-body">
                <center>
                <p>¿Seguro que desea eliminar completamente el proyecto ?</p>
                <p>Nota : <b>si se elimina no se podra recuperar.</b></p>
                    <p id="del-load-scada">
                    </p>
                </center>
            </div>
            <div class="modal-footer">
                <button id="delete-cancel-scada-project" type="button" data-dismiss="modal" class="btn">Cancelar</button>
                <button  id="delete-action-scada-project" type="button"  class="btn btn-primary">Eliminar</button>
            </div>
        </div>
    </div>
</div>



<!-- MODAL INFORMACION SCADA  -->
<div id="scada-help" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informacion Scada</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"  href="#_ax">
                            <i class="fa fa-certificate" aria-hidden="true"></i>
                            General
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab"  href="#_ay">
                            <i class="fa fa-code" aria-hidden="true"></i>
                            Variables Reservadas
                        </a>
                    </li>
                </ul>


                <div class="tab-content">


                    <div id="_ax" class="tab-pane fade in active">

                        <form style="margin-top:20px;" class="form-horizontal">

                        </form>


                    </div>
                    <div id="_ay" class="tab-pane fade">



                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button  button type="button" data-dismiss="modal" class="btn">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>

    var ControlDate = $("#control-dates");

    $(window).ready(function(){
            init_scada();
    });

    $(document).ready(function () {
        if(go === 'undefined')
            init_scada();
    });


    function init_scada () {
        conf = new ScadaConf();
        conf.init();
    }



    class ScadaConf {

        constructor(){

            this.device         = null;
            this.variables      = null;
            this.scadaInf       = null;

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };


        }

        init(){




            try {
                //instanciamos el scada
                scada = new Scada();


                //creamos un objeto del dispositivo obtenido
                try {
                    this.device = JSON.parse(device);
                    this.variables = JSON.parse(variables);
                    this.scadaInf = JSON.parse(scadaInf);
                } catch (e) {
                    console.log("ERROR-> NO SE ENCUENTRA EL DISPOSITIVO ");
                    console.log(e);
                }

                //llamada a funciones de instancia
                this.paramsIntance();


                //llamada de querys de instancia
                this.queryInit();
            }catch (e){
                console.log(e);
                toastr["error"]("Error al momento de cargar la interfaz de SCADA \n Favor reflescar denuevo o control F5 ", "Error :( ");
            }

        }

        paramsIntance(){


            //configuracionbasica del scada
            scada.setConfLocale({

                canvas      	: "frame",
                control     	: "controls",
                savebtn     	: "#save_scada",
                img_location 	: "<?=$url?>content/assets/apps/scada/images/{pattern}.png",
                controlPipe		: "controls-pipes"

            });


            //let s = JSON.stringify(scadaData);
            //console.log(JSON.parse(scadaData));
            //si existe un scada a modificar o cargar
            if(scadaData != ''  )
                scada.addData(scadaData);

            //configuracion definida para el scada al momento de guardar
            scada.addConfig( {
                id      : this.scadaInf.id_scada != 'undefined' ? this.scadaInf.id_scada : 0 ,
                name    : "#scada_name",
                device  : this.device.id_device,
                func    : function(b){
                    //{"status":true,"msj":"Cambios guardados con exito ","id":"1"}
                    try{
                        let m = JSON.parse(b);
                        switch (m.status){
                            case true:
                                toastr["success"](m.msj, "Cambios guardados ");
                                break;
                            case false:
                                toastr["error"](m.msj, "Error :( ");
                                break;
                        }

                    }catch (e){}

                   // console.log(b);
                }
            });

            // agregamos los items que existen en el sistema
            // esta area se podria optimizar creando un podulo en cual el operador creara items
            let items = [

                {
                    text: "Tanque 0%",
                    name : "Tank",
                    keys : "_tank",
                    figure: "Cylinder1",
                    stroke : "black",
                    fill:  scada.$$(go.Brush, "Linear",
                        {
                            start: go.Spot.Bottom ,
                            end: go.Spot.Top,
                            0		: "blue",
                            0.05 	: "white",
                            0.1 	: "white ",
                            0.2 	: "white",
                            0.3     : "white" ,
                            0.4 	: "white",
                            0.5		: "white",
                            0.6     : "white",
                            0.7     : "white",
                            0.8     : "white",
                            0.9     : "white",
                            1		: "white"
                        }
                    ),
                    minSize				: new go.Size(100, 100),
                    fromSpot			: go.Spot.AllSides,
                    toSpot				: go.Spot.AllSides,
                    desiredSize 		: new go.Size(35, 35),
                    category 			: 'SCADA_A',
                    sid 				: null,
                    properties 			: [

                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active"  , alias : "Activo", value : false , 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "select" , system : false },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize" 	, value : { max : 0, min : 0, percent:0 ,  type : "tank" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  [] , control : "input" , system : false },
                        { name : "description" , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : ""  , alias : "Funcion" , value : function (){

                            /**
                             * En las cadenas favor no utilizar comillas dobles
                             * ya que si se utilizan se remplazaran por comillas simples
                             * **/

                            /**
                             *  este algoritmo es un ejemplo de como se podria llenar el
                                tanque a base de calculos matematicos basicos
                             */

                            var $this = scada;
                            var it = 0 ;
                            var TransName = 'Mytank' + String(Math.random());



                            setInterval(function(){

                                $this.StartTrans(TransName , $this );

                                $this.canvas.nodes.each(function(node){

                                    if(node.part.data.keys !== '_tank') return ;

                                    if(it > 19 ) it = 0 ;

                                    let build = {
                                        start: go.Spot.Bottom ,
                                        end: go.Spot.Top
                                    };

                                    for(var i = 0 ; i < 19 ; i++ ){

                                        if(i < it){
                                            build[String(i/20)] = 'blue';
                                        }
                                        else build[String(i/20)] = 'white';

                                    }
                                    it++;
                                    let fill   = $this.$$(go.Brush, 'Linear', build );
                                    let percent = Math.round((it/20) * 100) ;


                                    if(percent >= 60){
                                        $this.canvas.model.setDataProperty(node.data, 'stroke', 'white' );
                                    }
                                    else {
                                        $this.canvas.model.setDataProperty(node.data, 'stroke', 'black' );
                                    }

                                    $this.canvas.model.setDataProperty(node.data, 'text', 'Tanque ' +  percent + '%' );
                                    $this.canvas.model.setDataProperty(node.data, 'fill', fill);

                                });


                                $this.CommitTrans(TransName , $this);




                            } , 2000);

                        } , control : "input-code" , system : false }

                    ]

                },

                {
                    text: "Flujometro",
                    value: 0 ,
                    category:"SCADA_GAUGE_1",
                    figure : "flow_sensor",
                    keys : "_flowsensor",
                    name : "Gauge",
                    sid : null ,
                    width : 100 ,
                    height: 100,
                    properties 			: [
                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active"  , alias : "Activo", value : true , 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "select" , system : false },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize" , alias : "Control" 	, value : { max : 0, min : 0,type : "flujometer" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  [ "_manometer" , "_flowsensor" ] , control : "input" , system : true },
                        { name : "description" , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : ""  , alias : "Funcion" , value : function(){

                            /**
                             * En las cadenas favor no utilizar comillas dobles
                             * ya que si se utilizan se remplazaran por comillas simples
                             * **/

                            /**
                             *  este algoritmo es un ejemplo de como se podria llenar el
                             tanque a base de calculos matematicos basicos
                             */


                            var $this = scada;
                            var TransName = 'MyFlow' + String(Math.random());


                            setInterval(function() {


                                //Funcion scada para transferir informacion al canvas
                                $this.StartTrans(TransName , $this );

                                //analizamos los nodos
                                $this.canvas.nodes.each(function(node) {


                                    //verificamos que el noso a generar sea sensor de flujo
                                    if(node.part.data.keys  !== '_flowsensor') return ;


                                    //buscamos el objeto de escala en cual generara
                                    var scale = node.findObject('SCALE');


                                    //si la escala es nulla detener todo
                                    if (scale === null || scale.type !== go.Panel.Graduated) return;

                                    //generamos el min y el max
                                    var min = scale.graduatedMin;
                                    var max = scale.graduatedMax;

                                    //creamos un valor basados en min y max
                                    var v = node.data.value || Math.floor((max - min) / 2);

                                    //condicionales
                                    if (v < min) v++;
                                    else if (v > max) v--;
                                    else v += (Math.random() < 0.5) ? -0.5 : 0.5;

                                    //enviamos el valor
                                    $this.canvas.model.setDataProperty(node.data, 'value', v);

                                });

                                //enviar commit a los datos actualizados
                                $this.CommitTrans(TransName , $this);
                            }, 5000/6);


                        } , control : "input-code" , system : false }
                    ]
                },


                {
                    text: "Manometro",
                    value: 0 ,
                    category:"SCADA_GAUGE_2",
                    figure : "manom_sensor",
                    keys  : "_manometer",
                    name : "Gauge",
                    properties : [],
                    styles : [],
                    func : null,
                    state : { active : true } ,
                    sid : null ,
                    width : 100 ,
                    height: 100,
                    properties : [
                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active" 		, alias : "Activo"	, value : true, 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "" , system : true  },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize"  , alias : "Control"	, value : { max : 0, min : 0,type : "manometer" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  ["_flowsensor" , "_manometer"] , control : "" , system : false },
                        { name : "description"  , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : "" , alias : "Funcion" , value : function(){

                            /**
                             * En las cadenas favor no utilizar comillas dobles
                             * ya que si se utilizan se remplazaran por comillas simples
                             * **/

                            /**
                             *  este algoritmo es un ejemplo de como se podria llenar el
                             tanque a base de calculos matematicos basicos
                             */


                            var $this = scada;
                            var TransName = 'Mymano' + String(Math.random());


                            setInterval(function() {


                                //Funcion scada para transferir informacion al canvas
                                $this.StartTrans(TransName , $this );

                                //analizamos los nodos
                                $this.canvas.nodes.each(function(node) {


                                    //verificamos que el noso a generar sea sensor de flujo
                                    if(node.part.data.keys  !== '_manometer') return ;


                                    //buscamos el objeto de escala en cual generara
                                    var scale = node.findObject('SCALE');


                                    //si la escala es nulla detener todo
                                    if (scale === null || scale.type !== go.Panel.Graduated) return;

                                    //generamos el min y el max
                                    var min = scale.graduatedMin;
                                    var max = scale.graduatedMax;

                                    //creamos un valor basados en min y max
                                    var v = node.data.value || Math.floor((max - min) / 2);

                                    //condicionales
                                    if (v < min) v++;
                                    else if (v > max) v--;
                                    else v += (Math.random() < 0.5) ? -0.5 : 0.5;

                                    //enviamos el valor
                                    $this.canvas.model.setDataProperty(node.data, 'value', v);

                                });

                                //enviar commit a los datos actualizados
                                $this.CommitTrans(TransName , $this);

                            }, 5000/6);


                        } , control : "input-code" , system : false }

                    ]
                },
                {
                    name 		: "Photon",
                    keys 		: "_photon",
                    value 		: null ,
                    src 		: "Photon",
                    sid 		: null ,
                    category 	: "SCADA_B",
                    figure		: "_particle",
                    text 		: 'Photon',
                    properties 			: [

                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active"  		,	alias : "Activo", value : false , 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "select" , system : false },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize" 	, value : { photonID : "" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  [ "_tank" , "_flowsensor" , "_manometer"] , control : "input" , system : false },
                        { name : "description" , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : ""  , alias : "Funcion" , value : function(){} , control : "input-code" , system : false }
                    ]
                },

                {
                    name 		: "Cloud",
                    keys 		: "_photon_cloud",
                    value 		: null ,
                    src 		: "cloud-1",
                    sid 		: null ,
                    category 	: "SCADA_B",
                    figure		: "_particle_cloud",
                    text 		: 'Cloud',
                    properties 			: [

                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active"  		,	alias : "Activo", value : false , 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "select" , system : false },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize" 	, value : { particleId : "" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  [ "_tank" , "_flowsensor" , "_manometer"] , control : "input" , system : false },
                        { name : "description" , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : ""  , alias : "Funcion" , value : function(){

                            var $this = scada;


                            var verify = function(){

                                $this.canvas.startTransaction();

                                $this.canvas.nodes.each(function(node) {

                                    if(node.part.data.keys  !== '_photon_cloud') return ;
                                    $this.canvas.model.setDataProperty(node.data, 'src', 'cloud-2' );
                                });

                                $this.canvas.commitTransaction('Iniciando modificacion ...');

                            };

                            setTimeout(verify , 5000);


                        } , control : "input-code" , system : false }
                    ]
                },

                {
                    text: "Agrega un texto",
                    name : "textbloc",
                    keys : "_textbloc",
                    figure: "Rectangle",
                    stroke : "white" ,
                    fill:  scada.$$(go.Brush, "Linear",
                        {
                            start: go.Spot.Bottom ,
                            end: go.Spot.Top,
                            1		: "black"

                        }
                    ),
                    minSize				: new go.Size(100, 100),
                    fromSpot			: go.Spot.AllSides,
                    toSpot				: go.Spot.AllSides,
                    desiredSize 		: new go.Size(35, 35),
                    category 			: 'SCADA_A',
                    sid 				: null,
                    properties 			: [

                        { name : "variable" 	, alias : "Variables" ,  value : null , func : null , control : "" , system : true    },
                        { name : "active"  , alias : "Activo", value : false , 	func : null  , control : "" , system : true   },
                        { name : "styles" 		, value : [] ,  func : null , control : "select" , system : false },
                        { name : "graph" 		, value : { type : "linear" , data : {}  } , func : null , control : "graph" , system : false  },
                        { name : "personalize" 	, value : { max : 0, min : 0, percent:0 ,  type : "tank" } , func : null , control : "input" , system : false  },
                        { name : "restrict" 	, alias : "Restricciones" , value :  [] , control : "input" , system : false },
                        { name : "description" , alias : "Descripcion" , value : "..." , control : "" , system : true },
                        { name : "function" , backup : ""  , alias : "Funcion" , value : function(){} , control : "input-code" , system : false }

                    ]

                }





            ];
            let items2 = [];

            //agregamos los dos controles
            scada.setControls(items , items2 );
            //creamos el scada
            scada.Create();


        }

        queryInit(){



            //querys js en cual se llena la informacion correspondiente
            $("#obj_active").bootstrapSwitch();
            $("#proyect_title").html(this.device.name);

            //informacion del scada por medio de su entrada
            $("#proyect_subtitle").html( "id(" +  this.device.particle_id + ")");
            $("#scada_name").val(this.scadaInf.name != 'undefined' ? this.scadaInf.name : '');
            $("#scada-id").val(this.scadaInf.id_scada);


            //llenamos con las variables del proyecto
            $.map(this.variables , function (b) {
                $("#obj_var").append("<option value='" + b.id_variables + "'>"+ b.name + "</option>")
            });




            $("#delete-action-scada-project").click(function () {

                let l = $("#del-load-scada");
                let p = $("#delete-cancel-scada-project");

                p.css({display : 'none'});
                $(this).css({display: 'none'});
                l.html("<img width='200px' height='150px' src='" + $("#ga_url").val() +"content/system/files/img/scada-loading.gif' /><p id='delete-mess'><b>ELIMINANDO...</b></p>")

                project_data.scada.delete_scada($("#scada-id").val(), function (result) {

                    if(typeof result === 'string')
                        result = JSON.parse(result);

                    $("#delete-mess").html("<b>" + result.msj + "</b> <p>Recargando Espere...</p>" );
                    switch (result.status){
                        case true:
                            let o = function () {
                                window.location.href = $("#ga_url").val();
                            };
                            window.setTimeout(o , 3500);
                            break;
                        case false:
                            let p = function () {
                                window.location.reload();
                            };
                            window.setTimeout(p , 4000);
                            break;
                    }

                });

            });


            //analizamos las fechas para ver si control-dates se habilitara segun algoritmo

            var select_data = [];
            if(typeof  scadaws !== 'undefined'){
                if(typeof scadaws == 'object' ){
                    let z = Object.keys(scadaws);
                    let a = z[0];
                    let u = scadaws[a].values;
                    for(let j in u ) {
                        select_data.push({
                            id : j ,
                            text : j
                        });
                    }
                }
                else {
                    ControlDate.prop("disabled" , true);
                }
            }



            $.fn.select2.defaults.set("theme", "bootstrap");

            ControlDate.select2({
                allowClear: !0,
                placeholder: 'Filtra por fechas',
                width: null,
                data : select_data
            });


            //verificamos si el draggable se ha instanciado
            function k () {
                setTimeout(function () {

                    try{
                        $("#controls-pipes").draggable();
                        $("#overview").draggable();
                        $("#controls-data").draggable();
                    }catch (e){
                        console.log(e);
                        k();
                    }

                } , 500);

            }
            //llamada de k
            k();

            //console.log(this.device);
            //console.log(this.variables);
            //console.log(this.scadaInf);

        }

    }

</script>
