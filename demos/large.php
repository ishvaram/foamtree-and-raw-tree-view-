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
                    error_reporting(E_ALL);
                    ini_set("display_errors", true);
                    fclose($fp);
}

else
{
    shell_exec("sh clustercase.sh $caseid");
    $conn=pg_connect("host=178.63.22.132 port=5432 dbname=vipin_test user=amc_engineer password=serendio123");
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
?>
  

<!DOCTYPE html>
<html>
  <head>
    <title>FoamTree visualizing very large hierarchies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta property="og:image" content="http://get.carrotsearch.com/foamtree/latest/demos/assets/img/main-thumbnail.jpg"/>
    <meta charset="utf-8" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/common.css" rel="stylesheet" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
  //paste this code under head tag or in a seperate js file.
  // Wait for window load
  $(window).load(function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");;
  });
</script>

    <!-- Styles for the autocomplete input -->
    <style>
     #container {
position: absolute;
top: 0;
left:150px;
right:150px;
bottom: 0;
}
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
      .se-pre-con {
      padding:0 400px;
      background: url(loading.gif) center no-repeat;
      background-size:25%;
      width:25%;
    }

    </style>
  </head>

  <body>
    <!-- Paste this code after body tag -->
  <div class="se-pre-con"></div>
  <!-- Ends -->
    <div id="container">
      <div id="visualization"></div>
    </div>
    <div id="side" style="display:none;">
      <section>
        <div id="datasets"></div>

      </section>

  
      
    </div>

    <!-- Include FoamTree visualization code -->
    <script src="../carrotsearch.foamtree.js"></script>

    <!-- Include the tree model utilities -->
    <script src="../carrotsearch.foamtree.util.treemodel.js"></script>

    <!-- Include Hammer.js for mobile interactions. Not required for desktop-only apps. -->
    <script src="assets/js/hammer.min.js"></script>

    <!-- Utilities, optional -->
    <script src="assets/js/carrotsearch.jsonp.js"></script>
    <script src="assets/js/carrotsearch.template.js"></script>
    <script src="assets/js/jquery-2.0.3.min.js"></script>
    <script src="assets/js/typeahead.js"></script>

    <script>
      window.addEventListener("load", function () {
        // We'll need to track the last group the user zoomed to.
        var lastZoomedTo = undefined;

        // Initialize FoamTree
        var foamtree = new CarrotSearchFoamTree({
          id: "visualization",
          pixelRatio: window.devicePixelRatio || 1,

          // Disable rollout and pullback animations, use simple fading
          rolloutDuration: 0,
          pullbackDuration: 0,
          fadeDuration: 0,

          // Increase the relaxation quality threshold a little for
          // faster processing at the cost of slightly lower layout quality.
          relaxationQualityThreshold: 6,

          // Sometimes, an alternative layout may produce better results.
          // relaxationInitializer: "treemap",

          // This listener processes the input data before display.
          onModelChanging: function (dataObject) {
            CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(dataObject, function (group, index, parent, level) {
              // If no label, use the id as the label
              if (!group.label) {
                group.label = group.id + "";
              }

              if (group.weight) {
                // Take the square root of the weight to flatten-out the
                // distribution of weights. If the range of the original
                // weights is very large, such flattening will improve the
                // layout, but still preserve the relationships between
                // group weight and polygon size.
                // You may also experiment with some other power, such us 0.5.
                group.weight = Math.pow(group.weight, 0.25);
              }
            });
          },

          // Remove restriction on the minimum group diameter, so that
          // we can render as many diagram levels as possible.
          groupMinDiameter: 0,

          // Lower the minimum label font size a bit to show more labels.
          groupLabelMinFontSize: 3,

          // Disable rounded corners, deeply-nested groups
          // will look much better and render faster.
          groupBorderRadius: 0,

          // Lower the parent group opacity, so that lower-level groups show through.
          parentFillOpacity: 0.5,

          // Lower the border radius a bit to fit more groups.
          groupBorderWidth: 2,
          groupInsetWidth: 3,
          groupSelectionOutlineWidth: 1,

          // Always draw group labels, this will make zooming more attractive.
          wireframeLabelDrawing: "always",

          // You can change how many levels of polygons and labels below
          // each topmost closed group FoamTree will draw. Lower values will
          // result in faster rendering, but also less detail "underneath" the closed groups.
          maxGroupLevelsDrawn: 4,
          maxGroupLabelLevelsDrawn: 3,

          // Tune colors slightly
          rainbowStartColor: "hsl(0, 90%, 50%)",
          rainbowEndColor: "hsl(120, 90%, 50%)",
          rainbowSaturationCorrection: 0.7,


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
              FoamTree.expose(group);
              //toZoom1 = e.secondary ? group.parent : group;
            if(!group.children)
            {
              // toZoom = e.secondary ? group.parent : group;
               toZoom1 = group.parent;
                window.open('http://<?php echo $_GET['sourceroot'];?>/client/ClusterDocument?caseid=<?php echo $_GET['caseid'];?>&fname='+toZoom.label+'&sentence='+toZoom1.label);
            }
            } else {
                toZoom = this.get("dataObject");
            }
            // window.open({groups:group,open:e.bottommostOpenGroup})

            this.zoom(toZoom);
            lastZoomedTo = toZoom;
          },
        
           
          // If group's child diagram could not be computed due to insufficient
          // floating point precision, we'll append [+] to its label. The actual
          // application would most likely allow the used to replace the visualization
          // with the contents of such an uninitialized node so that the user
          // can browser further levels of the hierarchy.
          groupLabelDecorator: function (opts, params, vars) {
            if (params.hasChildren && params.browseable === false) 
            {
                vars.labelText += " [+]";
            }
          },

          // Zoom out when Esc is pressed
          onKeyUp: function(event) {
            if (event.keyCode === 27) {
              event.preventDefault();
              foamtree.set("zoomMouseWheelEasing", "squareInOut");
              foamtree.set("zoomMouseWheelDuration", Math.max(2000, lastZoomedTo.level * 25));
              this.zoom(this.get("dataObject")).then(this.reset);
              foamtree.set("zoomMouseWheelDuration", CarrotSearchFoamTree.defaults.zoomMouseWheelDuration);
              foamtree.set("zoomMouseWheelEasing", CarrotSearchFoamTree.defaults.zoomMouseWheelEasing);
              lastZoomedTo = undefined;
            }
          },

          onViewReset: function () {
            lastZoomedTo = undefined;
          }
        });

        // Resize FoamTree on orientation change
        window.addEventListener("orientationchange", foamtree.resize);

        // Resize on window size changes
        window.addEventListener("resize", (function () {
          var timeout;
          return function () {
            window.clearTimeout(timeout);
            timeout = window.setTimeout(foamtree.resize, 300);
          }
        })());

        // Initialize the UI
        initDatasets([
          { url: 'assets/data/tree-of-life.js', label: "Tree of Life, 70k+ groups" },
          { url: 'assets/data/metazoa.js', label: "Metazoa (animals), 100k+ groups" }
        ]);
        initAutocomplete();

        // Zoom to the group when form submitted
        $("#form").submit(function (e) {
          e.preventDefault();
          var query = $("#search").val();
          if ($.trim(query).length > 0) {
            var group = CarrotSearchFoamTree.TreeModel.findFirstByProperty(
              foamtree.get("dataObject"), "label", query);
            if (group) {
              zoomToGroup(group);
            }
          } else {
            zoomToGroup(foamtree.get("dataObject"));
          }
        });

        // Handle clicks on links
        $("body")
          .on("click", "a.dataset",function (e) {
            e.preventDefault();
            loadDataSet(this.href);
          })
          .on("click", "a[href = '#zoom-out']",function (e) {
            e.preventDefault();
            zoomToGroup(foamtree.get("dataObject"));
          })
          .on("click", "a.go", function (e) {
            e.preventDefault();
            var id = this.hash.substring(1);
            var group = CarrotSearchFoamTree.TreeModel.findFirstByProperty(foamtree.get("dataObject"), "id", id);
            if (group) {
              zoomToGroup(group);
            }
          });

        // Load the first data set
        $("a.dataset:eq(0)").trigger("click");


        //
        // Utility functions
        //
        function initDatasets(datasets) {
          var template = Template.make("<a href='<%- url %>' class='dataset'><%- label %></a>");

          $("#datasets").html(datasets.reduce(function (html, ds) {
            html += template(ds);
            return html;
          }, ""));
        }

          function loadDataSet(dataSetUrl) {
          // Initiate loading of the data
          var $loading = $("#loading").show();
          var $ui = $("#ui").hide();

          JSONP.load('assets/data/testinputbackup.js', "modelDataAvailable", function (dataObject) {
          //JSONP.load('assets/data/testinputbackup.js', "modelDataAvailable", function (dataObject) {
            prepareDirectLinks(dataObject, [ "Homo sapiens", "Rotavirus", "Streptococcus" ]);

            $loading.hide();
            $ui.show();
            lastZoomedTo = undefined;

            setTimeout(function () {
              foamtree.set("dataObject", dataObject);
            }, 100);
          });
        }

        function prepareDirectLinks(dataObject, byName) {
          var template = Template.make("<a class='go' href='#<%- id %>'><%- label %></a>");
          var templateWithLevel = Template.make("<a class='go' href='#<%- id %>'><%- label %> (level:&nbsp;<%- level %>)</a>");
          var templateWithChildren = Template.make("<a class='go' href='#<%- id %>'><%- label %> (children:&nbsp;<%- children %>)</a>");

          var count = 0, numLeafGroups = 0, numNonLeafGroups = 0, maxChildren = 0;
          CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(dataObject, function (group, index, parent, level) {
            if (group.id === undefined) {
              group.id = count;
            }
            group.parent = parent;
            group.level = level;
            group.children = group.groups ? group.groups.length : 0;

            if (maxChildren < group.children) {
              maxChildren = group.children;
            }
            count++;
            if (group.children > 0) {
              numNonLeafGroups++;
            } else {
              numLeafGroups++;
            }
          });

          var html = "";

          // Named groups
          html += "<div>Groups by name: " +
            byName.reduce(function (html, name) {
            var group = CarrotSearchFoamTree.TreeModel.findFirstByProperty(dataObject, "label", name);
            if (group) {
              html += template(group);
            }
            return html;
          }, "") + "</div>";

          // Deepest nesting level
          var maxLevel = 0, maxLevelGroups = [];
          CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(dataObject, function (group, index, parent, level) {
            if (maxLevel < level) {
              maxLevel = level;
            }
          });
          var maxLevelTmp = maxLevel;
          for (var i = 0; i < 4; i++) {
            CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(dataObject, function (group, index, parent, level) {
              if (group.label && level === maxLevelTmp) {
                maxLevelGroups.push(group);
                return false;
              }
            });
            maxLevelTmp -= Math.ceil(maxLevelTmp / 20);
          }

          html += "<div>Deeply nested groups: " + maxLevelGroups.reduce(function (html, group) {
            html += templateWithLevel(group);
            return html;
          }, "") + "</div>";

          // Many children
          var maxChildrenGroups = [];
          CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(dataObject, function (group, index, parent, level) {
            if (group.label) {
              maxChildrenGroups.push(group);
            }
          });
          maxChildrenGroups.sort(function (a, b) { return b.children - a.children });

          html += "<div>Groups with many children: " + maxChildrenGroups.slice(0, 5).reduce(function (html, group) {
            html += templateWithChildren(group);
            return html;
          }, "") + "</div>";

          $("#direct").html(html);

          var statsTemplate = Template.make("<dl class='dl-horizontal dl-wide'>" +
            "<dt>Total number groups:</dt><dd><%- numGroups %></dd>" +
            "<dt>Non-leaf groups:</dt><dd><%- numNonLeafGroups %></dd>" +
            "<dt>Leaf groups:</dt><dd><%- numLeafGroups %></dd>" +
            "<dt>Deepest nesting level:</dt><dd><%- maxLevel %></dd>" +
            "<dt>Max children in one group:</dt><dd><%- maxChildren %></dd>" +
            "</dl>");

          $("#stats").html(statsTemplate({
            numGroups: count,
            numNonLeafGroups: numNonLeafGroups,
            numLeafGroups: numLeafGroups,
            maxLevel: maxLevel,
            maxChildren: maxChildren
          }));
        }

        function zoomToGroup(target) {
          if (target === lastZoomedTo) {
            var str = target;
            var result = str.link("http://www.w3schools.com"); 
            return result;
          }

          if (!lastZoomedTo) {
            lastZoomedTo = foamtree.get("dataObject");
          }

          // Find the lowest parent ancestor between target and lastZoomedTo
          var common = lowestCommonAncestor(lastZoomedTo, target);

          // We'll need to open all parents of the node we're zooming to.
          // Very deeply-nested nodes will only be initialized if their parents
          // get open. If we don't open the parents, the polygon corresponding
          // to the target group would not exist.
          var targetParents = allParents(target);
          targetParents.pop();

          foamtree.open(targetParents).then(function() {
            // It may happen that our target site is so deeply-nested, FoamTree could
            // not compute a diagram for it due to insufficient numeric precision.
            // In this case, we'll zoom to the closest computed parent. The label decorator
            // will draw a [+] annotation to indicate that the site has children whose diagrams
            // could not be computed.
            while (target.parent && !foamtree.get("state", target.parent).browseable) {
              target = target.parent;
            }

            // First, zoom out to the lowest common ancestor.
            // Temporarily set the zoom duration based on the difference in levels we need to travel.
            foamtree.set("zoomMouseWheelEasing", "squareInOut");
            foamtree.set("zoomMouseWheelDuration", Math.max(2000, (lastZoomedTo.level - common.level) * 50));
            foamtree.zoom(common).then(function() {
              // Open all parents of the target group.
              foamtree.open({ groups: target, open: false });
              foamtree.set("zoomMouseWheelDuration", Math.max(2000, (target.level - common.level) * 100));

              // Zoom to the target group.
              foamtree.zoom(target);
              foamtree.set("zoomMouseWheelDuration", CarrotSearchFoamTree.defaults.zoomMouseWheelDuration);
              foamtree.set("zoomMouseWheelEasing", CarrotSearchFoamTree.defaults.zoomMouseWheelEasing);
            });
            lastZoomedTo = target;
          });
        }

        function lowestCommonAncestor(groupA, groupB) {
          var parentsA = allParents(groupA);
          var parentsB = allParents(groupB);

          var max = Math.min(parentsA.length, parentsB.length);
          for (var i = 0; i < max; i++) {
            if (parentsA[i] !== parentsB[i]) {
              // We assume the two nodes do have one common parent
              return parentsA[i - 1];
            }
          }

          return parentsA[max - 1];
        }

        function allParents(group) {
          var parents = [];
          var parent = group;
          while (parent) {
            parents.push(parent);
            parent = parent.parent;
          }
          parents.reverse();
          return parents;
        }

        function initAutocomplete() {
          var templates = {
            suggestion: Template.make("<div><%- group.label %><small>id: <%- group.id %></small><small>level: <%- group.level %></small></div>")
          };

          $('#search').typeahead({
              hint: true,
              highlight: true,
              minLength: 1
            },
            {
              name: 'labels',
              displayKey: 'value',
              source: foamTreeSource("label"),
              templates: templates
            },
            {
              name: 'ids',
              displayKey: 'value',
              source: foamTreeSource("id"),
              templates: templates
            }
          );

          // Queries FoamTree model for the purposes of the autocomplete input.
          function foamTreeSource(prop) {
            return function findMatches(q, cb) {
              var matches = [];
              q = q.toLowerCase();

              CarrotSearchFoamTree.TreeModel.eachDescendantAndSelf(foamtree.get("dataObject"), function (group) {
                var val = (group[prop] + "");
                var index = val.toLocaleLowerCase().indexOf(q);
                if (index >= 0) {
                  matches.push({ value: val, index: index, group: group });
                }
              });

              matches.sort(function (a, b) {
                if (a.index != b.index) {
                  return a.index - b.index;
                } else {
                  if (a.group.label < b.group.label) {
                     return -1;
                  } else if (a.group.label > b.group.label) {
                    return 1;
                  } else {
                    return 0;
                  }
                }
              });

              cb(matches.slice(0, 20));
            };
          }
        }
      });
    </script>
  </body>
</html>
