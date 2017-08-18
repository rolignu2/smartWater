[PageBar ; {"name":"Home" , "url":"<?php echo dashboard_url(); ?>"}, {"name" : "Servicios" , "url" : ""} , {"name" : "Configuracion"} ]


<style>

    .mt-checkbox-list, .mt-radio-list {
        padding: 10px 0;
    }

    .input-icon>i, .mt-checkbox-list .mt-checkbox, .mt-checkbox-list .mt-radio, .mt-checkbox>input:checked~span:after, .mt-radio-list .mt-checkbox, .mt-radio-list .mt-radio, .mt-radio>input:checked~span:after {
        display: block;
    }

    .mt-checkbox, .mt-radio {
        display: inline-block;
        position: relative;
        padding-left: 30px;
        margin-bottom: 15px;
        cursor: pointer;
        font-size: 14px;
        webkit-transition: all .3s;
        -moz-transition: all .3s;
        -ms-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
    }


    .mt-checkbox:hover>input:not([disabled])~span, .mt-checkbox>input:focus~span, .mt-radio:hover>input:not([disabled])~span, .mt-radio>input:focus~span {
        background: #d9d9d9;
        webkit-transition: all .3s;
        -moz-transition: all .3s;
        -ms-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
    }

    .mt-checkbox>input, .mt-radio>input {
        position: absolute;
        z-index: -1;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .mt-checkbox>span, .mt-radio>span {
        border: 1px solid transparent;
        position: absolute;
        top: 0;
        left: 0;
        height: 19px;
        width: 19px;
        background: #E6E6E6;
    }

    .mt-checkbox, .mt-radio {
        display: inline-block;
        position: relative;
        padding-left: 30px;
        margin-bottom: 15px;
        cursor: pointer;
        font-size: 14px;
        webkit-transition: all .3s;
        -moz-transition: all .3s;
        -ms-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
    }

</style>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Servicios Generales
    <small>Configura los servicios de forma general.</small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Configuracion Servicio Scada (WS->SYSTEM)</span>
                </div>

            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox"> ACTIVAR BASE DE DATOS HISTORICA ( esta informacion es de tres meses atras )
                                    <input type="checkbox" value="1" name="scada_his" />
                                    <span></span>
                                </label>
                                <label class="mt-checkbox"> ACTIVAR RANGO DE FECHAS
                                    <input type="checkbox" value="1" name="scada_date_range" id="scada_date_range"/>
                                    <span></span>
                                </label>
                            </div>

                            <div style="display:none;" id="scada_date_range_show" class="form-group">


                                <div class="col-md-4">
                                    <div class="input-group input-large date-picker input-daterange" data-date="" data-date-format="yy-mm-dd">
                                        <input type="text" class="form-control" name="from">
                                        <span class="input-group-addon"> Hasta </span>
                                        <input type="text" class="form-control" name="to">
                                    </div>
                                    <span class="help-block"> Seleccionar un rango de fechas  </span>

                                </div>
                                <br><br><br><br>
                            </div>

                            <div class="form-group">

                                <label class="mt-checkbox"> ACTIVAR DELAY EN EL SERVICIO SCADA ( [ crea la opcion yyy-mm-dd h:m en vez de solo yyy-mm-dd  ])
                                    <input type="checkbox" value="1" name="test" />
                                    <span></span>
                                </label>
                            </div>
                        </div>


                    </div>
            </div>

            <div class="note note-info">
                <p> Estas configuraciones hace que el comportamiento de la data entregada por cada dispositivo en el servicio web  </p>
                <p> tenga un mejor impacto en la aplicacion de scada (interfaz grafica ). </p>
                <br>
                <p> <b>Aviso</b> : si se activa la historica y esta tiene datos de +6 meses atras , favor activar tambien el rango de fechas </p>
                <p> para asi evitar un timeout en el servidor o un comportamiento anormal.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn blue">Guardar Configuracion </button>
            </div>
            </form>
        </div>
    </div>

</div>


<script>

    let date_range = $("#scada_date_range");


    date_range.click( function(){
        let date_range_show = $("#scada_date_range_show");
        if($(this).prop("checked")){
            date_range_show.css({ display : "inline"});
        }
        else {
            date_range_show.css({ display : "none"});
        }
    });


    var t = function() {
        jQuery().datepicker && $(".date-picker").datepicker({
           // rtl: App.isRTL(),
            orientation: "left",
            autoclose: !0
        }), $(document).scroll(function() {
            $("#form_modal2 .date-picker").datepicker("place")
        })
    };

    t();

</script>
