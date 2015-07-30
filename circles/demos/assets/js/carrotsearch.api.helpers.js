
(function() {
  //
  // Set up the demo container element and keyboard/ click hooks to hide it.
  //
  var $overlay = $("#example-overlay");
  var $visualization = $("#visualization");
  $overlay.on('click', function(e) {
    if (e.target === $overlay.get(0)) {
      closeExample();
    }
  });
  $("body").on('keydown', function(e) {
    if (e.which == 27) {
      closeExample();
    }
  });

  // Close the demo container and invoke any afterhooks, if defined.
  var afterhook;
  function closeExample() {
    if (!$overlay.hasClass("hidden")) {
      $overlay.addClass("hidden");
      if (afterhook) {
        eval.call(null, afterhook);
        afterhook = undefined;
      }
    }
  }

  //
  // Set up the environment for executable examples, including partial examples that require a model.
  //
  $("pre.executable").after(function() {
    var partial = $(this).hasClass("partial");
    var overlay = !($(this).hasClass("nooverlay"));
    var requiresFullVersion = $(this).hasClass("requiresFullVersion");
    var code = $(this).text();

    // Collect hooks before they're pretty printed.
    var runbefore = $(this).attr("data-runbefore");
    var runafter  = $(this).attr("data-runafter");
    if (runbefore) runbefore = $("#" + runbefore).text();
    if (runafter) runafter = $("#" + runafter).text();

    var $button = $('<button class="btn btn-mini btn-info" type="button">Run example</button>').on("click", function() {
      if ($button.hasClass("disabled")) return;

      $visualization.empty();
      if (overlay) {
        $overlay.removeClass("hidden");
      }

      if (partial) { // requires initialization.
        window["circles"] = new CarrotSearchCircles({
          id: "visualization",
          rolloutTime: 0,
          pullbackTime: 0,
          deferLabelRedraws: 0,
          labelRedrawFadeInTime: 0
        });
        window["circles"].set({
          dataObject: {
            groups: [
              { id: "1", label:"Group 1", groups: [
                { id: "1.1", label:"Group 1.1" },
                { id: "1.2", label:"Group 1.2" }
              ]},
              { id: "2", label:"Group 2", groups: [
                { id: "2.1", label:"Group 2.1" },
                { id: "2.2", label:"Group 2.2" }
              ]}
            ]
          }
        });
      }

      if (runbefore) {
        eval.call(null, runbefore);
      }
      if (runafter) {
        afterhook = runafter;
      }
      eval.call(null, code);
    });

    var $buttonline = $('<div class="executable-buttons"></div>').append($button);

    if (document.location.protocol == "file:" && $(this).hasClass("requireshttp")) {
      $button.addClass("disabled");
      $buttonline.append(' <span class="label label-warning">Will not work when opened as file://</span>');
    }

    if (requiresFullVersion) {
      // Defer until we have the visualization loaded.
      $(window).load(function() {
        if (!CarrotSearchCircles.version().brandingAllowed) {
          $button.addClass("disabled");
          $buttonline.append(' <span class="label label-warning">Requires full version</span>');
        }
      });
    }

    return $buttonline;
  });

  //
  // Configure pretty printed listings.
  //
  $("pre.example").each(function(i,e) {
    e = $(e);
    $(e).text($(e).text().trim());
    e.addClass("linenums prettyprint")
  });
  prettyPrint();


  //
  // Add some styling to repeatable sections.
  //
  $(document).ready(function() {
    $("div.api > h3").addClass("well");
  });

  //
  // Trigger full version class.
  //
  $(window).load(function() {
    if (CarrotSearchCircles.version().brandingAllowed) {
      $("body").addClass("fullVersion");
    }
  });


  //
  // Trigger touch devices class.
  //
  $(window).load(function() {
    if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
      $("body").addClass("touchdev");
    }
  });


  // Update scroll spy after element positions change.
  var updateScrollSpy = function () {
    $('[data-spy="scroll"]').each(function () {
      $(this).scrollspy('refresh');
      $(this).scrollspy('process');
    });
  };

  //
  // Set up the version information, TOC and scrollspy once we're fully loaded.
  //
  $(window).load(function() {
    $("#buildinfo").append(", version: " +
      CarrotSearchCircles.version().version);

    // Create TOC bar.
    var $toc = $("#toc");
    var $sections = $("section[id]").not(".notoc").map(function(i,e) {
      var $e = $(e);
      var $sectionEntry = $('<li><a href="#' + $e.attr("id") + '">' +
        '<i class="icon-chevron-right"></i> ' + $e.find("div.page-header").text() + '</a></li>');

      var $subsections = $e.find("h3[id], h2[id]");
      if ($subsections.size() > 0) {
        var $subsectionEntries = $subsections.map(function(index, elem) {
          var $elem = $(elem);
          var $li = $("<li/>");
          var text = $elem.attr("alt") ? $elem.attr("alt") : $elem.text();
          if ($elem.is("h2")) {
            $li.addClass("nav-header");
            text = text + " »";
          }
          $li.append(
            $("<a/>").attr("href", '#' + $elem.attr("id"))
                     .text(text));
          return $li;
        });
        $("<ul class='nav nav-list inline' />").append($subsectionEntries.toArray()).appendTo($sectionEntry);
      }
      return $sectionEntry;
    }).toArray();
    $toc.append($sections);

    $(window).on("resize", updateScrollSpy);
    updateScrollSpy();
  });


  //
  // Link up API references.
  //
  $(document).ready(function() {
    // Collect API entries.
    var apiEntries = {}
    $('div.api > h3[id]').each(function(i, e) {
      var key = $(e).attr("id");
      if (apiEntries.hasOwnProperty(key)) {
        console.error("Duplicate API key: " + key);
      }
      apiEntries[key] = true;
    });

    // Link up code references.
    $("code").filter(function(e) {
      var ref = $(this).text();
      return apiEntries.hasOwnProperty(ref) && !$(this).hasClass("nolink");
    }).wrapInner(function() {
      return "<a href='#" + $(this).text() + "' />";
    });
  });


  //
  // Set up layout button
  //
  $(document).ready(function() {
    var toggleLayout = function(advance) {
      var cookieName = "circles.api.layout";
      var layouts = ['itemized', 'inline'];

      var $btn = $("#toggle-layout");
      var value = $btn.data(cookieName) || (localStorage && localStorage[cookieName]);
      if (!value) {
        value = layouts[0];
      }

      if (advance) {
        value = layouts[(layouts.indexOf(value) + 1) % layouts.length];
      }

      $btn.data(cookieName, value);
      localStorage && (localStorage[cookieName] = value);

      $btn.find("i").removeClass();
      var $body = $("body");
      switch (value) {
        case "inline":
          $("#toggle-layout > i").addClass("icon-align-justify");
          $body.removeClass("navitemized");
          break;
        case "itemized":
        default:
          $("#toggle-layout > i").addClass("icon-align-left");
          $body.addClass("navitemized");
          break;
      }
      $btn.find("span").text(value);
    };

    $("#toggle-layout").on("click", function() { toggleLayout(true); });
    toggleLayout(false);
  });


  //
  // Set up font size button
  //
  $(document).ready(function() {
    var toggleFont = function(advance) {
      var cookieName = "circles.api.font";
      var options = ['small', 'normal', 'large'];

      var $btn = $("#toggle-font");
      var value = $btn.data(cookieName) || (localStorage && localStorage[cookieName]);
      if (!value) {
        value = options[0];
      }

      if (advance) {
        value = options[(options.indexOf(value) + 1) % options.length];
      }

      $btn.data(cookieName, value);
      localStorage && (localStorage[cookieName] = value);

      var $body = $("body");
      $body.removeClass("navsmall navnormal navlarge");
      switch (value) {
        case "normal":
          $body.addClass("navnormal");
          break;
        case "large":
          $body.addClass("navlarge");
          break;
        case "small":
        default:
          $body.addClass("navsmall");
          break;
      }
      $btn.find("span").text(value);
    };

    $("#toggle-font").on("click", function() { toggleFont(true); });
    toggleFont(false);
  });


  //
  // Fill-in external attribute data (types, constraints).
  //
  $(window).load(function() {
    // Because we're running after the DOM has been rendered the scroll position will be invalid after
    // we inject new elements. We can't run on document.ready though because by then the visualization
    // may not have fully loaded. Tough nut to crack.
    var defaults = {};
    // Copy manually (jquery's extend doesn't copy undefined values).
    var source = new CarrotSearchCircles().get();
    for (var prop in source) {
      defaults[prop] = source[prop];
    }

    var attrs = CarrotSearchCircles.attributes;
    $('div.api > h3[id]').each(function(i, e) {
      var key = $(e).attr("id");
      var ignoreDefaultValue = $(e).hasClass("nodefault");
      var shouldBeDocumented = !ignoreDefaultValue;
      var isAMethod = $(e).parents('[id="methods"]').length > 0;

      if (attrs[key]) {
        if (attrs[key].type)    $("<div/>").text("@type " + attrs[key].type).appendTo(e);
        if (attrs[key].asserts) $("<div/>").text("@assert " + attrs[key].asserts).appendTo(e);
        if (attrs[key].since)   $("<div/>").text("@since " + attrs[key].since).appendTo(e);
        if (attrs[key].deprecated)   $("<div/>").text("@deprecated " + attrs[key].deprecated).appendTo(e);
      } else {
        if (!isAMethod && shouldBeDocumented) {
          console.error("No constraint for attribute: " + key);
        }
      }

      if (shouldBeDocumented) {
        if (defaults.hasOwnProperty(key)) {
          var defValue = defaults[key];
          if (defValue === null) defValue = undefined;
          switch (typeof defValue) {
            case "undefined":
            case "number":
            case "boolean":
              // no default value.
              break;
            case "function":
              defValue = "[default implementation]";
              break;
            case "string":
              defValue = '"' + defValue + '"';
              break;
            case "object":
              if (Array.isArray(defValue) && defValue.length == 0) {
                // An empty array is an acceptable default.
                break;
              }
              // fall through.
            default:
              console.error("Odd default value for attribute: " + key + " of type "
                + (Array.isArray(defValue) ? "[Array]" : typeof(defValue))
                + ": " + defValue);
              break;
          }
          if (Array.isArray(defValue)) {
            defValue = "[" + (defValue.length > 0 ? "..." : "") + "]";
          }
          if (defValue != null && (typeof defValue != "undefined"))
          {
            $("<div/>").text("@defaultValue " + defValue).appendTo(e);
          }
        } else {
          if (!isAMethod) {
            console.error("Documented visualization attribute without a default value: " + key);
          }
        }
      }
      delete defaults[key];
    });

    // Check for undocumented values.
    $.each(defaults, function(k,v) {
      console.error("Undocumented visualization attribute: " + k);
    });

    // Update scrollspy after injecting new data.
    updateScrollSpy();
  });


  //
  // Restore scroll positions from session storage.
  //
  $(window).load(function() {
    var storage = sessionStorage;

    function restoreScroll($element, cookieName) {
      if (storage) {
        if (document.location.hash && $.isWindow($element.get(0))) {
          $element.scrollTop($(document.location.hash).offset().top);
        } else if (typeof storage[cookieName] !== "undefined") {
          $element.scrollTop(storage[cookieName]);
        }

        var fn = function() {
          storage[cookieName] = $element.scrollTop();
        };
        $element.scroll(fn);
        return fn;
      }
    };

    restoreScroll($(window), "circles.api.scrolllock.window");
    restoreScroll($("#toc"), "circles.api.scrolllock.nav");
  });
})();