function convert(arr) {
    var convertedArray = [];
    var movies = [
  {"name":"Ice Age 3", "language":"English", "year":"2012"},
  {"name":"Ice Age 3", "language":"French", "year":"2011"},
  {"name":"Ice Age 3", "language":"German", "year":"2013"}
];
    $(arr).each(function () {
        var found = false;
        for (var i = 0; i < convertedArray.length; i++) {
            if (convertedArray[i].name === this.name) {
                found = true;
                convertedArray[i].groups.push({
                    "language": this.language,
                    "year": this.year
                });
                break;
            }
        }
        if (!found) {
            convertedArray.push({
                "label": this.name,
                "groups": [{
                    "language": this.language,
                    "year": this.year
                }]
            });
        }
    });
    console.log(convertedArray);
    return convertedArray;
}