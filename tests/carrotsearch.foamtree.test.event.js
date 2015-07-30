describe("FoamTree event system", foamtreeTest(function() {
  // All data sets
  var synthetic = Data.synthetic;


  var action;
  cube(
    [ "onGroupOpenOrCloseChanging", "groupOpenOrCloseChanged",
      "onGroupExposureChanging", "onGroupExposureChanged" ]
      .reduce(function (object, event) {
        object["should not call " + event] = sinon.test(function() {
          withInitialViewRendered(function(clock) {
            var listener = sinon.spy(function listener() {});
            foamtree.set(event, listener);
            action(clock);
            expect(listener).not.to.have.been.called;
          }, { dataObject: synthetic.twoLevels.dataObject })
        });
        return object;
      }, {}),
    {
      "when closed parent's child group gets exposed programmatically": function() {
        action = function(clock) {
          foamtree.expose("1.1");
          clock.tick(foamtree.get("exposeDuration") * 1.5);
        };
      },
      "when exposed child's parent group gets closed programmatically": function() {
        action = function(clock) {
          foamtree.expose("1.1");
          clock.tick(foamtree.get("exposeDuration") * 1.5);
          foamtree.open({ groups: "1", open: false });
          clock.tick(foamtree.get("openCloseDuration") * 1.5);
        };
      },
      "when closed group gets open programmatically": function() {
        action = function(clock) {
          foamtree.open("1");
          clock.tick(foamtree.get("openCloseDuration") * 1.5);
        };
      },
      "when open group gets closed programmatically": function() {
        action = function(clock) {
          foamtree.open("1");
          clock.tick(foamtree.get("openCloseDuration") * 1.5);
          foamtree.open({ groups: "1", open: false });
          clock.tick(foamtree.get("openCloseDuration") * 1.5);
        };
      },
      "when closed group gets exposed programmatically": function() {
        action = function(clock) {
          foamtree.expose("1");
          clock.tick(foamtree.get("exposeDuration") * 1.5);
        };
      },
      "when closed group gets unexposed programmatically": function() {
        action = function(clock) {
          foamtree.expose("1");
          clock.tick(foamtree.get("exposeDuration") * 1.5);
          foamtree.expose({ groups: "1", exposed: false });
          clock.tick(foamtree.get("exposeDuration") * 1.5);
        };
      },
      "on view reset": function() {
        action = function(clock) {
          foamtree.expose("1.1");
          clock.tick(foamtree.get("exposeDuration") * 1.5);
          foamtree.reset();
          clock.tick(foamtree.get("zoomMouseWheelDuration") * 2);
        };
      }
    }
  );

  //
  // Matrix event registration tests
  //
  var registrationMethod, eventOptionName;

  var addListenerByMethod = {
    byMethod: function(optionName, listener) {
      foamtree.on(optionToType(optionName), listener);
    },
    byOption: function(optionName, listener) {
      foamtree.set(optionName, foamtree.get(optionName).concat(listener));
    }
  };

  var removeListenerByMethod = {
    byMethod: function(optionName, listener) {
      foamtree.off(optionToType(optionName), listener);
    },
    byOption: function(optionName, listener) {
      foamtree.set(optionName, foamtree.get(optionName).filter(function (l) {
        return l !== listener;
      }));
    }
  };

  var triggerByOptionName = {
    onModelChanging: function(clock) {
      // We set {} instead of null/undefined, so that repeated setting
      // of null/undefined is not ignored (value not changed).
      foamtree.set("dataObject", {});
      clock.tick(17);
    },
    onModelChanged: function(clock) {
      // We set {} instead of null/undefined, so that repeated setting
      // of null/undefined is not ignored (value not changed).
      foamtree.set("dataObject", {});
      clock.tick(17);
    },
    onRedraw: function(clock) {
      trigger("click", 0);
      clock.tick(17);
    },
    onRolloutStart: function(clock) {
      foamtree.set("dataObject", { groups: [ { label: "Group" } ]});
      clock.tick(17);
    },
    onRolloutComplete: function(clock) {
      foamtree.set("dataObject", { groups: [ { label: "Group" } ]});
      clock.tick(17);
    },
    onRelaxationStep: function(clock) {
      foamtree.set("relaxationVisible", true);
      foamtree.set("dataObject", { groups: [ { label: "Group" } ]});
      clock.tick(17);
    },
    onViewReset: function(clock) {
      // Trigger a three-finger pinch for the reset
      foamtree.trigger("transform", { x: 0, y: 0, touches: 3, scale: 0.5 });
      foamtree.trigger("transformend", { });
      clock.tick(17);
    },
    onGroupHover: (function() {
      // Alternate between hovered sites on each call
      var seq = 0;
      return function(clock) {
        var groups = foamtree.get("dataObject").groups;
        var geom = foamtree.get("geometry", groups[seq % groups.length]);
        foamtree.trigger("hover", { x: geom.polygonCenterX, y: geom.polygonCenterY });
        clock.tick(17);
        seq++;
      }
    })(),
    onGroupOpenOrCloseChanging: function (clock) {
      trigger("hold", 0);
      clock.tick(17);
      foamtree.reset();
      clock.tick(17);
    },
    onGroupOpenOrCloseChanged: function (clock) {
      trigger("hold", 0);
      clock.tick(17);
      foamtree.reset();
      clock.tick(17);
    },
    onGroupExposureChanging: function (clock) {
      trigger("doubleclick", 0);
      clock.tick(17);
      foamtree.reset();
      clock.tick(17);
    },
    onGroupExposureChanged: function (clock) {
      trigger("doubleclick", 0);
      clock.tick(17);
      foamtree.reset();
      clock.tick(17);
    },
    onGroupSelectionChanged: function (clock) {
      trigger("click", 0);
      clock.tick(17);
    },
    onGroupSelectionChanging: function (clock) {
      trigger("click", 0);
      clock.tick(17);
    },
    onGroupClick: function (clock) {
      trigger("click", 0);
    },
    onGroupDoubleClick: function (clock) {
      trigger("doubleclick", 0);
      clock.tick(17);
    },
    onGroupHold: function (clock) {
      trigger("hold", 0);
      clock.tick(17);
    },
    onGroupMouseWheel: function (clock) {
      trigger("mousewheel", 0);
      clock.tick(17);
    },
    onGroupMouseDown: function (clock) {
      trigger("mousedown", 0);
      clock.tick(17);
    },
    onGroupDragStart: function (clock) {
      trigger("dragstart", 0);
      clock.tick(17);
    },
    onGroupDrag: function (clock) {
      trigger("drag", 0);
      clock.tick(17);
    },
    onGroupDragEnd: function (clock) {
      trigger("dragend", 0);
      clock.tick(17);
    },
    onGroupTransformStart: function (clock) {
      trigger("transformstart", 0);
      clock.tick(17);
    },
    onGroupTransform: function (clock) {
      trigger("transform", 0);
      clock.tick(17);
    },
    onGroupTransformEnd: function (clock) {
      trigger("transformend", 0);
      clock.tick(17);
    }
  };

  var initialOptions = {
    dataObject: synthetic.twoLevels.dataObject,
    zoomMouseWheelDuration: 0,
    openCloseDuration: 0,
    exposeDuration: 0
  };

  function trigger(action, group, event) {
    var geom = foamtree.get("geometry", foamtree.get("dataObject").groups[group]);
    foamtree.trigger(action, extend(event || {}, { x: geom.polygonCenterX, y: geom.polygonCenterY }));
  }

  cube(
    {
      "should call listener after registered": sinon.test(function() {
        withInitialViewRendered(function(clock) {
          var listener = sinon.spy(function listener() {});
          addListenerByMethod[registrationMethod](eventOptionName, listener);

          triggerByOptionName[eventOptionName](clock);
          expect(listener).to.have.been.calledOnce;
          listener.reset();

          triggerByOptionName[eventOptionName](clock);
          expect(listener).to.have.been.calledOnce;
        }, initialOptions)
      }),

      "should keep previous listeners after a new one is registered": sinon.test(function() {
        withInitialViewRendered(function(clock) {
          var listener1 = sinon.spy(function listener1() {});
          addListenerByMethod[registrationMethod](eventOptionName, listener1);

          triggerByOptionName[eventOptionName](clock);
          expect(listener1).to.have.been.calledOnce;
          listener1.reset();

          var listener2 = sinon.spy(function listener2() {});
          addListenerByMethod[registrationMethod](eventOptionName, listener2);

          triggerByOptionName[eventOptionName](clock);
          expect(listener1).to.have.been.calledOnce;
          expect(listener2).to.have.been.calledOnce;
        }, initialOptions)
      }),

      "should not call listener after removed": sinon.test(function() {
        withInitialViewRendered(function(clock) {
          var listener = sinon.spy(function listener() {});
          addListenerByMethod[registrationMethod](eventOptionName, listener);

          triggerByOptionName[eventOptionName](clock);
          expect(listener).to.have.been.calledOnce;
          listener.reset();

          removeListenerByMethod[registrationMethod](eventOptionName, listener);

          triggerByOptionName[eventOptionName](clock);
          expect(listener).not.to.have.been.called;
        }, initialOptions)
      }),

      "should keep unaffected listeners after one is removed": sinon.test(function() {
        withInitialViewRendered(function(clock) {
          var listener1 = sinon.spy(function listener1() {});
          var listener2 = sinon.spy(function listener2() {});
          addListenerByMethod[registrationMethod](eventOptionName, listener1);
          addListenerByMethod[registrationMethod](eventOptionName, listener2);

          triggerByOptionName[eventOptionName](clock);
          expect(listener1).to.have.been.calledOnce;
          expect(listener2).to.have.been.calledOnce;
          listener1.reset();
          listener2.reset();

          removeListenerByMethod[registrationMethod](eventOptionName, listener1);
          triggerByOptionName[eventOptionName](clock);
          expect(listener2).to.have.been.calledOnce;
        }, initialOptions)
      })
    },
    {
      "with on()/off() registration": function () {
        registrationMethod = "byMethod";
      },
      "with set() registration": function () {
        registrationMethod = "byOption";
      }
    },

    Object.keys(triggerByOptionName).reduce(function (spec, optionName) {
      spec["for " + optionName + " event"] = function() {
        eventOptionName = optionName;
      };
      return spec;
    }, {})
  );


  function optionToType(optionName) {
    return optionName.charAt(2).toLowerCase() + optionName.slice(3);
  }
}));