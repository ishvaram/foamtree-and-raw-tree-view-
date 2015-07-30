<html>
<script type="text/javascript">
var movies = [
    {"name": "Ice Age 3", "language": "English", "year": "2012"},
    {"name": "Ice Age 3", "language": "French", "year": "2011"},
    {"name": "Ice Age 2", "language": "German", "year": "2013"}
];

function groupElements(input, name) {
    var output = {};
    var final = [];
    if (input instanceof Array) {
        input.forEach(function (data) {
            var fieldName = data[name]
            var obj = output[fieldName];
            if (obj == undefined) {
                obj = {};
                obj.details = [];
                obj[name] = fieldName;
                output[fieldName] = obj;
            }
            delete data[name];
            obj.details.push(data);
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

var output = groupElements(movies, "name");
console.log(JSON.stringify(output));
</script>
</html>