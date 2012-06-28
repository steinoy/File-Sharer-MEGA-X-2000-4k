_.templateSettings = {
    evaluate : /\{\[([\s\S]+?)\]\}/g,
    interpolate : /\{\{([\s\S]+?)\}\}/g
};

jQuery(document).ready(function($) {
    _list = new ListView();
    $('#wrap').append(_list.el);

    var entries = [];

    for (var i = _loadedEntries.models.length - 1; i >= 0; i--) {
        entries.push(new EntryModel(_loadedEntries.models[i]));
    }

    _list.entries.add(entries);

    if(_loadedEntries.more) {
        $('.append-more-entries', this.el).show();
    }
});

/**
 * Entry model
 * 
 * @class
 */
EntryModel = Backbone.Model.extend({
    defaults: {
        title: '',
        published: '0%',
        expires: 0,
        URI: '',
        fileNames: [],
        deleteList: []
    },

    /**
     * @constructs
     */
    initialize: function () {
        this.files = []; // Files are handled separately.
        this.uploading = false;
        this.xhr = $.ajax();
    },

    /**
     * Add files by filtering the files from a FileList.
     * 
     * @param {FileList} files
     * @return {EntryModel}
     */
    addFiles: function (files) {
        var newFiles = [];

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if( ! _.isNumber(file) && ! _.isFunction(file) ) {
                if(file.size > _settings.maxSize) {
                    this.trigger('notification', 'File excluded: '+file.name+' is too big! Filesize exceeds the limit set by server.');
                } else if($.inArray(file.name.split('.').pop(), _settings.allowedExtensions) === -1) {
                    this.trigger('notification', 'File excluded: '+file.name+'. File extension not allowed.');
                } else {
                    newFiles.push(file);
                }
            }
        }

        this.files = $.merge(this.files, newFiles);
        this.trigger('change');

        return this;
    },

    /**
     * Recursively upload all the files.
     *
     * TODO: Add chunking?
     * 
     * @return {EntryModel}
     */
    uploadFiles: function (errorCallback, xhrCallback, filesToExclude) {
        var that = this;
        this.uploading = true;

        if( ! this.files.length) {
            this.uploading = false;
            this.save(); // Won't trigger change when upload has been canceled and then started again for some reason
            this.trigger('change');

            return this;
        } else if ($.inArray(this.files[0].name, filesToExclude) !== -1) {
            this.files.splice(0, 1);
            this.uploadFiles(errorCallback, xhrCallback, filesToExclude);

            return this;
        }
        
        var formData = new FormData();
        formData.append(this.files[0].name, this.files[0]);

        this.xhr = $.ajax({
            url: _settings.baseURL+'upload/files/'+this.get('id'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            xhr: xhrCallback,
            success: function (data) {
                if(data.status === 'error') {
                    errorCallback(data.message);
                    return false;
                }

                var fileNames = that.get('fileNames');
                fileNames.push(that.files[0].name);
                that.set({fileNames: fileNames});
                that.files.splice(0, 1);

                that.uploadFiles(errorCallback, xhrCallback, filesToExclude);
            },
            error: function (data) {
                if(data.statusText === 'abort') {
                    that.uploading = false;
                    that.save();
                } else {
                    errorCallback(data.statusText);
                }
            }
        });

        return this;
    },

    /**
     * Abort the current ajax request and discontinue file uploads.
     * 
     * @return {EntryModel}
     */
    abortUpload: function() {
        this.xhr.abort();

        return this;
    }

}); // End EntryModel

/**
 * Entry view.
 * 
 * @class
 */
EntryView = Backbone.View.extend({

    tagName: 'li',

    className: 'list-entry',

    template: _.template($('#list-entry-template').html()),

    fileTemplate: _.template($('#list-entry-file-template').html()),

    model: null,

    events: {
        'click .close': 'close',
        'click .save': 'save',
        'click .cancel': 'cancel',
        'click .delete': 'deleteModel',
        'click .select-more-files': 'openFileBrowser',
        'click': 'onClick',
        'click .single-file': 'onFileClick',
        'change .file-browser': 'onFileBrowserChange'
        // Makes clicking on '.save' directly from focused input unresponsive.
        // The attributes gets updated in save() and handleFilesFromBrowser()
        // instead for now...
        // 'blur input': 'onInputBlur'
    },

    /**
     * Expects an EntryModel to be sent along on initialization.
     * 
     * @constructs
     */
    initialize: function () {
        this.model.bind('change', this.render, this);
        this.model.bind('destroy', this.onModelDestroy, this);
        this.model.bind('notification', this.onModelNotification, this);

        // Add hover classes, CSS :hover leaves it in hover state on close.
        $(this.el).bind({
            mouseenter: function () {
                $(this).addClass('hover');
            },
            mouseleave: function () {
                $(this).removeClass('hover');
            }
        });

        $('.the-URI', this.el).live('click', function() {
          $(this).selText();
        });

        this.render();
    },

    /**
     * Render the entry.
     * 
     * @return {EntryView}
     */
    render: function () {
        var attrs = this.model.toJSON();

        attrs.filesMarkup = '';

        for (var i = this.model.files.length - 1; i >= 0; i--) {
            attrs.filesMarkup += this.fileTemplate({
                fileName : this.model.files[i].name,
                toBeDeleted: ($.inArray(this.model.files[i].name, attrs.deleteList) !== -1) ? true : false,
                uploaded: false
            });
        }
        
        for (var i = 0; i < attrs.fileNames.length; i++) {
            attrs.filesMarkup += this.fileTemplate({
                fileName : attrs.fileNames[i],
                toBeDeleted: ($.inArray(attrs.fileNames[i], attrs.deleteList) !== -1) ? true : false,
                uploaded: true
            });
        }

        attrs.uploading = this.model.uploading;

        $(this.el).html(this.template(attrs));

        return this;
    },

    /**
     * Save the model and start file upload.
     * 
     * @return {EntryView}
     */
    save: function () {
        var that = this;
        var oldDeleteList = this.model.get('deleteList');
        var totalFilesSize = 0;
        var totalDone = 0;

        for (var i = that.model.files.length - 1; i >= 0; i--) {
            totalFilesSize += that.model.files[i].size;
        }

        this.model.save(
            {
                title: $('.title', this.el).val(),
                expires: $('.expires', this.el).val()
            },
            {
                success: function(model, response) {
                    that.model.uploadFiles(
                        function(err) {
                            new ErrorOfNoReturn({
                                message: err
                            });
                        },
                        function(file) {
                            var xhr = new window.XMLHttpRequest();
                            var total = 0;

                            xhr.upload.addEventListener('progress', function(evt){
                                if (evt.lengthComputable) {
                                    total = evt.total;
                                    var percentComplete = Math.round(((totalDone+evt.loaded) / totalFilesSize) * 100);
                                    $('.date .content', that.el).html(percentComplete+'%');
                                }
                            }, false);

                            xhr.upload.addEventListener('load', function(evt){
                                totalDone += total;
                            }, false);

                            return xhr;
                        },
                        oldDeleteList
                    );
                    that.render();
                },
                error: function (model, response) {
                    new ErrorOfNoReturn({
                        message: response.responseText
                    });
                }
            }
        );

        return this;
    },

    /**
     * Cancel upload.
     * 
     * @return {EntryView}
     */
    cancel: function () {
        this.model.abortUpload();
        this.render();

        return this;
    },

    /**
     * Close the entry.
     * 
     * @return {EntryView}
     */
    close: function () {
        $(this.el).removeClass('active').mouseleave();

        return this;
    },

    /**
     * Destroy the model.
     * 
     * @return {EntryView}
     */
    deleteModel: function () {
        this.model.abortUpload();
        this.model.destroy();

        return this;
    },

    /**
     * Open filebrowser for this entry.
     * 
     * @return {EntryView}
     */
    openFileBrowser: function () {
        $('.file-browser', this.el).click();

        return this;
    },

    /**
     * Callback for click on the view.
     * Open the entry.
     * 
     * @return {EntryView}
     */
    onClick: function (evt) {
        if( ! $(evt.target).hasClass('close')) {
            $('.list-entry').removeClass('active');
            $(this.el).addClass('active');
        }

        return this;
    },

    /**
     * Callback for change event on the file input for this entry.
     * 
     * @param {obj} evt The event object containg the target with files.
     * @return {EntryView}
     */
    onFileBrowserChange: function(evt) {
        this.model.set({
            title: $('.title', this.el).val(),
            expires: $('.expires', this.el).val()
        });

        this.model.addFiles(evt.target.files);
        this.render();
        $('.file-browser', this.el).replaceWith('<input class="file-browser" name="uploads[]" type="file" multiple="">');

        return this;
    },

    /**
     * Callback for click on individual file names.
     * Toggle the files on and off the delete list.
     * Files in the delete list will be removed on save.
     * 
     * @return {EntryView}
     */
    onFileClick: function (evt) {
        var deleteList = this.model.get('deleteList');

        var deleteListIndex = $.inArray($(evt.target).html(), deleteList);
        
        if(deleteListIndex === -1) {
          deleteList.push($(evt.target).html());
          $(evt.target).addClass('to-be-deleted');
        } else {
          deleteList.splice(deleteListIndex, 1);
          $(evt.target).removeClass('to-be-deleted');
        }

        this.model.set({deleteList: deleteList});
        
        return this;
    },

    /**
     * Callback for when model is destroyed.
     * Remove the view.
     * 
     * @return {EntryView}
     */
    onModelDestroy: function () {
        this.remove();

        return this;
    },

    /**
     * Callback for when model triggers an notification.
     * Display the notification to the user.
     * 
     * @return {EntryView}
     */
    onModelNotification: function (message) {
        new PopUp({
            message: message
        });

        return this;
    },

    /**
     * Callback for blur event on the entry inputs.
     * Update the model attributes when inputs has
     * been interacted with.
     * 
     * @param  {obj} evt The event object containing the target input
     * @return {EntryView}
     */
    onInputBlur: function (evt) {
        var that = this;

        if($(evt.target).attr('name') === 'title') {
            $(evt.target).val(function( i, val ) {
                that.model.set({title: val});

                return val;
            });
        }

        if($(evt.target).attr('name') === 'expires') {
            $(evt.target).val(function( i, val ) {
                val = val === '' ? '∞' : val;
                that.model.set({expires: val});

                return val;
            });
        }

        return this;
    }
}); // End EntryView

/**
 * Entry collection.
 * 
 * @class
 */
EntryCollection = Backbone.Collection.extend({

    url: _settings.baseURL+'entry/',

    view: null,

    model: EntryModel,

    /**
     * @constructs
     */
    initialize: function (options) {

    }
}); // End EntryCollection

/**
 * The list view. Displays the list of entries and handles creation of new ones.
 * 
 * @see EntryView
 * @class
 */
ListView = Backbone.View.extend({
    
    tagName: 'section',

    id: 'list',

    template: _.template($('#list-template').html()),

    events: {
        'drop #dropbox': 'handleFilesFromDropbox',
        'click .append-more-entries': 'appendMoreEntries'
    },

    entries: null,

    entryViews: [],

    /**
     * @constructs
     */
    initialize: function () {
        this.entries = new EntryCollection();
        this.entries.bind('add', this.add);

        var that = this;

        // Events to get the drag n drop working.
        $('#dropbox').live({
            dragenter: function(evt) {
                evt.originalEvent.stopPropagation();
                evt.originalEvent.preventDefault();
            },

            dragleave: function(evt) {
                evt.originalEvent.stopPropagation();
                evt.originalEvent.preventDefault();

                $(this).removeClass('hover');
            },

            dragover: function(evt) {
                evt.originalEvent.stopPropagation();
                evt.originalEvent.preventDefault();

                $(this).addClass('hover');
            },

            drop: function(evt) {
                that.handleFilesFromDropbox(evt.originalEvent);
                $(this).removeClass('hover');
            }
        });

        // Events for new files. Use jQuery live instead of Backbone events
        // so that the file input can be replaced(cleared).
        $('#dropbox-file-browser', this.el).live('change', function(evt) {
            that.handleFilesFromBrowser(evt);
        });

        $('#dropbox').live('click', function(evt) {
            that.openFileBrowser(evt);
        });

        this.render();
    },

    /**
     * Render the list.
     * 
     * @return {ListView}
     */
    render: function () {
        $(this.el).html(this.template());
        return this;
    },

    /**
     * Open the file browser.
     * 
     * @return {ListView}
     */
    openFileBrowser: function () {
        $('#dropbox-file-browser').click();

        return this;
    },

    /**
     * Callback for change event on the dropbox file input.
     */
    handleFilesFromBrowser: function(evt) {
        this.newEntry(evt.target.files);
        $('#dropbox-file-browser').replaceWith('<input id="dropbox-file-browser" class="file-browser" name="uploads[]" type="file" multiple="">');
    },

    /**
     * Callback for drop event on dropbox.
     * 
     * @return {ListView}
     */
    handleFilesFromDropbox: function() {
        this.newEntry(evt.target.files);
        return this;
    },

    /**
     * Add a new entry.
     * 
     * @param {FileList} files Files to be uploaded
     * @return {ListView}
     */
    newEntry: function (files) {
        var newEntry = new EntryModel({
            title: 'Untitled',
            expires: 7,
            deleteList: []
        });

        this.entries.add(newEntry);
        newEntry.addFiles(files);

        return this;
    },

    /**
     * Create a new EntryView for a model.
     * 
     * @return {ListView}
     */
    add: function (model) {
        var newEntryView = new EntryView({
            model: model
        });

        if(model.get('published') === '0%') { // New entry
            $('#list-entries').prepend(newEntryView.el);
            $(newEntryView.el).click();
        } else { // Existing entry
            $('#list-entries').append(newEntryView.el);
        }

        return this;
    },

    /**
     * Fetch more entires and append them to the list
     * 
     * @return {ListView}
     */
    appendMoreEntries: function() {
        var that = this;

        this.entries.fetch({
            add: true,
            data: {
                offset: this.entries.models.length
            },
            success: function(c, r) {
                if(r.length === 0)
                    $('.append-more-entries', that.el).html('No more entries!').delay(1000).fadeOut();
            },
            error: function(c,r) {
                new AnError({
                    message: r.responseText
                });
            }
        });

        return this;
    }
}); // End ListView

PopUp = Backbone.View.extend({
    
    tagName: 'section',

    template: _.template($('#popup-template').html()),

    events: {
        'click': 'close'
    },

    /**
     * @constructs
     */
    initialize: function () {
        $('#wrap').after(this.el);
        $(this.el).addClass('popup');
        this.render();
    },

    /**
     * Render the pupup.
     * 
     * @return {Error}
     */
    render: function () {
        var that = this;
        $(this.el).html(that.template(this));

        return this;
    },

    close: function() {
        this.remove();
    }
});

ErrorOfNoReturn = Backbone.View.extend({
    
    tagName: 'section',

    id: 'error',

    template: _.template($('#error-template').html()),

    events: {
        'click .reload': 'reload'
    },

    /**
     * @constructs
     */
    initialize: function () {
        var that = this;

        $('#wrap').fadeOut(300, function() {
            $('#wrap').after(that.el);
        });

        this.render();
        throw this.message;
    },

    /**
     * Render the error.
     * 
     * @return {Error}
     */
    render: function () {
        var that = this;
        $(this.el).html(that.template(this));

        return this;
    },

    reload: function() {
        window.location.reload();
    }
});