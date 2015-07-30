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
    $json=$cluster;
    $fp=fopen('assets/data/test.js','w');
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
    $json=$cluster;
    $fp=fopen('assets/data/test.js','w');
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
    shell_exec("sh clustercase.sh $caseid");
    print_r(shell_exec("sh clustercase.sh $caseid"));
    $conn=pg_connect("host=178.63.22.132 port=5432 dbname=vipin_test user=amc_engineer password=serendio123");
    if($conn){
       $sq=pg_query("select case_cluster from case_ where id=$caseid");
       $cluster=pg_fetch_result($sq, 0, 'case_cluster');
    }
    $json=$cluster;
    //    echo $json;
    $fp=fopen('assets/data/test.js','w');
    fputs($fp, $json);
    fclose($fp);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="assets/css/reset.css" />
    <link rel="stylesheet" href="assets/css/dejavu/dejavu_sanscondensed.css" type="text/css" charset="utf-8" />
    <style type="text/css"> 
      html, body, #visualization {
        height: 100%;
        font-family: 'dejavu_sanscondensed', Arial, sans-serif;
      }
    </style>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="assets/js/webfont-1.4.7.js"></script>
    <script src="../carrotsearch.circles.js"></script>
    <script src="../carrotsearch.circles.asserts.js"></script>
    <script src="assets/js/carrotsearch.examples.onresizehook.js"></script>
    <script src="assets/js/carrotsearch.examples.viewport.js"></script>
  </head>
  <body>
    <div id="visualization"></div>
    <script>
      window.onload = function() {
        // Use the defaults for all parameters.
        var circles = new CarrotSearchCircles({
          id: "visualization",
          captureMouseEvents: false,
          pixelRatio: Math.min(1.5, window.devicePixelRatio || 1),
          
          groupFontFamily: "dejavu_sanscondensed, Arial, sans-serif",
          groupMinFontSize: 20,
          groupMaxFontSize: 30,
          groupLinePadding: 10,   // J protrudes outside the line height, so add extra padding.

          titleBar: "inscribed",
          titleBarTextColor: "#444",
          titleBarFontFamily: "dejavu_sanscondensed, Arial, sans-serif",
          titleBarMinFontSize: 10,
          titleBarMaxFontSize: 30,
          

          groupLabelDecorator: function(opts, props, vars) {
            vars.labelText = vars.labelText.toUpperCase();
          },

          dataObject: null
        });

        installResizeHandlerFor(circles, 0);
function convert(clusters) {
  return clusters.map(function(cluster) {
    return {
      id:     cluster.id,
      label:  cluster.phrases.join(", "),
      weight: cluster.attributes && cluster.attributes["other-topics"] ? 0 : cluster.size,
      groups: cluster.clusters ? convert(cluster.clusters) : []
    }
  });
};
 
$.ajax({
  url: "assets/data/test.js",
  dataType: "json",
  success: function(data) {
    new CarrotSearchCircles({
      id: "visualization",
      dataObject: {
        groups: convert(data.clusters)
      }
    });
  }
});
        
        WebFont.load({
          active: function() {
            circles.set({
              dataObject: {
                groups: convert(data.clusters)
              }
            });
          },
  
          custom: {
            families: ['dejavu_sanscondensed']
          }
        });        
      };
    </script>
  </body>
</html>
