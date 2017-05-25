<style>

    .text {
        font-size:2em;
        font-family:helvetica;
        font-weight:bold;
        color:blue;
        text-transform:uppercase;
    }
    .parpadea {

        animation-name: parpadeo;
        animation-duration: 2.5s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 2.5s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
    }

    @-moz-keyframes parpadeo{
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @-webkit-keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }

    @keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
    }


    .nav-tabs>li>a{

        margin-right : -3px !important;
    }

    .page-content {
        background-color: #eef1f5 !important;
    }





</style>


<div class="row">
    <div id="render_project" class="col-md-12">


    </div>
</div>


<script>

    var $purl = '<?= $purl; ?>';
    var $pget = '<?= $pget ?>';

    $(window).load(function() {

        //$(".page-content").attr("style" , "background:#eef1f5 !important;");
    });

</script>