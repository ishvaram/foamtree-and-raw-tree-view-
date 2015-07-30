describe("FoamTree", foamtreeTest(function () {

  // All data sets
  var synthetic = Data.synthetic;
  var realWorld = Data.realWorld;
  var all = Data.all;

  var syntheticDatasets = Data.syntheticDatasets;


  describe("should not fail", function () {
    it("when groups are set to be exposed in dataObject and releaxation is to be visible", sinon.test(function () {
      var clock = sinon.useFakeTimers();
      options.dataObject = {
        groups: [
          {
            label: "Group 1", weight: 1, id: "1",
            groups: [
              { id: "1.1", label: "Group 1.1", weight: 1, exposed: true },
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
      };
      options.relaxationVisible = true;
      newFoamTree();

      clock.tick(totalRelaxationAndRolloutTime());

      // For now we don't expect the site to be exposed.
      // This case is a bit tough to solve properly. For now, we don't initially expose
      // groups whose polygons are not available yet. Effectively, this leads to a situation
      // where the initially set exposure will not work when relaxation is to be visible.
      expect(foamtree.get("state", "1.1").exposed).to.be.false;
    }));

    // http://issues.carrot2.org/browse/FOAMTREE-261
    it("when showZeroWeightGroups is false and there are zero-weight groups", sinon.test(function () {
      withInitialViewRendered(function (clock) {
        // Try zooming to a group that is showing
        foamtree.zoom(foamtree.get("dataObject").groups[7]);
        clock.tick(foamtree.get("zoomMouseWheelDuration"));

        // Try zooming to a not-showing zero-weight group
        foamtree.zoom(foamtree.get("dataObject").groups[6]);
      }, {
        showZeroWeightGroups: false,
        dataObject: {
          groups: (function () {
            var groups = [];
            for (var i = 0; i < 20; i++) {
              groups.push({weight: i % 2});
            }
            return groups;
          })()
        }
      })
    }));
  });

  // http://issues.carrot2.org/browse/FOAMTREE-202
  it("should not render the only child group in black", sinon.test(function() {
    withInitialViewRendered(function() {
      var geometry = foamtree.get("geometry", "child");
      var pixel = getCanvasPixel(geometry.polygonCenterX, geometry.polygonCenterY, true);
      expect(pixel[0] + pixel[1] + pixel[2]).to.be.greaterThan(0);
    }, {
      dataObject: {
        groups: [ { weight: 1, open: true, groups: [ { id: "child", weight: 1 } ] } ]
      }
    })
  }));


  // http://issues.carrot2.org/browse/FOAMTREE-224
  it("should render label provided in the decorator if the data model label is empty", sinon.test(function() {
    withInitialViewRendered(function() {
      var geometry = foamtree.get("geometry", "no-label");
      var pixel = getCanvasPixel(geometry.polygonCenterX, geometry.polygonCenterY);
      expect(pixel[0] + pixel[1] + pixel[2]).to.be.equal(0);
    }, {
      dataObject: {
        groups: [ { id: "no-label", } ]
      },
      groupLabelDecorator: function (opts, params, vars) {
        vars.labelText = "\u25a0"
      }
    })
  }));
}));