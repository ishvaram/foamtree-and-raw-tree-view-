// modelDataAvailable({"groups":[
//   {"label":"Cluster 1", "weight":18, "groups":[
//     {"label":"case_06_326", "weight":4, "id":"1"},
//     {"label":"case_06_83", "weight":3, "id":"2"},
//     {"label":"case_07_2117", "weight":3, "id":"3"},
//     {"label":"case_08_557", "weight":2, "id":"4"},
//     {"label":"case_08_582", "weight":2, "id":"5"},
//     {"label":"case_08_594", "weight":2, "id":"6"},
//     {"label":"case_09_662", "weight":2, "id":"7"}
//   ], "id":"0"},
//   {"label":"Cluster 2", "weight":11, "groups":[
//     {"label":"case_06_106", "weight":3, "id":"12"},
//     {"label":"case_06_164", "weight":3, "id":"13"},
//     {"label":"case_06_32", "weight":2, "id":"14"},
//     {"label":"case_06_90", "weight":3, "id":"15"},
//     {"label":"case_07_2097", "weight":3, "id":"16"},
//     {"label":"case_08_564", "weight":2, "id":"17"},
//     {"label":"case_08_575", "weight":0, "id":"18"},
//     {"label":"case_08_580", "weight":3, "id":"20"},
//     {"label":"case_08_589", "weight":2, "id":"21"},
//     {"label":"case_08_592", "weight":2, "id":"22"}
//   ], "id":"11"},
//   {"label":"Cluster 3", "weight":7, "groups":[
//     {"label":"case_06_135", "weight":2, "id":"26"},
//     {"label":"case_06_218", "weight":2, "id":"27"},
//     {"label":"case_06_219", "weight":2, "id":"28"},
//     {"label":"case_06_245", "weight":2, "id":"29"},
//     {"label":"case_06_26", "weight":0, "id":"30"},
//     {"label":"case_06_305", "weight":2, "id":"32"},
//     {"label":"case_06_351", "weight":2, "id":"33"},
//     {"label":"case_06_386", "weight":0, "id":"34"},
//     {"label":"case_06_434", "weight":0, "id":"35"},
//     {"label":"case_06_68", "weight":0, "id":"36"},
//     {"label":"case_06_6", "weight":0, "id":"37"}
//   ], "id":"25"},
//   {"label":"Cluster 4", "weight":8, "groups":[
//     {"label":"case_06_1112", "weight":2, "id":"41"},
//     {"label":"case_06_134", "weight":2, "id":"42"},
//     {"label":"case_08_551", "weight":0, "id":"43"},
//     {"label":"case_08_561", "weight":2, "id":"45"},
//     {"label":"case_08_562", "weight":2, "id":"46"},
//     {"label":"case_08_563", "weight":2, "id":"47"},
//   ], "id":"40"},
//   {"label":"Cluster 5", "weight":9, "groups":[
//     {"label":"case_06_220", "weight":2, "id":"45"},
//     {"label":"case_06_40", "weight":2, "id":"46"},
//     {"label":"case_06_42", "weight":2, "id":"47"},
//     {"label":"case_08_556", "weight":0, "id":"48"},
//     {"label":"case_08_570", "weight":2, "id":"50"},
//     {"label":"case_08_581", "weight":2, "id":"51"},
//     {"label":"case_08_588", "weight":2, "id":"52"}
//   ], "id":"44"},
// ]});
var dat = [{
        "Doc_id": "06_134.txt",
        "cluster_id": "1"
    },{
        "Doc_id": "06_134.txt",
        "cluster_id": "1"
    },{
        "Doc_id": "06_134.txt",
        "cluster_id": "1"
    }];
var data = [
    {
        "Doc_id": "06_106.txt",
        "cluster_id": "2",
        "groups":dat
    },
    {
        "Doc_id": "06_1112.txt",
        "cluster_id": "4",
        "groups":dat
    },
    {
        "Doc_id": "06_134.txt",
        "cluster_id": "4",
        "groups":dat
    },
    {
        "Doc_id": "06_135.txt",
        "cluster_id": "3",
        "groups":dat
    },
    {
        "Doc_id": "08_568.txt",
        "cluster_id": "3"
    },
    {
        "Doc_id": "08_569.txt",
        "cluster_id": "3"
    },
    {
        "Doc_id": "08_570.txt",
        "cluster_id": "5",
        "groups":dat
    },
    {
        "Doc_id": "08_572.txt",
        "cluster_id": "3"
    },
    {
        "Doc_id": "08_573.txt",
        "cluster_id": "3"
    },
    {
        "Doc_id": "08_574.txt",
        "cluster_id": "3"
    },
    {
        "Doc_id": "08_575.txt",
        "cluster_id": "2"
    },
    {
        "Doc_id": "08_577.txt",
        "cluster_id": "3"
    }
];

function outer_cluster(ocdata){
var data2 = [];
var json1 = [];
// var json12 = [];
// var json13 = [];
// var json14 = [];
var json2 = [];
var checked3 = 0;
var checked4 = 0;
var checked2 = 0;
var checked5 = 0;
var groupedData = [];
for(var j=0; j<ocdata.length; j++)
{

    if(ocdata[j].cluster_id == 2 && checked2 == 0)
    {
        for(var i = 0;i<ocdata.length;i++)
        {
            var idData = data[i].cluster_id
            if(idData==2)
            {
                data2.push({"label":ocdata[i].Doc_id,"weight":2})
            } 
        }

        json1.push({
            "label":"cluster2",
            "weight":8,
            "groups":data2
        });
        checked2 = 1;
        
        
    }
    else
    if(ocdata[j].cluster_id == 3 && checked3 == 0)
    {
       
       var groupData = [];
        for(var i = 0;i<ocdata.length;i++)
        {
            var idData = data[i].cluster_id
            if(idData==3)
            {
                data2.push({"label":ocdata[i].Doc_id,"weight":2})
            } 
        }

        json1.push({
            "label":"cluster3",
            "weight":8,
            "groups":data2
        });
     //    if(ocdata[j].groups)
     //    {
     //     json2.push({
     //        "label":"Inside Cluster3",
     //        "weight":8,
     //        "groups":json1
     //    });
     // }
        checked3 = 1;
        //data3 = [];
     
    }
    else
    if(ocdata[j].cluster_id == 4 && checked4 == 0)
    {
        for(var i = 0;i<ocdata.length;i++)
        {
            var idData = data[i].cluster_id
            if(idData==4)
            {
                data2.push({"label":ocdata[i].Doc_id,"weight":2})
            } 
        }
     
        json1.push({
            "label":"cluster4",
            "weight":8,
            "groups":data2
        });
     //    if(ocdata[j].groups)
     //    {
     //     json2.push({
     //        "label":"Inside Cluster4",
     //        "weight":8,
     //        "groups":json1
     //    });
     // }
        checked4 = 1;
        //data4 = [];
       
    }
    else
   if(ocdata[j].cluster_id == 5 && checked5 == 0)
    {   
        for(var i = 0;i<ocdata.length;i++)
        {
            var idData = data[i].cluster_id
            if(idData==5)
            {
                data2.push({"label":ocdata[i].Doc_id,"weight":2})
            } 
        }

        
        json1.push({
            "label":"cluster5",
            "weight":8,
            "groups":data2
        });
     //     if(ocdata[j].groups)
     //    {
     //     json2.push({
     //        "label":"Inside Cluster5",
     //        "weight":8,
     //        "groups":json1
     //    });
        
     // }
        
        checked5 = 1;
        // data5 = [];
       
    }
    if(ocdata[j].groups && ocdata[j].cluster_id == 2)
        {
         json2.push({
            "label":"Inside Cluster2",
            "weight":8,
            "groups":json1
        });
     }
     if(ocdata[j].groups && ocdata[j].cluster_id == 3)
        {
         json2.push({
            "label":"Inside Cluster3",
            "weight":8,
            "groups":json1
        });
     }
     if(ocdata[j].groups && ocdata[j].cluster_id == 4)
        {
         json2.push({
            "label":"Inside Cluster4",
            "weight":8,
            "groups":json1
        });
     }
     if(ocdata[j].groups && ocdata[j].cluster_id == 5)
        {
         json2.push({
            "label":"Inside Cluster5",
            "weight":8,
            "groups":json1
        });
     }
   
    data2 = [];
}
// groupedData.push(json1);
// var groups = [];
// groups.push({"groups":groupedData});

console.log(JSON.stringify(json2));
return json2

}
modelDataAvailable({"groups":outer_cluster(data)});