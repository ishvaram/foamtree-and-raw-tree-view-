//
// Explicitly define global functions from Mocha
//
var describe = global.describe,
    it = global.it,
    beforeEach = global.beforeEach,
    afterEach = global.afterEach,
    chai = window.chai,
    expect = chai.expect;
chai.Assertion.includeStack = true;

//
// Common language helpers
//
var eachProperty = function(obj, iterator, context) {
  for (var key in obj) {
    if (obj.hasOwnProperty(key)) {
      if (iterator.call(context, obj[key], key, obj) === false) {
        return;
      }
    }
  }
};

var each = function(obj, iterator, context) {
  if (obj == null) {
    return;
  }
  if (obj.forEach) {
    obj.forEach(iterator, context);
  } else {
    eachProperty(obj, iterator, context);
  }
};

var extend = function(obj) {
  each(Array.prototype.slice.call(arguments, 1), function (source) {
    if (source) {
      for (var prop in source) {
        if (source.hasOwnProperty(prop)) {
          obj[prop] = source[prop];
        }
      }
    }
  });
  return obj;
};

//
// Conditional suites
//
var describeAssuming = function(assumption, name, suite) {
  if (typeof assumption === 'function') {
    if (assumption()) {
      describe(name, suite);
    }
  } else if (assumption) {
    describe(name, suite);
  }
};

// Some common assumptions
var unobfuscated = typeof window.FoamTreeImpl !== "undefined";
var memoryStatusAvailable = window.performance && window.performance.memory;

var licensedBinaries = CarrotSearchFoamTree.version().brandingAllowed;
var demoBinaries = !licensedBinaries;


//
// A generic matrix test helper, see the test for usage examples.
//
function cube(assertions) {
  var configurations = Array.prototype.slice.call(arguments, 1);

  // Put the assertion name as the top-level description for a more readable output.
  each(assertions, function(assertion, name) {
    describe(name, (function() {
      return function() {
        runAssertionsAfterLastConfiguration(assertion, configurations);
      };
    })(name));
  });

  function runAssertionsAfterLastConfiguration(assertion, configurations) {
    var configuration = configurations[0];
    var rest = configurations.slice(1);

    each(configuration, function(conf, key) {
      if (rest.length > 0) {
        describe(key, (function() {
          return function() {
            beforeEach(conf);
            runAssertionsAfterLastConfiguration(assertion, rest);
          }
        })(key));
      } else {
        // Execute the last configuration right before the assertion.
        it(key, (function() {
          return function() {
            conf.call(this);
            assertion.call(this);
          };
        })(key));
      }
    });
  }
}

//
// FoamTree test setup. We make the basic variables global for simplicity.
//

// The element in which to embed FoamTree
var element = document.getElementById("visualization");

// FoamTree options
var options = { };

// FoamTree instance
var foamtree;

// Some reasonable option defaults for tests
var defaultOptions = {
  element: element,

  relaxationVisible: false,
  relaxationMaxDuration: Number.MAX_VALUE,

  groupGrowingDuration: 0,

  rolloutDuration: 0,
  rolloutPolygonDrag: 0,
  rolloutLabelDrag: 0,
  pullbackDuration: 0,
  fadeDuration: 0
};

// Initializes a FoamTree test suite, adds basic before/after actions
function foamtreeTest(inner) {
  // Assert the element exists and reset options
  beforeEach(function() {
    expect(element).not.to.be.undefined;

    element.setAttribute("class", "");

    options = extend({}, defaultOptions);
  });

  afterEach(function() {
    if (foamtree) {
      foamtree.dispose();
      foamtree = null;
    }
    options = null;
    if (unobfuscated) {
      LIMITED_DEMO = true;
    }
  });

  return inner;
}


function verifyWhenRolloutComplete(before, checks) {
  return function (done) {
    before();
    options.onRolloutComplete = function() {
      checks(done);
    };
    newFoamTree();
  };
}

function withInitialViewRendered(action, initialOptions) {
  var clock = sinon.useFakeTimers();

  if (typeof initialOptions !== "undefined") {
    extend(options, initialOptions);
  }

  var originalOptions = extend({}, options);
  options.relaxationVisible = false;
  options.onRolloutComplete = sinon.spy();
  newFoamTree();

  // Make sure the initial view is rendered
  clock.tick(17);
  expect(foamtree.get("onRolloutComplete")[0]).to.have.been.calledOnce;

  // Restore the original options
  extend(options, originalOptions);
  action.call(this, clock);
}

function shouldNeverCall(callbackName) {
  return sinon.test(function() {
    var clock = sinon.useFakeTimers();
    options[callbackName] = sinon.spy();

    newFoamTree();

    clock.tick(totalRelaxationAndRolloutTime());

    expect(options[callbackName]).not.to.have.been.called;
  });
}

function shouldCallOnce(callbackName) {
  return sinon.test(function() {
    var clock = sinon.useFakeTimers();
    options[callbackName] = sinon.spy();

    newFoamTree();

    clock.tick(totalRelaxationAndRolloutTime());

    expect(options[callbackName]).to.have.been.calledOnce;
    expect(options[callbackName]).to.have.been.calledOn(foamtree);
  });
}

function totalRelaxationAndRolloutTime() {
  var maxHierarchyLevel = maxLevel(options.dataObject);

  // rolloutDuration is only a base value, when the data has multiple
  // levels, we need to multiply the base value by some level dependant factor.
  var rolloutTicks = options.rolloutDuration > 0 ? options.rolloutDuration * Math.pow(1.5, maxHierarchyLevel - 1) : 17;

  if (options.rolloutDuration === 0) {
    rolloutTicks += options.fadeDuration + 35 /* fading is delayed by 2 frames to avoid hickups */;
  }

  // Some reasonable time in which relaxation should complete.
  // We set the default relaxationMaxTime to infinity, so should
  // the relaxation fall in an infinite loop, we'd detect it anyway.
  var relaxationTicks = options.relaxationVisible ? 30000 : 0;
  return rolloutTicks + relaxationTicks;
}

function maxLevel(dataObject) {
  return max(dataObject);

  function max(dataObject) {
    if (!dataObject) {
      return 0;
    }
    var groups = dataObject.groups;
    if (groups && groups.length > 0) {
      var level = 0;
      for (var i = groups.length - 1; i >= 0; i--) {
        level = Math.max(level, max(groups[i]));
      }
      return 1 + level;
    } else {
      return 0;
    }
  }
}

function newFoamTree() {
  foamtree = new CarrotSearchFoamTree(options);
  expect(foamtree).not.to.be.undefined;
  return foamtree;
}

function configuredWith(keys) {
  var dimensions = { };

  for (var i = 0; i < keys.length; i++) {
    var key = keys[i];
    expect(Data.all).to.have.property(key);

    var dataset = Data.all[key];
    dimensions["on " + dataset.label + " dataset"] = (function (dataset) {
      return function() {
        options.dataObject = dataset.dataObject;
      };
    })(dataset);
  }

  return dimensions;
}

function getCanvasPixel(x, y, final) {
  var canvas = document.querySelectorAll("#visualization > canvas")[final ? 1 : 0];
  return  canvas.getContext("2d").getImageData(
    Math.floor(x),
    Math.floor(y),
    1, 1).data;
}

//
// Data for tests
//
var Data = (function() {
  // Synthetic data sets
  var synthetic = {};

  synthetic["oneGroup"] = { label: "1 group",
    dataObject: { groups: [ { label: "Group", weight: 1 } ] }
  };

  synthetic["oneLevel"] = { label: "1 level",
    dataObject: { groups: [ { label: "Group 1", weight: 1 }, { label: "Group 2", weight: 3 } ] }
  };

  synthetic["twoLevels"] = { label: "2 levels",
    dataObject: {
      groups: [
        {
          label: "Group 1", weight: 1, id: "1",
          groups: [
            { label: "Group 1.1", weight: 1, id: "1.1" },
            { label: "Group 1.2", weight: 2 }
          ]
        },
        {
          label: "Group 2", weight: 3,
          groups: [
            { label: "Group 2.1", weight: 1 },
            { label: "Group 2.2", weight: 2 }
          ]
        }
      ]
    }
  };

  synthetic["threeLevels"] = { label: "3 levels",
    dataObject: {
      groups: [
        {
          label: "Group 1", weight: 1,
          groups: [
            { label: "Group 1.1", weight: 1, groups: [
              { label: "Group 1.1.1", weight: 1 }, { label: "Group 1.1.2", weight: 1 } ] },
            { label: "Group 1.2", weight: 1, groups: [
              { label: "Group 1.2.1", weight: 1 }, { label: "Group 1.2.2", weight: 1 } ] }
          ]
        },
        {
          label: "Group 2", weight: 1,
          groups: [
            { label: "Group 2.1", weight: 1, groups: [
              { label: "Group 2.1.1", weight: 1 }, { label: "Group 2.1.2", weight: 1 } ] },
            { label: "Group 2.2", weight: 1, groups: [
              { label: "Group 2.2.1", weight: 1 }, { label: "Group 2.2.2", weight: 1 } ] }
          ]
        }
      ]
    }
  };

  // Real-world data sets
  var realWorld = exampleData;
  var all = extend({}, synthetic, realWorld);

  return {
    synthetic: synthetic,
    realWorld: realWorld,
    all: all,

    syntheticDatasets: Object.keys(synthetic),
    realWorldDatasets: Object.keys(realWorld),
    allDatasets : Object.keys(all)
  };
})();
