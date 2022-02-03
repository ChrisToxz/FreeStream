// Function to detect if somthing is dragged in the window
$.fn.draghover = function(options) {
    return this.each(function() {
  
      var collection = $(),
          self = $(this);
  
      self.on('dragenter', function(e) {
        if (collection.length === 0) {
          self.trigger('draghoverstart');
        }
        collection = collection.add(e.target);
      });
  
      self.on('dragleave drop', function(e) {
        collection = collection.not(e.target);
        if (collection.length === 0) {
          self.trigger('draghoverend');
        }
      });
    });
  };

  $(window).draghover().on({
    'draghoverstart': function() {      
      $("#select-media").html("Drop your content here").addClass("drag-and-drop-active", 500).animate({
        height: "100px"
      },500)
    },
    'draghoverend': function() {
      $("#select-media").html("Select video").removeClass("drag-and-drop-active", 500).animate({
        height: "37px"
      }, 500);
    }
  });


