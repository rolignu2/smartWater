
<style>

    .page-title small {
        margin-left: 4px;
    }

    .actions >a {
        margin-right: 11px;
    }


    .alert  {
        border-width: 1px;
        padding: 0px !important;
        margin-left: 17px;
        text-transform: uppercase;
        font-size: 13px;
    }

</style>


<script>


    /****
     * CARGA DE INFORMACION DESDE EL BACK-END
     * ****/

    var $purl  = '<?= $purl ?>';
    var $phurl = '<?= $phurl ?>';
    var $dev   = '<?= $dev ?>';
    var $vdata = '<?= $variables ?>';

    var $serv  = {
        cmd : {
            test : 'TEST_VAR'
        },
        func : {
            war : 'war'
        },
        max : 15,
        var_type   : [
            { name : "ANALOG INPUT" ,   value : "AI" } ,
            { name : "DIGITAL INPUT" ,  value : "DI"} ,
            { name : "ANALOG OUTPUT" ,  value : "AO"} ,
            { name : "DIGITAL OUTPUT" , value : "DO"} ,
            { name : "VIRTUAL" ,        value : "VI"} ,
        ],
        var_format : [
            { name : "STRING" ,     value : "s"  },
            { name : "INTEGER" ,    value : "i"  },
            { name : "DOUBLE" ,     value : "d"  }
        ]
    };

</script>



<div id="react-variables" class="row"></div>
