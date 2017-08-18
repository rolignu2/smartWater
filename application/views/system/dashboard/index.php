<!-- [get_memory] -->

<style>

    .mt-head-user .mt-head-user-info {
        color: darkblue !important;
    }


    .mt-widget-2 .mt-body .mt-body-title {
        color: darkblue !important;
    }

    .dash_margin {

        margin-left: 10px;
        margin-right: 10px;
    }

    .dash_margin select {
        margin-bottom : 4px;
    }

</style>


<div class="page-bar">
<ul class="page-breadcrumb">
    <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Dashboard</span>
    </li>
</ul>
<div class="page-toolbar">
    <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
        <i class="icon-calendar"></i>&nbsp;
        <span class="thin uppercase hidden-xs"></span>&nbsp;
        <i class="fa fa-angle-down"></i>
    </div>
</div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">
    <small></small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">

    <div id="project-dash" class="col-md-12">



    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="6">0</span>
                        <small class="font-green-sharp"></small>
                    </h3>
                    <small>Variables creadas</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                                        <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">

                                        </span>
                </div>
                <div class="status">
                    <div class="status-title"> Total </div>
                    <div class="status-number"> 6/15 </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-red-haze">
                        <span data-counter="counterup" data-value="1500">0</span>
                    </h3>
                    <small>Datos</small>
                </div>
                <div class="icon">
                    <i class="icon-like"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                                        <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                                            <span class="sr-only">85% change</span>
                                        </span>
                </div>
                <div class="status">
                    <div class="status-title"> En los ultimos 3 meses </div>
                    <div class="status-number"> 85% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="2"></span>
                    </h3>
                    <small>Funciones</small>
                </div>
                <div class="icon">
                    <i class="icon-basket"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                                        <span style="width: 2%;" class="progress-bar progress-bar-success blue-sharp">

                                        </span>
                </div>
                <div class="status">
                    <div class="status-title"> Apps creadas </div>
                    <div class="status-number"> 2/ ∞</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft">
                        <span data-counter="counterup" data-value="3"></span>
                    </h3>
                    <small>Usuarios</small>
                </div>
                <div class="icon">
                    <i class="icon-user"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                                        <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">

                                        </span>
                </div>
                <div class="status">
                    <div class="status-title"> ADMINISTRADORES </div>
                    <div class="status-number"> 3/∞ </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        // alert();

        console.log("[CONSOLE] -> INICIANDO EL READY DEL DOCUMENT ");
        var mount_d =  document.getElementById("project-dash");
        ReactDOM.render(React.createElement(DashBoardProject), mount_d);


    });



</script>

