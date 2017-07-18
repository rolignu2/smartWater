

class ScadaError {

    ObjectError(name , type ){
        console.log("ERROR -> " + name  + " T ->" + type );
    }

}


class ScadaTools extends ScadaError  {

    constructor(){
        super();
        this.canvasId 		= "frame";
        this.canvasData     = {};
        this.$$ 			= go.GraphObject.make;
        this.canvas 		= null;
        this.controlId		= "controls";
        this.control 		= null ;
        this.pipeId 		= null ;
        this.controlPipe 	= null ;
        this.saveBtn		= "#save_scada";
        this.imgLocation    = "images/{pattern}.png";
        this.modelData		= null;
        this.controlData    = null ;
        this.controlData2   = null ;

    }

    init(){

        //creamos el puntero de go


        //configuraciones iniciales para el frame tambien llamado canvas
        this.canvas 		= this.$$(go.Diagram, this.canvasId,
            {
                grid: this.$$(go.Panel, "Grid",
                    this.$$(go.Shape, "LineH", { stroke: "lightgray", strokeWidth: 0.5 }),
                    this.$$(go.Shape, "LineH", { stroke: "gray", strokeWidth: 0.5, interval: 10 }),
                    this.$$(go.Shape, "LineV", { stroke: "lightgray", strokeWidth: 0.5 }),
                    this.$$(go.Shape, "LineV", { stroke: "gray", strokeWidth: 0.5, interval: 10 })
                ),
                allowDrop: true,
                draggingTool: new GuidedDraggingTool(),
                "draggingTool.dragsLink": true,
                "draggingTool.isGridSnapEnabled": true,
                "linkingTool.isUnconnectedLinkValid": true,
                "linkingTool.portGravity": 20,
                "relinkingTool.isUnconnectedLinkValid": true,
                "relinkingTool.portGravity": 20,
                "relinkingTool.fromHandleArchetype":
                    this.$$(
                        go.Shape,
                        "Diamond", {
                            segmentIndex: 0,
                            cursor: "pointer",
                            desiredSize: new go.Size(8, 8),
                            fill: "tomato",
                            stroke: "darkred"
                        }),
                "relinkingTool.toHandleArchetype":
                    this.$$(go.Shape, "Diamond", { segmentIndex: -1, cursor: "pointer", desiredSize: new go.Size(8, 8), fill: "darkred", stroke: "tomato" }),
                "linkReshapingTool.handleArchetype":
                    this.$$(go.Shape, "Diamond", { desiredSize: new go.Size(7, 7), fill: "lightblue", stroke: "deepskyblue" }),
                //rotatingTool: $(this.TopRotatingTool),
                "rotatingTool.snapAngleMultiple": 15,
                "rotatingTool.snapAngleEpsilon": 15,
                "undoManager.isEnabled": true
            });



        this.nodeSelectionAdornmentTemplate =
            this.$$(go.Adornment, "Auto",
                this.$$(go.Shape, {
                    fill: null,
                    stroke: "deepskyblue",
                    strokeWidth: 1.5,
                    strokeDashArray: [4, 2] }),
                this.$$(go.Placeholder)
            );

        this.nodeResizeAdornmentTemplate =
            this.$$(go.Adornment, "Spot",
                { locationSpot: go.Spot.Right },
                this.$$(go.Placeholder),
                this.$$(go.Shape, { alignment: go.Spot.TopLeft, cursor: "nw-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { alignment: go.Spot.Top, cursor: "n-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { alignment: go.Spot.TopRight, cursor: "ne-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),

                this.$$(go.Shape, { alignment: go.Spot.Left, cursor: "w-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { alignment: go.Spot.Right, cursor: "e-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),

                this.$$(go.Shape, { alignment: go.Spot.BottomLeft, cursor: "se-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { alignment: go.Spot.Bottom, cursor: "s-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { alignment: go.Spot.BottomRight, cursor: "sw-resize", desiredSize: new go.Size(6, 6), fill: "lightblue", stroke: "deepskyblue" })
            );

        this.nodeRotateAdornmentTemplate =
            this.$$(go.Adornment,
                { locationSpot: go.Spot.Center, locationObjectName: "CIRCLE" },
                this.$$(go.Shape, "Circle", { name: "CIRCLE", cursor: "pointer", desiredSize: new go.Size(7, 7), fill: "lightblue", stroke: "deepskyblue" }),
                this.$$(go.Shape, { geometryString: "M3.5 7 L3.5 30", isGeometryPositioned: true, stroke: "deepskyblue", strokeWidth: 1.5, strokeDashArray: [4, 2] })
            );


        /**
         Creando las plantillas para los objetos SCADA
         ***/

        this._TemplateMap  = new go.Map("string", go.Node);
        this._TemplateMap.add("SCADA_A", this._FigureTemplate());
        this._TemplateMap.add("SCADA_B", this._ImageTemplate());
        this._TemplateMap.add("SCADA_PIPE" , this._PipeTemplate());
        this._TemplateMap.add("SCADA_GAUGE_1" , this._GaugeTemplate());
        this._TemplateMap.add("SCADA_GAUGE_2" , this._GaugeTemplate("flow"));
        this.canvas.nodeTemplateMap = this._TemplateMap;



        this._linkTemplate();  //carga las plantillas
        //this._tackTemplate();
        this._load(); 		   //carga multiple
        this._loop();		  //cargar loops
        this._controlBar();   //cargar el area de controladores
        this._documentChange(); //carga la funcion change del documento

    }

    _ImageTemplate(){

        var $this = this;
        return this.$$(go.Node, "Spot",
            {
                locationSpot: go.Spot.Center
            },
            new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
            { selectable: true, selectionAdornmentTemplate: this.nodeSelectionAdornmentTemplate },
            { resizable: true, resizeObjectName: "PANEL", resizeAdornmentTemplate: this.nodeResizeAdornmentTemplate },
            { rotatable: true, rotateAdornmentTemplate: this.nodeRotateAdornmentTemplate },
            new go.Binding("angle").makeTwoWay(),
            this.$$(go.Panel, "Auto",
                {
                    name: "PANEL"
                },
                new go.Binding("desiredSize",
                    "size",
                    go.Size.parse
                ).makeTwoWay(go.Size.stringify),
                this.$$(go.TextBlock,
                    new go.Binding("text", "text")
                ),
                this.$$(go.Picture,
                    {
                        desiredSize: new go.Size(180, 150)
                    },
                    new go.Binding("source", "src",
                        function(s)
                        {
                            //console.log($this.imgLocation);
                            return String($this.imgLocation)
                                .replace("{pattern}" , s).toString() ;
                        }
                    ))
            ),
            this._makePort("T", go.Spot.Top, false, true  ),
            this._makePort("L", go.Spot.Left, true, true),
            this._makePort("R", go.Spot.Right, true, true),
            this._makePort("B", go.Spot.Bottom, true, false),
            {
                mouseEnter: function(e, node ) { scada.showSmallPorts(node, true ); },
                mouseLeave: function(e, node ) { scada.showSmallPorts(node, false ); }
            }
        );

    }

    _FigureTemplate (){
        return this.$$(go.Node, "Spot",
            {
                locationSpot: go.Spot.Center
            },
            new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
            {
                selectable: true,
                selectionAdornmentTemplate: this.nodeSelectionAdornmentTemplate
            },
            {
                resizable: true,
                resizeObjectName: "PANEL",
                resizeAdornmentTemplate: this.nodeResizeAdornmentTemplate
            },
            {
                rotatable: true,
                rotateAdornmentTemplate: this.nodeRotateAdornmentTemplate
            },
            new go.Binding("angle").makeTwoWay(),
            this.$$(go.Panel, "Auto",
                {
                    name: "PANEL"
                },
                new go.Binding("desiredSize", "size", go.Size.parse)
                    .makeTwoWay(go.Size.stringify),
                this.$$(go.Shape, "Rectangle",
                    {
                        portId: "",
                        fromLinkable: true,
                        toLinkable: true,
                        cursor: "pointer",
                        fill: "white",
                        strokeWidth: 2,
                    },
                    new go.Binding("figure"),
                    new go.Binding("fill")
                ),
                this.$$(go.TextBlock,
                    {
                        font: "bold 11pt Helvetica, Arial, sans-serif",
                        margin: 8,
                        maxSize: new go.Size(160, NaN),
                        wrap: go.TextBlock.WrapFit,
                        editable: true,
                        stroke : "black"
                    },
                    new go.Binding("text").makeTwoWay(),
                    new go.Binding("stroke")
                )
            ),
            this._makePort("T", go.Spot.Top, false, true  ),
            this._makePort("L", go.Spot.Left, true, true),
            this._makePort("R", go.Spot.Right, true, true),
            this._makePort("B", go.Spot.Bottom, true, false),
            {
                mouseEnter: function(e, node ) { scada.showSmallPorts(node, true ); },
                mouseLeave: function(e, node ) { scada.showSmallPorts(node, false ); }
            }
        );

    }

    _GaugeTemplate( type = "manometer"){

        //template especial para general el sistema de sensores

        var s = "Rectangle";
        var t = "Blue";
        var k = "White"

        if(type == "flow"){
            s= "Circle";
            t = "Red";
            k = "Yellow";
        }


        return  this.$$(go.Node, "Auto",
            {
                //resizable: true//,
                locationSpot: go.Spot.Center
            },
            new go.Binding("angle").makeTwoWay(),
            new go.Binding('width').makeTwoWay(),
            new go.Binding('height').makeTwoWay(),
            this.$$(go.Shape, s,
                {
                    width : 100 ,
                    height : 100 ,
                    stroke: t,
                    strokeWidth: 0,
                    spot1: go.Spot.TopLeft,
                    spot2: go.Spot.BottomRight },
                new go.Binding("stroke", "color")),
            this.$$(go.Panel, "Spot",
                this.$$(go.Panel, "Graduated",
                    {
                        width : 95 ,
                        height : 95 ,
                        name: "SCALE",
                        margin: 2,
                        graduatedTickUnit: 5,  // tick marks at each multiple of 2.5
                        graduatedMax: 100,  // this is actually the default value
                        stretch: go.GraphObject.None  // needed to avoid unnecessary re-measuring!!!
                    },

                    this.$$(go.Shape, {
                        width : 90 ,
                        height : 90 ,
                        name: "SHAPE",
                        geometryString: "M-70.7 70.7 B135 270 0 0 100 100 M0 100",
                        stroke: k,
                        strokeWidth: 4
                    }),
                    // three differently sized tick marks
                    this.$$(go.Shape, {
                        width : 5 ,
                        height : 5 ,
                        geometryString: "M0 0 V10",
                        stroke: k,
                        strokeWidth: 1.5
                    }),
                    this.$$(go.Shape, {
                        width : 5 ,
                        height : 5 ,
                        geometryString: "M0 0 V12",
                        stroke:k,
                        strokeWidth: 2.5,
                        interval: 2
                    }),
                    this.$$(go.Shape, {
                        width : 5 ,
                        height : 5 ,
                        geometryString: "M0 0 V15",
                        stroke: k,
                        strokeWidth: 3.5,
                        interval: 4
                    }),
                    this.$$(go.TextBlock,
                        {
                            //width : 5 ,
                            //height : 5 ,
                            interval: 4,
                            alignmentFocus: go.Spot.Center,
                            font: "bold italic 5pt sans-serif", stroke: "white",
                            segmentOffset: new go.Point(0, 30)
                        })
                ),
                this.$$(go.TextBlock,
                    {
                        //width : 20 ,
                        //height : 20 ,
                        alignment: new go.Spot(0.5, 0.9),
                        stroke: k,
                        font: "bold italic 8pt sans-serif" },
                    new go.Binding("text", "text"),
                    new go.Binding("stroke", "color")),
                this.$$(go.Shape, {
                        width : 80 ,
                        //height : 95 ,
                        fill: t,
                        strokeWidth: 1,
                        geometryString: "F1 M-6 0 L0 -6 100 0 0 6z x M-100 0"
                    },
                    new go.Binding("angle", "value", this._convertValueToAngle)),
                this.$$(go.Shape, "Circle", { width: 2, height: 2, fill: "white" })
            ),
            this._makePort("T", go.Spot.Top, false, true  ),
            this._makePort("L", go.Spot.Left, true, true),
            this._makePort("R", go.Spot.Right, true, true),
            this._makePort("B", go.Spot.Bottom, true, false),
            {
                mouseEnter: function(e, node ) { scada.showSmallPorts(node, true ); },
                mouseLeave: function(e, node ) { scada.showSmallPorts(node, false ); }
            }
        );

    }

    _PipeTemplate(){

        function portFigure(pid) {


            if (pid === null || pid === "") return "XLine";
            if (pid[0] === 'F') return "CircleLine";
            if (pid[0] === 'M') return "PlusLine";
            return "XLine";

        }


        return this.$$(go.Node, "Spot",
            {
                locationObjectName: "SHAPE",
                locationSpot: go.Spot.Center,
                selectionAdorned: true ,
                itemTemplate:
                    this.$$(go.Panel,
                        new go.Binding("portId", "id"),
                        new go.Binding("alignment", "spot", go.Spot.parse),
                        this.$$(go.Shape, "XLine",
                            { width: 6, height: 6, background: "transparent", fill: null, stroke: "gray" },
                            new go.Binding("figure", "id", portFigure),
                            new go.Binding("angle", "angle"))
                    ),
                linkConnected: function(node, link, port) {
                    if (link.category === "") port.visible = false;
                },
                linkDisconnected: function(node, link, port) {
                    if (link.category === "") port.visible = true;
                }
            },
            // new go.Binding("itemArray", "ports"),
            //  new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
            // new go.Binding("angle", "angle").makeTwoWay(),
            // new go.Binding("layerName", "isSelected", function(s) { return s ? "Foreground" : ""; }).ofObject(),
            this.$$(go.Shape,
                {
                    name: "SHAPE",
                    geometryString: "F1 M0 0 L20 0 20 20 0 20 z",
                    fill: "rgba(128, 128, 128, 0.5)"
                },
                new go.Binding("geometryString", "geo"),
                new go.Binding("stroke", "isSelected", function(s) { return s ? "dodgerblue" : "black"; }).ofObject()
            )
        );

    }

    _documentChange($this = this){


        this.canvas.addDiagramListener("Modified", function(e) {


            /***
             cuando se modifica el canvas
             ****/

            try{
                $this._ModChange(e,$this);
            }catch(k){}

            let button =	$(scada.saveBtn);
            var idx = document.title.indexOf("*");

            if($this.canvas.isModified){
                button.prop("disabled" , false)
                if(idx < 0){
                    document.title += "*";
                }
                else document.title = document.title.substr(0, idx);
            }
            else {
                button.prop("disabled" , true)
            }


        });


        this.canvas.addDiagramListener("ExternalObjectsDropped" , function(e ){


            /**FINALIZACION NODAL **/
            $this._ModChange(e,$this);
            //e.parameter.click = function(){ console.log("hello");}
            //console.log(c.skipsUndoManager);
        });

    }

    _ModChange (e , $this ){

        /***
         Cuando se agrega un objeto externo al canvas

         al momento de crear el objeto al canvas debe de considerarse
         un par de cosas , por ejemplo el ID del objeto
         ***/

            //CANVAS
        let c = $this.canvas;

        //SKIPS
        let o = c.skipsUndoManager;




        /**SOLUCION PARA EL SISTEMA DE LINEAS DEL OBJETO **/
        c.links.each(function(l){

            if(l.part.data.sid == null || typeof l.part.data.sid == 'undefined' ){
                l.part.data.sid = $this._CreateOID(l.part.data.type); //CREAMOS UN ID EN LAS LINES
            }

            /* l.click = function(e,node){
             //console.log(node.part.data);
             //let i = $this._CreateOID(node.part.data.type);
             //$this._createModal($this._modalParams(node.part.data));
             };*/

        });
        /***FIN DE LA SOLUCION DE LINEAS DE CANVAS ***/


        /***INICIO PARA LOS DEMAS NODOS ***/

        c.nodes.each(function(l){

            if(l.part.data.sid == null || typeof l.part.data.sid == 'undefined' ){
                l.part.data.sid = $this._CreateOID(l.part.data.type , l.part.data.category ); //CREAMOS UN ID EN LAS LINES
            }


            //console.log(l.part.data );
            //disparador de funciones si tienen
            $.map(l.part.data.properties , (t)=>{


                if(t.name == 'function'){


                    if(typeof t.value == 'function' ){
                        t.value();
                        t.backup = String(t.value);
                    }
                    else if(typeof t.value == 'undefined'){
                        t.backup = t.backup.replace(/_space_/g , '\n');
                        t.value = eval("(" + t.backup + ")");
                        t.value();
                    }

                }

            });


            l.click = function(e,node){
                //console.log(node.part.data);
                //console.log(node.part.position);
                //console.log($("#scada-show").find("button"));

                //$("#scada-show").find("button").position.top = node.part.position.y;

                //let i = $this._CreateOID(node.part.data.type);
                //$this._createModal($this._modalParams(node.part.data));
            };

            l.contextClick = function(e, node ){
                $this._createModal($this._modalParams(node.part.data , node ));
            };


            //evento mouseover
            l.mouseOver = function(e,node){


                $("#scada-show").css({
                    left 		:  (node.part.position.x  + $("#frame").position().top ) ,
                    top  		:  (node.part.position.y  -  $("#frame").height()) - 60 , //node.part.position.y - 25, //(node.part.position.y  -  $("#frame").height()) - 25 ,
                    position 	: "relative",
                    'z-index'   : '100000000',
                    display 	: 'inline',
                    opacity     : 0.75
                });


                //accion scada ver parametros
                $("#scada-show").find("a[id='scada-show-more']").click(function(){

                    $this._createModal($this._modalParams(node.part.data , node ));

                    $("#scada-show").css({
                        display : 'none'
                    });

                });

                //accion eliminar el objeto scada
                $("#scada-show").find("a[id='scada-delete-node']").click(function(){

                    $this._deleteModal(node)

                    $("#scada-show").css({
                        display : 'none'
                    });

                });

            };


            l.mouseLeave = function(e,node){
                /*$("#scada-show").css({
                 display 	: 'none'
                 });*/
            }

        });


    }

    _CreateOID(type = '' , cat = '' , max = 10 , iteration = 0  , r = '' ){

        //por medio de esta funcion recursiva podremos crear un ID unico por objeto
        if(max > iteration){
            return  this._CreateOID(type , cat , max , (iteration+1) , (r + String(Math.floor(Math.random() * 10))));
        }
        else {

            let l = String(type).substr(0 , 1 );

            if(l == null || l == '' || typeof l == 'undefined' )
                if(cat === 'SCADA_A')
                    l = "s";
                else
                    l = "iq";

            return  (l  + "_" + r);
        }

    }

    _createModal( $params = null ){


        //creamos el modal con los parametros necesarios

        let p = "#obj_";
        var s = $("#scada-modal");


        //aca obtenemos el titulo
        s.find(".modal-header")
            .find(".modal-title")
            .text($params.name);


        //creamos el llenado de las propiedades del objeto a llamar
        $( p + "key").val($params.keys );


        //creamos un algoritmo de cambio en el title
        $( p + "name").on("keyup" , function(){
            s.find(".modal-header")
                .find(".modal-title")
                .text($(this).val());
        }).val($params.name);



        //id  ---
        $( p + "id").val($params.id);

        // la categoria
        $( p + "cat")
            .val($params.category)
            .prop("disabled" , true );



        //obtenemos la propiedad de estado activo
        let a = $.map($params.props , (b)=> {
            if(String(b.name) === "active")
                return b.value ;
        });
        a = a[0]; //el valor es un array unidimensional



        //verificamos el estado y lo cambiamos graficamente acorde al resultado
        if(a ==  false  )
            $( p + "active").bootstrapSwitch('state', false, false);
        else
            $( p + "active").bootstrapSwitch('state', true , true );

        //hasta aqui los aspectos basicos

        //posisiones obj_x y obj_y

        $(p + "x" ).val($params.posx);
        $(p + "y" ).val($params.posy);

        //texto generico
        $(p + "text").val($params.text);

        //Descripcion del sistema
        let des = $.map($params.props , (b)=>{
            if(String(b.name) === "description")
                return b.value ;
        })[0];

        $(p + "description").val(des);


        //restricciones de los objetos

        let r = $.map($params.props , (b)=>{
            if(String(b.name) === "restrict")
                return b.value ;
        });

        $(p + "restrict").val(r.join(","));



        //seleccionamos la variable
        $.map($params.props, (b)=>{
            if(String(b.name) === "variable"){
                $("#obj_var option").each(function () {
                    if($(this).val() == b.value ){
                        $(this).prop("selected" , true);
                    }
                })
            }
        });


        //otras propiedades
        //preparando las otras propiedades ...
        let ot = "#_others_frm";  //donde estan
        let fu = "#_func_frm";   //funcion frame

        var op = $(ot);		  //intancia del puntero
        var fo = $(fu);
        op.html("");		 // limpieza
        fo.html("");

        let inpt = $("<input class='' type='text' id='' value='' />");
        let bdy  = $('<div class="form-group"></div>');
        let lbl  = $('<label for="" class="col-sm-2 control-label"></label>');
        let div  = $('<div class="col-sm-9"></div>');

        //analizar los parametros cuyo system sea falso
        $.map($params.props , (c)=>{
            if(c.system == true){
                return false;
            }


            let area = $("<textarea id='_function_code' name='_function_code' rows='25' cols='60' class='form-control' type='text' id='' value='' ></textarea>");
            let inpt = $("<input class='form-control' type='text' id='' value='' />");
            let bdy  = $('<div class="form-group"></div>');
            let lbl  = $('<label for="" class="col-sm-2 control-label"></label>');
            let div  = $('<div class="col-sm-9"></div>');


            lbl.html(c.alias);

            switch(c.control){
                case "select":
                    break;
                case "input":
                case "":

                    switch(typeof c.value){
                        case "string":
                            inpt.val(c.value);
                        case "array" :
                            inpt.val(Array(c.value).join(","));
                        case "object":
                            inpt.val(JSON.stringify(c.value));

                    }
                    inpt.attr("id" , "obj_" + c.name  );
                    div.append(inpt);
                    bdy.append(lbl);
                    bdy.append(div);
                    op.append(bdy);
                    break;
                case "graph":
                    break;
                case "input-code":
                    let st 	= "";
                    let uni = st + c.value ;
                    area.val(uni);
                    div.removeClass("col-sm-9");
                    div.addClass("col-md-12");
                    div.append(area);
                    bdy.append(div);
                    fo.append(bdy);

                    break;
            }




        });

        try{

            this.cm = CodeMirror.fromTextArea(document.getElementById("_function_code"), {
                lineNumbers: false,
                mode: "text/javascript",
                matchBrackets: true ,
                smartIndent: true ,
                //autofocus : true ,
                dragDrop : true
            });
        }catch(kk){}

        s.modal();
    }

    _modalParams( data = null , node = null   ){

        let x = 0 , y = 0;

        if(node !== null){
            x = node.position.x;
            y = node.position.y;
        }

        let _p = {

            text 		: data.text ? data.text : null ,
            name 		: data.name ? data.name : '' ,
            category    : data.category ? data.category : null ,
            figure 		: data.figure ? data.figure : null ,
            func 		: data.func ? data.func : null ,
            id  		: data.sid ? data.sid : null ,
            type 		: data.type ? data.type : null ,
            state 		: data.state ? data.state : null ,
            keys 		: data.keys ? data.keys : null,
            props 		: data.properties ? data.properties : null ,
            posx 		: x ,
            posy 		: y
        };

        return _p;

    }

    _deleteModal(node){

        //hace accion al modal de eliminacion de objeto

        let s = $("#scada-modal-delete");
        let r = s.find(".modal-body").find("p");
        let p = node.part.data;
        let i = '';

        if(p.name == '' || p.name == null  || typeof p.name == 'undefined')
            i = p.text ;
        else
            i = p.name;

        let k = '¿Seguro que desea eliminar ' +  i + ' ?';

        $temp = node.part;
        $("#delete-action-scada").attr("onclick" , "scada._delAction();");


        r.text(k)
        s.modal();

    }

    _delAction(part = $temp){
        this.canvas.remove(part);
    }

     //cuando creas un nuevo nodo y le das click
    _nodeClick(e, node ){
        this._createModal(this._modalParams(node.part.data , node));
    }


    /***
     funcion ciclo A , esta funcion realiza un ciclo por cada 200 milisegundos
     *****/
    _loop(){

        var diagram = this.canvas;
        var $this = this;

        setTimeout(function() {


            //ciclo para los pipe o tuberias , efecto de agua corriendo
            $this._PipeLoop(diagram , $this);

            $this._loop();
        }, 200);

    }


    _FindNodeProperties(props , name ){
        var result = null ;
        $.each(props , function(a,b){
            if(b.name == name )
                result = b.value ;
        });

        return result;
    }


    _PipeLoop(diagram , $this ){

        try{

            var oldskips = diagram.skipsUndoManager;
            diagram.skipsUndoManager = true;

            var count = 0;
            diagram.links.each(function(link) {

                //nuevo segmento de codigo condicion de los objetos

                var d = link.part.data;

                try{

                    let _from 		= link.fromNode.data;
                    let _to   		= link.toNode.data;
                    let isRest		= false ;

                    var _mfrom = {
                        keys  : _from.keys  ,
                        rest: $this._FindNodeProperties(_from.properties , "restrict")
                    };


                    var _mto   = {
                        keys  	: _to.keys  ,
                        rest 	: $this._FindNodeProperties(_to.properties , "restrict")
                    };


                    if(	_mfrom.rest.length 	!== 0
                        && _mto.rest.length !== 0) {


                        for(var i in _mfrom.rest){
                            if(String(_mfrom.rest[i]) == String(_mto.keys ) ){
                                isRest = true ;
                                break;
                            }
                            else if(String(_mfrom.rest[i]) == String(_from.keys )){
                                isRest = true ;
                                break;
                            }
                        }

                        if(!isRest)
                            for(var j in _to.rest){
                                if(String(_mto.rest[j]) == String(_mfrom.keys )){
                                    isRest = true ;
                                    break;
                                }
                                else if(String(_mto.rest[j]) == String(_mto.keys )){
                                    isRest = true ;
                                    break;
                                }
                            }

                        if(isRest ){
                            link.findObject("P_A").stroke  = "#d9534f";
                            link.findObject("P_B").stroke  = "#d9534f";
                            link.findObject("PIPE").stroke  = "#d9534f";
                            //link.findObject("P_C").stroke  = "#FFCC00";
                            return;
                        }

                    }
                }catch(m){ }


                //fin segmento


                var shape = link.findObject("PIPE");
                var off  = 0;


                if(d.active != true ) return false;

                if(!d.rollback){
                    try{
                        off = shape.strokeDashOffset - 2;
                        shape.strokeDashOffset = (off <= 0) ? 20 : off;
                    }
                    catch(k){
                       // console.log("ERROR -> K PIPELOOP ");
                       // console.log(k);
                    }
                }
                else {
                    try{
                        off = shape.strokeDashOffset + 2;
                        shape.strokeDashOffset = (off <= 0) ? 20 : off;
                    }catch(j){
                        console.log("ERROR -> J PIPELOOP ");
                        console.log(j);
                    }
                }

            });

        }
        catch(e){
        }

        diagram.skipsUndoManager = oldskips;
    }

    /****
     controlbar primario en configuracion
     ****/
    _controlBarConf(){

        this.control =   this.$$(go.Palette, this.controlId,
            {
                maxSelectionCount: 1,
                nodeTemplateMap: this.canvas.nodeTemplateMap,
                groupTemplate: this.canvas.groupTemplate,
                layout: this.$$(go.GridLayout)
            });

        return ;


        this.control =  this.$$(go.Palette, this.controlId ,
            {
                maxSelectionCount: 1,
                nodeTemplateMap: this.canvas.nodeTemplateMap,
                groupTemplate: this.canvas.groupTemplate,
                layout: this.$$(go.GridLayout,{ alignment: go.GridLayout.Location }),
                linkTemplate:
                    this.$$(go.Link,
                        {
                            locationSpot: go.Spot.Center,
                            selectionAdornmentTemplate:
                                this.$$(go.Adornment, "Link",
                                    {
                                        locationSpot: go.Spot.Center
                                    },
                                    this.$$(go.Shape,
                                        {
                                            isPanelMain: true,
                                            fill: null,
                                            stroke: "blue",
                                            strokeWidth: 0

                                        }),
                                    this.$$(go.Shape,
                                        {
                                            toArrow: "Standard",
                                            stroke: null
                                        })
                                )
                        },
                        {
                            routing: go.Link.AvoidsNodes,
                            curve: go.Link.JumpOver,
                            corner: 5,
                            toShortLength: 10 //,
                            //click : function(a,b){ console.log("funcion");}
                        },
                        new go.Binding("points"),
                        this.$$(go.Shape,
                            {
                                isPanelMain: true,
                                strokeWidth: 5
                            }),
                        this.$$(go.Shape,
                            {
                                toArrow: "Standard",
                                stroke: null
                            })
                    )
            });




    }


    /****
     controlbar secundario
     se le coloco como pipe porque aca iban a ir una serie de tuberias
     pero se opto mejor con trabajar con una sola tuberia dinamica o linkbar
     ****/
    _controlBarPipe(){

        this.controlPipe =  this.$$(go.Palette, "controls-pipes",
            {
                maxSelectionCount: 1,
                nodeTemplateMap: this.canvas.nodeTemplateMap,
                groupTemplate: this.canvas.groupTemplate,
                layout: this.$$(go.GridLayout),
                linkTemplate:
                    this.$$(go.Link,
                        {
                            locationSpot: go.Spot.Center,
                            selectionAdornmentTemplate:
                                this.$$(go.Adornment, "Link",
                                    {
                                        locationSpot: go.Spot.Center
                                    },
                                    this.$$(go.Shape,
                                        {
                                            isPanelMain: true,
                                            fill: null,
                                            stroke: "blue",
                                            strokeWidth: 0

                                        }),
                                    this.$$(go.Shape,
                                        {
                                            toArrow: "Standard",
                                            stroke: null
                                        })
                                )
                        },
                        {
                            routing: go.Link.AvoidsNodes,
                            curve: go.Link.JumpOver,
                            corner: 5,
                            toShortLength: 4 //,
                            //click : function(a,b){ console.log("funcion");}
                        },
                        new go.Binding("points"),
                        this.$$(go.Shape,
                            {
                                isPanelMain: true,
                                strokeWidth: 3
                            }),
                        this.$$(go.Shape,
                            {
                                toArrow: "Standard",
                                stroke: null
                            })
                    )
            });



    }



    /***
     controlbar es una funcion secundaria de carga de objetos a los respectivos
     sidebars o bars , existen dos tipos de sidebars asi que el controlbar
     debera de llevar dos graph link model
     ****/
    _controlBar(){

        this._controlBarConf();
        this._controlBarPipe();

        //PARA CONTROL BAR ESTAS LINEAS DE CODIGO SON LAS BUENAS AHI XD
        var line = [
            {
                keys : "_pipeline",
                points: new go.List(go.Point).addAll(
                    [	new go.Point(0, 0),
                        new go.Point(30, 0),
                        new go.Point(30, 40),
                        new go.Point(60, 40)
                    ]),
                stroke3 : "blue",
                name3   :"PIPE",
                type : "line",
                width3 : 15,
                stroke4 : "blue",
                width4 : 10,
                active : true  ,
                rollback : false ,
                func : null ,
                sid  : null

            },

            {
                keys : "_cloudline",
                points: new go.List(go.Point).addAll(
                    [	new go.Point(0, 0),
                        new go.Point(0, 0),
                        new go.Point(60, 60),
                        new go.Point(60, 60)
                    ]),
                stroke3 : "yellow",
                name3   :"_connline",
                type : "line",
                width3 : 13,
                stroke4 : "black",
                width4 : 5,
                active : true  ,
                rollback : false ,
                func : null ,
                sid  : null

            }


        ];



        if(this.controlData === null ){
            this.ObjectError("Error al momento de cargar los items u objetos" , "Load error ");
            return;
        }


        this.control.model = new go.GraphLinksModel(
            this.controlData,
            line
        );


        //FIN DE ESAS LINEAS DE CODIGO


        //CREAR EL OVERVIEW
        let overView  =
            this.$$(go.Overview, "overview",
                { observed: this.canvas, maxScale: 0.5 });


        //DARLE VIDA AL OVERVIEW
        overView.box.elt(0).stroke = "dodgerblue";

        //veriricando la data del control 2
        if(this.controlData2 !== null )
            this.controlPipe.model = new go.GraphLinksModel(this.controlData2 , line );

        //FIN DE LAS LINEAS DE LOS PIPES




    }




    /***
     Linktemplate es la plantilla que se usa
     para simular las tuberias en cual recorre el agua
     asi como su efecto tuberia :D
     ****/

    _linkTemplate(){



        this.linkSelectionAdornmentTemplate =
            this.$$(go.Adornment, "Link",
                this.$$(go.Shape,
                    {
                        isPanelMain: true,
                        fill: null,
                        stroke: "deepskyblue",
                        strokeWidth: 0
                    })
            );

        this.canvas.linkTemplate =
            this.$$(go.Link,
                { selectable: true, selectionAdornmentTemplate: this.linkSelectionAdornmentTemplate },
                { relinkableFrom: true, relinkableTo: true, reshapable: true },
                {
                    routing: go.Link.AvoidsNodes,
                    curve: go.Link.JumpGap,
                    corner: 10,
                    reshapable: true,
                    toShortLength: 0
                },


                new go.Binding("points").makeTwoWay(),
                this.$$(go.Shape, { isPanelMain: true, stroke: "white", name : "P_A" , strokeWidth: 10 }),
                this.$$(go.Shape, { isPanelMain: true, stroke: "white", name : "P_B" , strokeWidth: 10 }),
                this.$$(go.Shape,
                    new go.Binding("stroke" , "stroke3"),
                    new go.Binding("name" , "name3"),
                    new go.Binding("strokeWidth" , "width3"),
                    {
                        isPanelMain: true,
                        strokeDashArray: [11, 11]
                    }),
                this.$$(go.Shape,
                    new go.Binding("stroke" , "stroke4"),
                    new go.Binding("strokeWidth" , "width4"),
                    {
                        isPanelMain: true ,
                        name : "P_C" ,
                        fill: "blue"
                    })


            );




    }



    _load() {
        //funcion de carga secundaria despues del constructor
        try {
            this.canvas.model = go.Model.fromJson(this.canvasData);
        }catch(e){
            console.log(e);
        }
        this.loadDiagramProperties();
    }


    loadDiagramProperties(e) {
        //carga las propiedades generales del diagrama
        var pos = this.canvas.model.modelData.position;
        if (pos) this.canvas.initialPosition = go.Point.parse(pos);
    }


    /***
     funcion de rotacion
     ***/
    TopRotatingTool() {
        return go.RotatingTool.call(this);
    }

    /***
     esta funcion convierte un valor en un angulo
     el angulo es de 0 a 270 radianes entonces
     esta funcion se usa para los gauge
     ***/
    _convertValueToAngle(v, shape) {
        var scale = shape.part.findObject("SCALE");
        var p = scale.graduatedPointForValue(v);
        var shape = shape.part.findObject("SHAPE");
        var c = shape.actualBounds.center;
        return c.directionPoint(p);
    }


    /**
     muestra todos los puertos
     **/
    showSmallPorts(node, show) {
        node.ports.each(function(port) {
            if (port.portId !== "") {
                port.fill = show ? "rgba(0,0,0,.3)" : null;
            }
        });
    }


    /***
     Crea el sistema de tuberias por medio de un puerto
     en ellas un to from de la api
     ****/
    _makePort(name, spot, output, input  ) {
        return this.$$(go.Shape, "Circle",
            {
                fill: null,
                stroke: null,
                desiredSize: new go.Size(7, 7),
                alignment: spot,
                alignmentFocus: spot,
                portId: name,
                fromSpot: spot, toSpot: spot,
                fromLinkable: output, toLinkable: input,
                cursor: "pointer"
            });
    }



}


class Scada extends ScadaTools {

    constructor(){
        super();
        this._addConfig;
        this.canvasData     = null;
        this.queue          = [];
    }


    Create(){
        this.init();
        this.events();
    }

    setConfLocale(cnf = null  ){



        if( cnf == null)  {

            this.canvasId 		= "frame";
            this.controlId		= "controls";
            this.saveBtn		= "#save_scada";
            this.imgLocation    = "images/{pattern}.png";
            this.pipeId			= "controls-pipes"
        }


        if(typeof cnf !== 'object' ) return null;

        if( cnf.canvas !== 'undefined'
            || cnf.canvas !== null
            || cnf.canvas !== '')
            this.canvasId = cnf.canvas;

        if( cnf.control !== 'undefined'
            || cnf.control !== null
            || cnf.control !== '')
            this.controlId = cnf.control;

        if( cnf.savebtn !== 'undefined'
            || cnf.savebtn !== null
            || cnf.savebtn !== '')
            this.saveBtn = cnf.savebtn;


        if( cnf.img_location !== 'undefined'
            || cnf.img_location!== null
            || cnf.img_location !== '')
            this.imgLocation = cnf.img_location;


        if(typeof cnf.controlPipe !== 'undefined')
            this.pipeID = cnf.controlPipe;



    }


    events($this = this ){


        //evento click boton para guardar la data
        $($this.saveBtn).click(function(){
            $this.modelData = $this.canvas.model.toJson();
            let name        = $($this._addConfig.name).val();
            let id          = $this._addConfig.id;
            let device      = $this._addConfig.device;
            let func        = $this._addConfig.func;
             project_data.scada.save_scada($this.modelData , name , device , id , func);
        });



        $("#save_modal_data").click(function(){


            console.log("Guardando nueva configuracion");
            let id = $("#obj_id").val();


            $this.canvas.startTransaction();
            $this.canvas.nodes.each(function(node){

                let d = node.part.data;

                if(String(d.sid) !== String(id))
                    return;

               // console.log(d);

                d.keys 		= $("#obj_key").val();
                d.name 		= $("#obj_name").val();

                $this.canvas.model.setDataProperty(node.data, "text", $("#obj_text").val() );

                $.map(d.properties , (a)=>{

                    switch(a.name){

                        case "description":
                            a.value = $("#obj_description").val();
                            break;
                        case "restrict":
                            a.value = $("#obj_restrict").val();
                            break;
                        case "variable":
                            a.value = $("#obj_var").val();
                            break;
                        case "function":
                            let f = $this.cm.getDoc().getValue();
                            a.value 	= eval( '(' + f + ')' );

                            var regex   = new RegExp("\"", "g");
                            var res     = String(f).replace(regex , "'");
                            a.backup	= res;
                            //a.value();
                            break;
                        case "graph":
                            break;
                        default :
                            if(a.system == false ){
                                switch(a.control){
                                    case "input":
                                    case "select":
                                        let m = $("#obj_" + a.name ).val();
                                        try{
                                            a.value = JSON.parse(m);
                                        }
                                        catch(h){
                                            a.value = String(m);
                                        }
                                        break;
                                }
                            }
                            break;


                    }

                });

            });

            $this.canvas.commitTransaction("Iniciando modificacion ...");


            alert("Si se modifico una funcion debera volver a refrescar la pagina \n , para eliminar la funcion vieja y ejecutar el cambio . ");

        });

    }


    addData(data  ){
        this.canvasData = data;
    }

    addConfig( config){
        this._addConfig = config;
    }


    setControls (controls = null , controls2 = null ) {
        this.controlData 		= controls;
        this.controlData2 		= controls2;
    }


    StartTrans($threatName , $this = this  ){

        if(!this.IsTran($threatName)){
           return false;
        }

        this.queue.unshift($threatName);
        $this.canvas.startTransaction();

        return true ;

    }

    CommitTrans($Tname , $this = this ){

        if(this.IsTran($Tname , $this , 'del')){
           return true ;
        }

        return false;
    }

    IsTran (t , $this = this  ,  d = ''){

        if(this.queue.length == 0){
            return true;
        }

        for(let i in this.queue){
            if(t === this.queue[i]){

                if(d !== '' && d== 'del'){
                    return $this.canvas.commitTransaction(this.queue.pop());
                }

                return true ;
            }
        }

        return false;

    }


}
