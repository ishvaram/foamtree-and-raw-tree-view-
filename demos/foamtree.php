<html>
  <head>
  <style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
  position: fixed;
  left: 0px;
  top: 0px;  
  height: 100%;
  z-index: 9999;
  opacity: 0.9;
  padding:20px 400px;
  background: url(loader.gif) center no-repeat;
  width:25%;
}



::-webkit-scrollbar { width: 10px; } 
::-webkit-scrollbar-track { -webkit-border-radius: 10px; background-color:rgba(0,0,0,0.1); border-radius: 10px; } 
::-webkit-scrollbar-thumb { -webkit-border-radius: 10px; border-radius: 10px; background:rgba(0,0,0,0.1); -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1); } 
</style>

    <title>Detavue - Document Cluster</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta property="og:image" content="http://get.carrotsearch.com/foamtree/latest/demos/assets/img/main-thumbnail.jpg"/>
    <meta charset="utf-8" />    
    <link href="assets/css/common.css" rel="stylesheet" />      
  </head>
  <body>
    <div id="container" style="width: 50%; height: 655px;"><div id="visualization"></div></div>
      <div class="se-pre-con"></div>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script src="../carrotsearch.foamtree.js"></script>
<!-- Include the tree model utilities -->
<script src="../carrotsearch.foamtree.util.treemodel.js"></script>
<script src="assets/js/hammer.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="../carrotsearch.foamtree.js"></script>
<script src="assets/js/carrotsearch.jsonp.js"></script>
<script src="assets/js/carrotsearch.template.js"></script>
<script src="assets/js/jquery-2.0.3.min.js"></script>
<script src="assets/js/typeahead.js"></script>
<script src="assets/js/hammer.min.js"></script>
<script>
  //paste this code under head tag or in a seperate js file.
  // Wait for window load
  $(window).load(function() {
    // Animate loader off screen
    $(".se-pre-con").delay(700).fadeOut("slow");
  });
</script>
<script>
      window.addEventListener("load", function () {
        // Get the element FoamTree will be embedded in
        var element = document.getElementById("visualization");
       

   
        // Initialize FoamTree
         var foamtree = new CarrotSearchFoamTree({
          id: "visualization",
          pixelRatio: window.devicePixelRatio || 1,
          onKeyUp: function(event) {
            //console.log(event.keyCode)
            if (event.keyCode === 27) {
              event.preventDefault();
              foamtree.set("zoomMouseWheelEasing", "squareInOut");
              this.zoom(this.get("dataObject")).then(this.reset);
              foamtree.set("zoomMouseWheelDuration", CarrotSearchFoamTree.defaults.zoomMouseWheelDuration);
              foamtree.set("zoomMouseWheelEasing", CarrotSearchFoamTree.defaults.zoomMouseWheelEasing);
             
            }
          },
            onGroupClick: function (e) {
            e.preventDefault();          


            var group = e.secondary ? e.bottommostOpenGroup : e.topmostClosedGroup;            
            var toZoom,tozoom1;
            if (group) {
              // Open on left-click, close on right-click
              //group.exposed();
              this.open({ groups: group, open: !e.secondary });
              toZoom = e.secondary ? group.parent : group;
              foamtree.exposegroups            // if(!group.children)
            // {
            //   // toZoom = e.secondary ? group.parent : group;
            //   // alert(group)
            //   this.open({ groups: group, open: e.secondary });
            //   window.open(toZoom.label)
            // }
            //alert(toZoom.label);
              var node = e.secondary ? group.parent : group;               
              loadDocuments(node);                        
            // $(".tree-node").removeClass("tree-hit tree-expanded"); 
            $(".tree-node").removeClass("tree-node-selected");
            $(".tree-collapsed_"+node.id+"").trigger( "click" ).addClass("tree-expanded");            
            $(".tree-click_"+node.id+"").addClass("tree-node-selected"); 
            $(".tree-collapsed_"+node.id+"").removeClass("tree-expanded");
            } else {
              group.fading();
              toZoom = this.get("dataObject");
            }
            // window.open({groups:group,open:e.bottommostOpenGroup})
            this.zoom(toZoom);
            lastZoomedTo = toZoom;
          },


          // Disable "expose" on double click, it will not work well on very deeply nested groups.
          // Instead, open the group and zoom into it.
          onGroupDoubleClick: function (e) {
            e.preventDefault();
            var group = e.secondary ? e.bottommostOpenGroup : e.topmostClosedGroup;
            var toZoom,toZoom1;
            if (group) {
              // Open on left-click, close on right-click
              this.open({ groups: group, open: !e.secondary });
              toZoom = e.secondary ? group.parent : group;
              foamtree.expose(group);

              // console.log(this.get("dataObject"));
              var node = e.secondary ? group.parent : group;               
              loadDocuments(node);        
              //toZoom1 = e.secondary ? group.parent : group;
            if(!group.groups)
            {
              // toZoom = e.secondary ? group.parent : group;
               toZoom1 = group;
               //console.log("hello");
               //console.log("hello");
               //console.log(toZoom1);
              // console.log('http://<?php echo $_GET['sourceroot'];?>/client/ClusterDocument?caseid=<?php echo $_GET['caseid'];?>&fname=');
               //window.open('http://<?php echo $_GET['sourceroot'];?>/client/ClusterDocument?caseid=<?php echo $_GET['caseid'];?>&fname='+toZoom.label+'&sentence='+toZoom1.label);
            }
            } else {
                toZoom = this.get("dataObject");
            }
            // window.open({groups:group,open:e.bottommostOpenGroup})

            this.zoom(toZoom);
            lastZoomedTo = toZoom;
          }
         
        });


        // Bind Hammer to the visualization element
        var hammer = Hammer(element);

        
       
        window.addEventListener("orientationchange", foamtree.resize);


        // Resize on window size changes
        window.addEventListener("resize", (function() {
          var timeout;
          return function() {
            window.clearTimeout(timeout);
            timeout = window.setTimeout(foamtree.resize, 300);
          }
        })());
      
        


        function convert(clusters, docs_map) {
            //console.log(JSON.stringify(clusters));
            return clusters.map(function(cluster) {
                        // alert(cluster.documents)
                        return {
                            id: cluster.id,
                            label: cluster.phrases.join(", "),
                            // doc_list : cluster.documents,
                            weight: cluster.attributes && cluster.attributes["other-topics"] ? 0 : cluster.size,
                            groups: cluster.clusters ? convert(cluster.clusters, docs_map) : cluster.documents.map(function(doc) {
                                    return { label: docs_map[doc], weight:3 }
                                })
                        }
                    });
          }


            function getDocumentNames(cluster) {
              // TODO 
            }

              function convert1(documents) {
              return documents.map(function(doc) {
                return {
                  id:     doc.id,
                  label:  doc.title,
                  // groups: doc.documents ? convert(doc.documents) : [],
                  // id:label,
                }
              });
            };

            function readTextFile(file)
            {
                var rawFile = new XMLHttpRequest();
                rawFile.open("GET", file, false);
                rawFile.onreadystatechange = function ()
                {
                    if(rawFile.readyState === 4)
                    {
                        if(rawFile.status === 200 || rawFile.status == 0)
                        {
                            var allText = rawFile.responseText;
                            alert(allText);
                        }
                    }
                }
                rawFile.send(null);
            }

            function getDocumentMap(documents) {
              var result = {};
              for (doc of documents) {
                result[doc["id"]] = doc["title"];
              }
              return result
            }
        
    // Clear the previous model.
          
    // Load Carrot2 JSON clusters.
              $.ajax({
                url: "test.json",
                dataType: "JSON",
                success: function(data) {
                  // console.log(JSON.stringify(data));
                  docs_map = getDocumentMap(data.documents);                  
                  // console.log(JSON.stringify(docs_map));
                  foamtree.set({
                    dataObject: { 
                      groups : convert(data.clusters, docs_map)
                    }
                  });
                  //console.log(foamtree.get("hierarchy", "1"));
                }
              });

        function createFoamTreeEventTrigger(type) {
          return function (hammerEvent) {
            var gesture = hammerEvent["gesture"];
            var center = gesture["center"];

            // Heads up! Hammer calls the properties pageX/Y, but they actually contain clientX/Y.
            var eventDetails = pageToElementRelative(element, center.pageX, center.pageY);
            eventDetails.scale = gesture["scale"];
            eventDetails.secondary = gesture.touches.length > 1;
            eventDetails.touches = gesture.touches.length;
            gesture.preventDefault();
            foamtree.trigger(type, eventDetails);
          };

          // FoamTree requires element-relative coordinates.
          // Here is a simple conversion from page-relative ones.
          function pageToElementRelative(element, clientX, clientY) {
            var target = {};
            var rect = element.getBoundingClientRect();
            target.x = clientX - rect["left"];
            target.y = clientY - rect["top"];
            return target;
          }
        }
      });
 
</script>



                <!-- Raw cluster Part -->

  <!-- rawcluster library files  -->
  <link rel="stylesheet" type="text/css" href="css/easyui.css">
  <link rel="stylesheet" type="text/css" href="css/icon.css">
  <link rel="stylesheet" type="text/css" href="css/demo.css">
  <script type="text/javascript"zz src="js/jquery.min.js"></script>  
  <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
  <!-- foamtree library files -->
  <!-- Foamtree visualize script -->
  <script>      
    // code to loadDocuments for treeview <-- code starts --> 

  function loadDocuments(node){
    $("#file-display").empty();
  
  var child_id = node.id;
  //console.log(child_id);

  $.ajax({
      method: "POST",
      url: "test.json",     
      dataType:'json',
      //data: { label:node.label},
            success : function (data) {    
            var document_array = [];           
            $.each(data.clusters, function(i,parent_clusters){ 
        if(parent_clusters.clusters!=undefined){
              //Parent
              if(child_id==parent_clusters.id){
                $.each(parent_clusters.clusters, function(j,child_clusters){
                    document_array[j] = child_clusters.documents; 
                  });
              } else {
                  $.each(parent_clusters.clusters, function(j,child_clusters){
                    if(child_clusters.id==child_id){      
                      document_array[0] = child_clusters.documents;       
                    }           
                  });           
                } 
              } else {
                if(child_id==parent_clusters.id){
                  document_array[0] = parent_clusters.documents;
                } 
              }                                       
            });            
            var document_html = '';
            if(document_array.length>0){
              $.each(document_array, function( index, doc_ids ) {
                $.each(doc_ids, function( index1, doc_id ) {
            $.each(data.documents, function(i,doc){ 
              if(doc.id==doc_id){ 
                document_html += '<p style="padding-top: 8px;padding-bottom: 5px;border-radius: 7px;text-align: justify;padding-right: 10px;padding-left: 5px;">'+'<a style="color:#ccc;">'+'['+doc_id+'] '+'</a>'+data.documents[i].snippet+'</p>';      
                      //console.log(data.documents[doc_id]);
                    }
            });
          });   
        });
            }
            $("#file-display").html(document_html);            
            }                            
        });
  } 
  

      function convert(clusters) 
      {
            return clusters.map(function(cluster){
            return{
              id:     cluster.id,
              label:  cluster.phrases.join(", "),
              size: cluster.attributes && cluster.attributes["other-topics"] ? 0 : cluster.size,
              groups: cluster.clusters ? convert(cluster.clusters) : []           
            }           
         });
      }
  

        


       $(document).ready(function(){
        $.ajax({
            url: "test.json",
            dataType: "json",
            success: function(data) {
                var clusters = convert(data.clusters);  
                var rawdata = JSON.stringify(clusters);
                writeJSONFile(rawdata);           
            }     
        });


      function writeJSONFile(rawdata){      
        $.ajax({
              url: "convert.php",
          dataType: "json",
          data: {rawdata:rawdata},
          type: 'POST',
          success: function(response){          
          }
            }); 
      }
     });
   // tree code ends
  
</script>
<style type="text/css">
  body 
  {   
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif !important;
    font-size: 14px !important;
    line-height: 1.428571429;
    color: #333;
    background-color: #fff;
  }

  .contentcl
  {   
    text-align: center;
    margin-left: 240px;
    margin-top: -630px;
    font-size: 1.4em;
    background-color: white;
    color: #000;         
    width: 25%;
  }
  /*h3
  {
    font-size: 18px !important;
    text-transform: uppercase;
    text-align: center;
    padding-top: 27px;
      padding-bottom: 23px;
      background-color: #3b5998;
      color: #ccc;
  }*/


  .tree-node-selected 
  {
    background: #3b5998 !important; 
    width: 270px; 
    border-radius: 2px;
    color: #fff;           
  }


</style>  

</head>
<body>
<div style="margin-left: 640px;">
  <div class="easyui-panel" style="width:235px;height:630px;">  
    <ul class="easyui-tree" data-options="url:'cluster.json',method:'get',loadFilter:myLoadFilter"></ul>
  </div>  
  <div class="contentcl">       
    <div id="file-display" style="height:630px;overflow-y:auto;  width: 410px;"></div>
  </div>
</div>
  <script>
    function myLoadFilter(data, parent){
      var state = $.data(this, 'tree');
        function setData(){
          var serno = 1;
            var todo = [];
            for(var i=0; i<data.length; i++){
                todo.push(data[i]);
            }
            while(todo.length){
                var node = todo.shift();
                if (node.id == undefined){
                  node.id = '_node_' + (serno++);
                }
                if (node.groups){
                    node.state = 'closed';
                    node.children1 = node.groups;
                    if(node.children1.length == 0)
                    {
                      node.state = 'open';                      
                    }                                     
                    node.groups = undefined;
                    todo = todo.concat(node.children1);
                    //console.log(JSON.stringify(todo));
                }
            }
            state.tdata = data;
        }
        function find(id){
          var data = state.tdata;
          // console.log(JSON.stringify(state.tdata));
          var cc = [data];
          while(cc.length){
            var c = cc.shift();
            for(var i=0; i<c.length; i++){
              var node = c[i];
              if (node.id == id){
                return node;
              } else if (node.children1){
                // cc.push(node.children1); 
              }
            }
          }
          return null;
        }
        setData();
        var t = $(this);
        var opts = t.tree('options');
        opts.onBeforeExpand = function(node){
          var n = find(node.id);
          if (n.groups && n.groups.length){return}
          if (n.children1){
            var filter = opts.loadFilter;
            opts.loadFilter = function(data){return data;};
            t.tree('append',{
              parent:node.target,
              data:n.children1
            });
            opts.loadFilter = filter;
            n.groups = n.children1;
          }
        };
        //console.log(JSON.stringify(data));
      return data;
    } 
  </script>

  </body>
</html>
