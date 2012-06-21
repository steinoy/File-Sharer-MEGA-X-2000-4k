(function ($) {
  
   // Login

  $('#fb-login').click(function(e) {
    e.preventDefault();

    FB.init({
      appId: _settings.facebook.id,
      cookie: true,
      oauth: true
    });

    FB.Event.subscribe('auth.login', function(response) {
      window.location.reload();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      window.location.reload();
    });

    FB.login(function(response) {
      // Moo
    });
  });
  
  // Files

  if($('#upload').length) {
    $.ajaxSetup({ cache: false });
    _list = new List();
  }
    
})(jQuery);

function List() {
  this.entries  = { unstoredEntries: {} };
  this.list     = $('#files-list ul');
  this.dropbox  = $('#upload');
  
  this.currentOpenEntry = undefined;
  
  var self = this;
  
  // Dropbox events
  
  $(self.dropbox).live({
    dragenter: function(evt) {
      self.doNothing(evt.originalEvent);
    },
    dragleave: function(evt) {
      self.doNothing(evt.originalEvent);
      $(self.dropbox).removeClass('hover');
    },
    dragover: function(evt) {
      self.doNothing(evt.originalEvent);
      $(self.dropbox).addClass('hover');
    },
    drop: function(evt) {
      self.handleDrop(evt.originalEvent);
      $(self.dropbox).removeClass('hover');
    },
    click: function(evt) {
      $('.dropbox-file-browser').click();
    }
  });
  
  // Handle files from file browser
  
  $('.file-browser').live('change', function() {
    var files = this.files;
    var id = $(this).data('id');

    var fileNames = [];
    for (var i=0; i < files.length; i++) {
      fileNames[i] = files[i].name;
    };
    
    if(id === 'dropbox') {
      var tmpPos = _.keys(self.entries.unstoredEntries).length+1;
      tmpPos = -tmpPos;
      var newEntry = new Entry(tmpPos, 'Untitled', { names: fileNames, data: files }, 7, '0%', '', null);
      self.entries.unstoredEntries[tmpPos] = newEntry;
      
      var newListItem = newEntry.render(true);
      $(self.list).prepend(newListItem);
      $(newListItem).fadeIn();
      self.open(tmpPos);
    } else {
      if(id < 0) {
        var entry = self.entries.unstoredEntries[id];
      } else {
        var entry = self.entries[id];
      }
      entry.addFiles({ names: fileNames, data: files });      
    }
  });
  
  $('.file-entry .select-more-files').live('click', function() {
     $('.file-browser', $(this).parent()).click();
  });
  
  // List entires events
	
	$('.file-browser').live('click', function(evt) {
		var el = $('.file-entry[data-id="'+$(this).data("id")+'"]');
		if($(el).hasClass('uploading')) {
			evt.preventDefault();
		}
	});
  
  $('.file-entry', this.list).live({
    click: function(evt) {
      if($(this).hasClass('inactive') && ! $(evt.target).hasClass('cancel')){
        self.open($(this).data('id'));
      }
      $(this).mouseout();
    },
   mouseover: function() {
      $(this).addClass('hover');
    },
    mouseout: function() {
      $(this).removeClass('hover');
    }
  });
  
  $('.file-entry .cancel', this.list).live({
    click: function(evt) {
      self.close($(this).data('id'));
    }
  });
  
  $('.file-entry .save', this.list).live({
    click: function(evt) {
      self.save($(this).data('id'));
    }
  });
  
  $('.file-entry .delete', this.list).live({
    click: function(evt) {
      self.delete($(this).data('id'));
    }
  });
    
  $('.file-entry input').live('blur', function(e) {
    var id = parseInt($(this).parents('.file-entry').data('id'));
    if(id < 0) {
      var entry = self.entries.unstoredEntries[id];
    } else {
      var entry = self.entries[id];
    }
        
    if($(e.target).attr('name') === 'title') {
      $(this).val(function( i, val ) {
        entry.title = val;
        return val;
      });
    }
    
    if($(e.target).attr('name') === 'expires') {
      $(this).val(function( i, val ) {
        val = val === '' ? '∞' : val;
        entry.expires = val;
        return val;
      });
    }    
  });
  
  $('.file-entry .single-file').live('click', function() {
    var id = $(this).data('id');
    
    if(id < 0) {
      var entry = self.entries.unstoredEntries[id];
    } else {
      var entry = self.entries[id];
    }
    
    var deleteListIndex = $.inArray($(this).html(), entry.deleteList);
    
    if(deleteListIndex === -1) {
      entry.deleteList.push($(this).html());
      $(this).addClass('to-be-deleted');
    } else {
      entry.deleteList.splice(deleteListIndex, 1);
      $(this).removeClass('to-be-deleted');
    }
  });
  
  $('.append-more-entries').live('click', function() {
    self.append($('.file-entry', self.list).length);
  });
  
  $('.the-URI').live('click', function() {
    $(this).selText();
  });
  
  $.get('entry/list/0', function(data) {
    console.log(data);
    if(typeof data.entries !== 'undefined') {
      for (var i = 0; i < data.entries.length; i++) {
        var entry = data.entries[i];
        var files = [];

        for (var x = 0; x < entry.files.length; x++) {
          files[x] = entry.files[x].name;
        };
                
        var newEntry = new Entry(entry.id, entry.title, { names: files, data: undefined }, entry.expires, entry.published, entry.URI);
        self.entries[entry.id] = newEntry;
        var newListItem = newEntry.render(true);
        $(self.list).append(newListItem);
        $(newListItem).fadeIn();
				if(data.more) {
					$('.append-more-entries').show();
				}
      }
    }
  });
}

List.prototype.doNothing = function(evt) {
  evt.stopPropagation();
  evt.preventDefault();
}

List.prototype.handleDrop = function(evt) {
  evt.stopPropagation();
  evt.preventDefault();

  var files = evt.dataTransfer.files;
  var count = files.length;
    
  if (count > 0) {
    var fileNames = [];
    for (var i=0; i < files.length; i++) {
      fileNames[i] = files[i].name;
    };
    
    var tmpPos = _.keys(this.entries.unstoredEntries).length+1;
    tmpPos = -tmpPos;
    var newEntry = new Entry(tmpPos, 'Untitled', { names: fileNames, data: files }, 7, '0%', '', null);
    this.entries.unstoredEntries[tmpPos] = newEntry;
    
    var newListItem = newEntry.render(true);
    $(this.list).prepend(newListItem);
    $(newListItem).fadeIn();
    this.open(tmpPos);
		this.currentOpenEntry = newEntry.id;
  }
}

List.prototype.open = function(id) {  
  var el = $('.file-entry[data-id="'+id+'"]');
  
  if(typeof  this.currentOpenEntry !== 'undefined')
    this.close(this.currentOpenEntry);
  
  this.currentOpenEntry = id;
  
  $('.entry-content', el).show();
  $(el).removeClass('inactive').addClass('active');
  
}

List.prototype.close = function(id) {
  var el = $('.file-entry[data-id="'+id+'"]');
  
  this.currentOpenEntry = undefined;
  
  $('.entry-content', el).hide();
  $(el).removeClass('active').addClass('inactive');
}

List.prototype.save = function(id) {
  var self = this;
  
  if(id < 0) {
    var entry = self.entries.unstoredEntries[id];
  } else {
    var entry = self.entries[id];
  }
  
  var oldId = entry.id;
  
  entry.save(function(newId) {
    var el = $('.file-entry[data-id="'+oldId+'"]');
    $(el).attr('data-id', newId);
    $('.entry-content, .select-more-files, .file-browser, .submit, .single-file', el).attr('data-id', newId);
		
    $('.file-entry[data-id="'+oldId+'"]').data('id', newId);
    self.entries[newId] = self.entries.unstoredEntries[oldId];
    delete self.entries.unstoredEntries[oldId];
		
		var el = $('.file-entry[data-id="'+newId+'"]');
		
		if($(el).hasClass('active')) {
			self.currentOpenEntry = newId;
		}
  });
}

List.prototype.delete = function(id) {
  var self  = this;
  var el    = $('.file-entry[data-id="'+id+'"]');
  
  if(id < 0) {
    delete this.entries.unstoredEntries[id];
    $(el).remove();
  } else {
    if(self.entries[id].uploading) {
      return false;
    }
    
    $.get('entry/delete/'+id, function(data) {
      if(data.status === 'success') {
        delete self.entries[id];
        $(el).remove();
      }
    });
  }
}

List.prototype.append = function(offset) {
  var self = this;
  $.get('entry/list/'+offset, function(data) {
    if(typeof data.entries !== 'undefined') {
      for (var i = 0; i < data.entries.length; i++) {
        var entry = data.entries[i];
        var files = [];

        for (var x = 0; x < entry.files.length; x++) {
          files[x] = entry.files[x].name;
        };

        var newEntry = new Entry(entry.id, entry.title, { names: files, data: undefined }, entry.expires, entry.published, entry.URI);
        self.entries[entry.id] = newEntry;
        var newListItem = newEntry.render(true);
        $(self.list).append(newListItem);
        $(newListItem).fadeIn();
				
				if( ! data.more) {
					$('.append-more-entries').hide();
				}
      }
    }
  });
}

function Entry(id, title, files, expires, published, URI) {
  this.id               = id;          
  this.title            = title;       
  this.expires          = expires;     
  this.published        = published;
  this.URI              = URI;
                                   
  this.fileNames        = [];          
  this.files            = [];          
  this.deleteList       = [];          
  this.uploading        = false;
  this.xhr              = null;
  
  this.filesMarkup      = '';
  this.fileTemplate     = _.template($('#entry-file-template').html());
  this.template         = _.template($('#entry-template').html());
  
  this.addFiles(files);
}

Entry.prototype.addFiles = function(files) {
  for (var file in files.data) {
    var obj = files.data[file];
    if( _.isNumber(obj) || _.isFunction(obj) ) {
      // No thx
    } else {
      this.files.push(obj);
    }
  }
	
  this.fileNames = $.merge(this.fileNames, files.names);
	
	$('.select-files').replaceWith('<input class="select-files" name="uploads[]" type=file multiple>');
  this.render(false, true);
}

Entry.prototype.render = function(hide, update) {
  var self = this;
  var el = $('.file-entry[data-id="'+this.id+'"]');
  var open = $(el).hasClass('active');

  this.filesMarkup = '';
  for (var i=0; i < this.fileNames.length; i++) {
    if($.inArray(self.fileNames[i], this.deleteList) != -1) {
      var toDelete = 'to-be-deleted';
    } else {
      var toDelete = '';
    }
    this.filesMarkup += this.fileTemplate({ fileName : self.fileNames[i], id: self.id, status: toDelete });
  };

  if(hide) {
    return $(this.template(this)).hide();
  } else if(update) {
    $(el).replaceWith(this.render());
    if(open) {
      var el = $('.file-entry[data-id="'+this.id+'"]');
      $(el).removeClass('inactive').addClass('active');
      $('.entry-content', el).show();
    }
    
    return true;
  }
  
  return this.template(this);
}

Entry.prototype.save = function(updateList) {
  	
	if(this.uploading) {
		this.cancelUpload();
		
		return false;	
	}
	
	var el = $('.file-entry[data-id="'+this.id+'"]');
	$('.save', el).html('Cancel');
	
  if(this.id < 0) {
    this.preSave(updateList);
    return;
  }
  
	this.uploading = true;
  
  var self = this;
  
  var formData = new FormData();

  var expires = this.expires === '&#8734;' ? 'never' : this.expires;

  formData.append('id', this.id);
  formData.append('title', this.title);
  formData.append('expires', this.expires);
  
  var uploading_files = [];
  
	if(typeof this.files !== 'undefined') {
		for (var i=0; i < this.files.length; i++) {
			if($.inArray(this.files[i].name, this.deleteList) === -1) {
				formData.append(this.files[i].name, this.files[i]);
				uploading_files.push(this.files[i].name);
			}
		}
	}
	
	for (var i=0; i < this.deleteList.length; i++) {
		formData.append('delete_list[]', this.deleteList[i]);
		
		for (var ii=0; ii < this.files.length; ii++) {
		  if(this.files[ii].name == this.deleteList[i]) {		    
		    this.files.splice(ii, 1);
		  }
		};
	};
    
  // this.files = [];
	this.deleteList = [];
  $('.select-files').replaceWith('<input class="select-files" name="uploads[]" type=file multiple>');
  
	$(el).addClass('uploading');
  	
  this.xhr = $.ajax({
    url: 'entry/update/'+self.id,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
		xhr: function()
		  {
		    var xhr = new window.XMLHttpRequest();
		    xhr.upload.addEventListener("progress", function(evt){
			     if (evt.lengthComputable) {
			       var percentComplete = Math.round((evt.loaded / evt.total) * 100);
						$('.date .content', el).html(percentComplete+'%');
						if(percentComplete == 100) {
							finnishedTmpUpload = true;
						}
			     }
				}, false);
					
				return xhr;
		  },
    success: function(data) {
      self.uploading = false;
      self.files = [];
			$(el).removeClass('uploading');
			
      if(data.status === 'success') {
        var updatedEntry  = data.entry;

        self.id         = updatedEntry.id;
        self.title      = updatedEntry.title;
        self.expires    = updatedEntry.expires;
        self.published  = updatedEntry.published;
        self.URI        = updatedEntry.URI;
        
        var fileNames = [];
        for (var i=0; i < updatedEntry.files.length; i++) {
          fileNames[i] = updatedEntry.files[i].name;
        };
        
		self.fileNames 	= fileNames;

        self.render(false, true);
      } else {
      	new Error(data.message);
      }
    },
    error: function(data) {
      if(data.statusText == 'abort') {
        self.uploading = false;
        $(el).removeClass('uploading');

        //self.fileNames = _.without(self.fileNames, uploading_files);
        self.render(false, true);
      } else {
        new Error(data.statusText);
      }
      
    }
  });
}

Entry.prototype.preSave = function(updateList) {
  var self = this;
  
  var formData = new FormData();
  
  formData.append('id', this.id);
  formData.append('title', this.title);
  formData.append('expires', this.expires);

  $.ajax({
    url: 'entry/update/'+self.id,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    success: function(data) {
      if(data.status === 'success') {
        var oldId         = self.id;
        var updatedEntry  = data.entry;

        self.id         = updatedEntry.id;
        self.title      = updatedEntry.title;
        self.expires    = updatedEntry.expires;
        
        updateList(self.id);

        self.render(false, true);
        				
        self.save();
      } else if(data.status === 'error') {
        new Error(data.message);
      }
    },
	error: function(data) {
		new Error(data.statusText);
	}
  });
}

Entry.prototype.cancelUpload = function() {
	this.xhr.abort();
}

function Error(errorMsg) {
	$('#wrap').fadeOut(300, function() {
		$('#wrap').after(_.template($('#error-template').html(), { errorMessage: errorMsg }));
	});
}