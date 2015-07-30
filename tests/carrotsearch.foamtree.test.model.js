describeAssuming(unobfuscated, "FoamTreeModel", function() {

  // All data sets
  var synthetic = Data.synthetic;

  var model, root;

  beforeEach(function() {
    model = new FoamTreeModel({ maxGroups: 100 });
    root = model.init();
  });

  describe("should not fail", function() {
    it("when no ids are provided in the data", function() {
      var group = { label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites("23");
      expect(result).to.be.an("array");
      expect(result).to.have.length(0);
    });

    it("when requested id is not in the data", function() {
      var group = { id: "12", label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites("23");
      expect(result).to.be.an("array");
      expect(result).to.have.length(0);
    });

    it("when requested object is not a group reference", function() {
      var group = { id: "12", label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites({});
      expect(result).to.be.an("array");
      expect(result).to.have.length(0);
    });

    it("when modified data object instance is processed again", function() {
      var group1 = { id: "12", label: "test" };
      var dataObject = { groups: [ group1 ] };
      model.load(dataObject);

      var group2 = { id: "13", label: "test" };
      dataObject.groups.unshift(group2);
      model.load(dataObject);
    });
  });

  describe("should correctly resolve", function() {
    it("one site by group reference", function() {
      var group = { label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites(group);
      expect(result).to.be.an("array");
      expect(result).to.have.length(1);

      var site = result[0];
      expect(site).not.to.be.undefined;
      expect(site.group.label).to.equal(group.label);
    });

    it("many sites by group reference", function() {
      var group1 = { label: "test1" };
      var group2 = { label: "test2" };
      model.load({ groups: [ group1, group2 ]});

      var result = model.specToSites([ group1, group2 ]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);

      expect(result[0]).not.to.be.undefined;
      expect(result[0].group.label).to.equal(group1.label);
      expect(result[1]).not.to.be.undefined;
      expect(result[1].group.label).to.equal(group2.label);
    });


    it("one site by id", function() {
      var group = { id: "23", label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites(group.id);
      expect(result).to.be.an("array");
      expect(result).to.have.length(1);

      var site = result[0];
      expect(site).not.to.be.undefined;
      expect(site.group.label).to.equal(group.label);
    });

    it("one site by non-string id", function() {
      var group = { id: 23, label: "test" };
      model.load({ groups: [ group ]});

      var result = model.specToSites(group.id);
      expect(result).to.be.an("array");
      expect(result).to.have.length(1);

      var site = result[0];
      expect(site).not.to.be.undefined;
      expect(site.group.label).to.equal(group.label);
    });

    it("many sites by id", function() {
      var group1 = { id: "23", label: "test1" };
      var group2 = { id: "24", label: "test2" };
      model.load({ groups: [ group1, group2 ]});

      var result = model.specToSites([ group1.id, group2.id ]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);

      expect(result[0]).not.to.be.undefined;
      expect(result[0].group.label).to.equal(group1.label);
      expect(result[1]).not.to.be.undefined;
      expect(result[1].group.label).to.equal(group2.label);
    });

    it("many sites by non-string id", function() {
      var group1 = { id: 23, label: "test1" };
      var group2 = { id: 24, label: "test2" };
      model.load({ groups: [ group1, group2 ]});

      var result = model.specToSites([ group1.id, group2.id ]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);

      expect(result[0]).not.to.be.undefined;
      expect(result[0].group.label).to.equal(group1.label);
      expect(result[1]).not.to.be.undefined;
      expect(result[1].group.label).to.equal(group2.label);
    });

    it("sites mixed by id and reference", function() {
      var group1 = { id: "23", label: "test1" };
      var group2 = { id: "24", label: "test2" };
      model.load({ groups: [ group1, group2 ]});

      var result = model.specToSites([ group1.id, group2 ]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);

      expect(result[0]).not.to.be.undefined;
      expect(result[0].group.label).to.equal(group1.label);
      expect(result[1]).not.to.be.undefined;
      expect(result[1].group.label).to.equal(group2.label);
    });

    it("spec object", function() {
      var group1 = { id: "2", label: "test1" };
      model.load({ groups: [ group1 ] });

      var result = model.specToSites({ groups: [ group1.id ], "selected": true }, "selected");
      expect(result).to.be.an("array");
      expect(result).to.have.length(1);

      expect(result[0]).not.to.be.undefined;
      expect(result[0].group.label).to.equal(group1.label);
    });

    it("all sites", function() {
      var group1 = { label: "test1" };
      var group2 = { label: "test2" };
      var group3 = { label: "test3", groups: [ group1, group2 ] };
      model.load({ groups: [ group3 ]});

      // For all sites, we require the explicit attachment for now
      model.attachChildren(model.specToSites(group3)[0]);

      var result = model.specToSites({ all: true });
      expect(result).to.be.an("array");
      expect(result).to.have.length(3 + 1 /* attribution group */);
    });

    it("unattached children by group reference", function() {
      var group1 = { label: "test1" };
      var group2 = { label: "test2", groups: [ group1 ] };
      var group3 = { label: "test3", groups: [ group2 ] };
      model.load({ groups: [ group3 ]});

      var result = model.specToSites([group1, group2]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);
      expect(result[0].group).to.equal(group1);
      expect(result[1].group).to.equal(group2);
    });

    it("unattached children by id", function() {
      var group1 = { id: "1", label: "test1" };
      var group2 = { id: "2", label: "test2", groups: [ group1 ] };
      var group3 = { id: "3", label: "test3", groups: [ group2 ] };
      model.load({ groups: [ group3 ]});

      var result = model.specToSites(["1", "2"]);
      expect(result).to.be.an("array");
      expect(result).to.have.length(2);
      expect(result[0].group).to.equal(group1);
      expect(result[1].group).to.equal(group2);
    });
  });
});