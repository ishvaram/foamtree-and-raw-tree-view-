<?php  
error_reporting(E_ALL);
ini_set("display_errors", true);
$caseid=$_GET['caseid'];
$sourceroot=$_GET['sourceroot'];
if($sourceroot=='trial.assistmycase.com')
{
    shell_exec("sh clustertrial.sh $caseid");
    $conn=pg_connect("host=178.63.22.132 port=5432 dbname=trial_prod user=amc_engineer password=serendio123");
    if($conn){
       $sq=pg_query("select case_cluster from case_ where id=$caseid");
       $cluster=pg_fetch_result($sq, 0, 'case_cluster');
    }
    $json='modelDataAvailable('.trim($cluster);
    $json=$json.');';
    $fp=fopen('assets/data/testinputbackup.js','w');
    fputs($fp, $json);
    fclose($fp);
}
else if($sourceroot=='app.extrosive.com')
{
    shell_exec("sh clustertrial.sh $caseid");
    $conn=pg_connect("host=178.63.22.132 port=5432 dbname=trial_prod user=amc_engineer password=serendio123");
    if($conn){
       $sq=pg_query("select case_cluster from case_ where id=$caseid");
       $cluster=pg_fetch_result($sq, 0, 'case_cluster');
    }
    $json='modelDataAvailable('.trim($cluster);
    $json=$json.');';
    $fp=fopen('assets/data/testinputbackup.js','w');
    fputs($fp, $json);
    fclose($fp);
}
else if($sourceroot=='app.detavue.com')
{
        //shell_exec("sh clustertrial.sh $caseid");
            $conn=pg_connect("host=178.63.22.132 port=5432 dbname=trial_prod user=amc_engineer password=serendio123");
            if($conn){
                       $sq=pg_query("select case_cluster from case_ where id=$caseid");
                              $cluster=pg_fetch_result($sq, 0, 'case_cluster');
                           }
                $json=$cluster;
                    $fp=fopen('assets/data/test.js','w');
                    fputs($fp, $json);
                        fclose($fp);
}


else
{
    // shell_exec("sh clustercase.sh $caseid");
    $conn=pg_connect("host=178.63.22.132 port=5432 dbname=vipin_test user=amc_engineer password=serendio123");
    if($conn){
       $sq=pg_query("select case_cluster from case_ where id=$caseid");
       $cluster=pg_fetch_result($sq, 0, 'case_cluster');
    }
    $json=$cluster;
    $fp=fopen('assets/data/test.js','w');
    fputs($fp, $json);
    fclose($fp);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>FoamTree with externally-triggered interaction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta property="og:image" content="http://get.carrotsearch.com/foamtree/latest/demos/assets/img/main-thumbnail.jpg"/>

    <meta charset="utf-8" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/common.css" rel="stylesheet" />

       <style>
      .twitter-typeahead {
        display: block !important;
      }
      .tt-hint {
        display: block;
        padding: 6px 12px;
        line-height: 1.428571429;
        color: #999;
        vertical-align: middle;
        background-color: #ffffff;
        border: 1px solid #cccccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
              box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
              transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
      }
      .tt-dropdown-menu {
        width: 100%;
        min-width: 160px;
        margin-top: 2px;
        padding: 5px 0;
        background-color: #ffffff;
        border: 1px solid #cccccc;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
              box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
        background-clip: padding-box;
        max-height: 350px;
        overflow-y: auto;
      }
      .tt-suggestion {
        display: block;
        padding: 3px 20px;
      }
      .tt-suggestion > div > small {
        font-size: 100%;
        color: #888;
        margin-left: 6px;
        padding-left: 6px;
        border-left: 1px solid #eee;
      }
      .tt-suggestion:hover {
        background-color: #f5f5f5;
      }
      #direct > div {
        margin-bottom: 10px;
      }
      #direct > div > a {
        padding-right: 5px;
        margin-right: 5px;
        border-right: 1px solid #ddd;
      }
      #direct > div > a:last-of-type {
        border: none;
      }
      #datasets > a {
        display: block;
      }
      .dl-horizontal {
        margin-top: 0;
      }
      .dl-horizontal > dd {
        margin-left: 155px;
        font-weight: bold;
      }
      .dl-horizontal > dt {
        width: 150px;
        text-align: left;
        font-weight: normal;
      }
      section {
        margin-top: 25px;
      }
    </style>

  </head>

  <body>
    <div id="container"><div id="visualization"></div></div>
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
      window.addEventListener("load", function () {
        // Get the element FoamTree will be embedded in
        var element = document.getElementById("visualization");
       

   
        // Initialize FoamTree
         var foamtree = new CarrotSearchFoamTree({
          id: "visualization",
          pixelRatio: window.devicePixelRatio || 1,
          onKeyUp: function(event) {
            console.log(event.keyCode)
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
              foamtree.expose(group);
            // if(!group.children)
            // {
            //   // toZoom = e.secondary ? group.parent : group;
            //   // alert(group)
            //   this.open({ groups: group, open: e.secondary });
            //   window.open(toZoom.label)
            // }
            //alert(toZoom.label);
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
              //toZoom1 = e.secondary ? group.parent : group;
            if(!group.groups)
            {
              // toZoom = e.secondary ? group.parent : group;
               toZoom1 = group;
               //console.log("hello");
               //console.log("hello");
               //console.log(toZoom1);
               console.log('http://<?php echo $_GET['sourceroot'];?>/client/ClusterDocument?caseid=<?php echo $_GET['caseid'];?>&fname=');
               window.open('http://<?php echo $_GET['sourceroot'];?>/client/ClusterDocument?caseid=<?php echo $_GET['caseid'];?>&fname='+toZoom.label+'&sentence='+toZoom1.label);
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

        // For each Hammer.js event, make the appropriate foamtree.trigger() call.
        // hammer.on("tap",            createFoamTreeEventTrigger("click"));
        // hammer.on("doubletap",      createFoamTreeEventTrigger("doubleclick"));
        // hammer.on("hold",           createFoamTreeEventTrigger("hold"));
        // hammer.on("touch",          createFoamTreeEventTrigger("mousedown"));
        // hammer.on("dragstart",      createFoamTreeEventTrigger("dragstart"));
        // hammer.on("drag",           createFoamTreeEventTrigger("drag"));
        // hammer.on("dragend",        createFoamTreeEventTrigger("dragend"));
        // hammer.on("transformstart", createFoamTreeEventTrigger("transformstart"));
        // hammer.on("transform",      createFoamTreeEventTrigger("transform"));
        // hammer.on("transformend",   createFoamTreeEventTrigger("transformend"));
        // hammer.on("onKeyUp",   createFoamTreeEventTrigger("onKeyUp"))
        // Resize FoamTree on orientation change
        window.addEventListener("orientationchange", foamtree.resize);


        // Resize on window size changes
        window.addEventListener("resize", (function() {
          var timeout;
          return function() {
            window.clearTimeout(timeout);
            timeout = window.setTimeout(foamtree.resize, 300);
          }
        })());
      
        // function convert(clusters) {
        //       return clusters.map(function(cluster) {
        //         return {
        //           id:     cluster.id,
        //           label:  cluster.documents.fields.title,
        //           weight: cluster.attributes && cluster.attributes["other-topics"] ? 0 : cluster.size,
        //           groups: cluster.clusters ? convert(cluster.clusters) : [],
        //         }
        //       });
        //     };


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
        // function convert(documents) {
        //       return  documents.map(function(doc) {
        //         return {
        //           id:     doc.id,
        //           label:  doc.phrases.join(", "),
        //           weight: doc.attributes &&doc.attributes["other-topics"] ? 0 : cluster.size,
        //           groups: cluster.clusters ? convert(cluster.clusters) : [],
        //         }
        //       });
        //     };
    // Clear the previous model.
          // foamtree.set("dataObject", null);

                  // var dataObject = {
                  //   groups: _.reduce(carrot2Json.clusters,
                  //     function reducer(arr, cluster) 
                  //     {
                  //       arr.push({
                  //         id: cluster.id,
                  //         weight: cluster.attributes && cluster.attributes["other-topics"] ? 0 : cluster.size,
                  //         label: cluster.phrases[0],
                  //         groups: _.reduce(cluster.clusters || [], reducer, []),
                  //         cluster: cluster
                  //       });
                  //       return arr;
                  //     }, []);
                  //  };
    // Load Carrot2 JSON clusters.
              $.ajax({
                url: "assets/data/test.js",
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
                }
              });


//               $.ajax({
//                 url: "../demos/assets/data/carrot2/test.js",
//                 dataType: "JSON",
//                 success:function(data)
//                 {
//                   // console.log(JSON.stringify(convert1(data.documents)));
//                   // dict = [];
//                   // for(dat in convert1(data.documents))
//                   // {
//                   //  dict.push({
//                   //   dat.id : dat.label
//                   //  }) 
//                   // }

//                   // console.log(JSON.stringify(myKeyValuePairs));
//                   // console.log(JSON.stringify(data.documents));
//                   var dict = []; 
//                   for(i=0;i<data.documents.length;i++)
//                   {
//                     dict.push({
//                     key:   data.documents[i].id,
//                     value: data.documents[i].title,
//                     });
//                   }
//                    // console.log(JSON.stringify(dict));
//                    var result = {};
//                    for (var i=0; i<dict.length; i++) 
//                    {
//                    result[dict[i].key] = dict[i].value;
//                   }
//                   console.log(JSON.stringify(result));
//                   var finalresult={};
//                   for(var i=0;i<data.clusters.length;i++)
//                   {
//                     console.log(data.clusters[i]);
//                     if(data.clusters[i].phrases.length == 0)
//                     {
//                       var title = [];
//                       for(var j=0;j<data.clusters[i].documents.length;j++)
//                       {
//                           title.push(result[data.clusters[i].documents[j]]);
//                       }
//                       data.clusters[i].phrases = title;
//                       //data.clusters[i] = finalresult
                  
//                     } 
//                   }
//                    console.log(JSON.stringify(data.clusters));
//                   //  foamtree.set({
//                   //   dataObject: { 
//                   //     groups : convert(data.clusters)
//                   //   }
//                   // });
//                 }
// });










              // var data = readTextFile("../demos/assets/data/carrot2/test.js");
               
          //     var dict = []; // create an empty array
          //     convert1(documents);
          //     dict.push({
          //     key:   data.documents,
          //     value: "the value"
          // });
              // $.ajax({
              //   url: "../demos/assets/data/carrot2/test.js",
              //   dataType: "JSON",
              //   success: function(data) {
              //     foamtree.set({
              //       dataObject: {
                     
              //         groups : convert(data.documents)
                
              //       }
              //     });
              //   }
              // });
              // console.log(dataObject);


        // Load some example data set
        // JSONP.load(
        //   foamtree.set("../demos/assets/data/carrot2/madpilot.js", dataObject))

        // Returns a function that calls foamtree.trigger() with
        // the requested event type and event details created based
        // on the Hammer.js event object.
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
  </body>
</html>
