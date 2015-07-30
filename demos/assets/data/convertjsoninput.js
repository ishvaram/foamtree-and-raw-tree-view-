var movies = [
    {"label": "Cluster1", "label": "English", "label": "2012"},
    {"label": "Cluster2", "label": "French", "label": "2011"},
    {"label": "Cluster3", "label": "German", "label": "2013"},
    {"label": "Cluster1", "label": "German", "label": "2010"},
    {"label": "Cluster2", "label": "hindi", "label": "2011"},
    {"label": "Cluster2", "label": "spanish", "label": "2012"},
    {"label": "Cluster1", "label": "Tamil", "label": "2013"}
];
function groupElements(input, label) {
    var output = {};
    var final = [];
    if (input instanceof Array) {
        input.forEach(function (data) {
            var fieldlabel = data[label]
            var obj = output[fieldlabel];
            if (obj == undefined) {
                obj = {};
                obj.groups = [];
                obj[label] = fieldlabel;
                output[fieldlabel] = obj;
            }
            delete data[label];
            obj.groups.push(data);
        })
    }
    var keys = Object.keys(output);
    if (keys != undefined && keys != null) {
        keys.forEach(function (key) {
            final.push(output[key]);
        })
    }
    return final;
}
var output = groupElements(movies, "label");
modelDataAvailable(output);
console.log(JSON.stringify(output));