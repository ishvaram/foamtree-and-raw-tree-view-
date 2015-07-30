describe("FoamTree.geometry", foamtreeTest(function () {

  describe("rectangleInPolygon", function () {
    it("should return unobfuscated result", function () {
      var polygon = [
        { x: 10, y: 10 },
        { x: 100, y: 100 },
        { x: 10, y: 100 }
      ];
      var rectangle = CarrotSearchFoamTree.geometry.rectangleInPolygon(polygon, 20, 50, 1.0);

      expect(rectangle).to.include.keys(["x", "y", "w", "h"]);
    });
  });

  describe("boundingBox", function () {
    it("should return unobfuscated result", function () {
      var polygon = [
        { x: 10, y: 10 },
        { x: 100, y: 100 },
        { x: 10, y: 100 }
      ];
      var rectangle = CarrotSearchFoamTree.geometry.boundingBox(polygon);

      expect(rectangle).to.include.keys(["x", "y", "w", "h"]);
    });
  });

  describe("polygonCentroid", function () {
    it("should return unobfuscated result", function () {
      var polygon = [
        { x: 10, y: 10 },
        { x: 100, y: 100 },
        { x: 10, y: 100 }
      ];
      var rectangle = CarrotSearchFoamTree.geometry.polygonCentroid(polygon);

      expect(rectangle).to.include.keys(["x", "y", "area"]);
    });
  });

  describe("stabPolygon", function () {
    it("should return unobfuscated result", function () {
      var polygon = [
        { x: 10, y: 10 },
        { x: 100, y: 100 },
        { x: 10, y: 100 }
      ];
      var polygons = CarrotSearchFoamTree.geometry.stabPolygon(polygon, 20, 50, 0);

      for (var i = 0; i < polygons.length; i++) {
        var stab = polygons[i];
        for (var j = 0; j < stab.length; j++) {
          expect(stab[j]).to.include.keys(["x", "y"]);
        }
      }
    });
  });
}));