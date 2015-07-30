describe("Circles", circlesTest(function() {

  // All data sets
  var synthetic = Data.synthetic;
  var realWorld = Data.realWorld;
  var all = Data.all;

  var syntheticDatasets = Data.syntheticDatasets;
  var realWorldDatasets = Data.realWorldDatasets;

  describe("should accept integer IDs", function() {
    beforeEach(function() {
      options.dataObject = {
        groups: [
          { id: 1, label: "test1" },
          { id: 2, label: "test2" },
        ]
      };
    });

    it("after selecting by id", sinon.test(function() {
      withInitialViewRendered(function(clock) {
        circles.set("selection", {groups: [2], selected: true});
        expect(circles.get("selection").groups).to.not.be.empty;
        expect(circles.get("selection").groups[0].id).to.equal(2);
      });
    }));
  });
}));