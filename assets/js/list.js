jQuery(document).ready(function($) {

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

        FB.login();
    });

    // Init list
    if(typeof _loadedEntries !== 'undefined') {
        _list = new ListView();
        $('#wrap').append(_list.el);

        var entries = [];

        for (var i = _loadedEntries.models.length - 1; i >= 0; i--) {
            entries.push(new EntryModel(_loadedEntries.models[i]));
        };

        _list.entries.add(entries);

        if(_loadedEntries.more)
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
        deleteList: [],
    },

    /**
     * @constructs
     */
    initialize: function () {
        this.files = []; // Files are handled separately.
        this.uploading = false;
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
                newFiles.push(file);
            }
        }

        this.files = $.merge(this.files, newFiles);

        return this;
    },

    /**
     * TODO: Upload files recursively.
     * 
     * @return {mixed}
     */
    uploadFiles: function (errorCallback, xhrCallback, filesToExclude) {
        if(_.isEmpty(this.files)) {
            return false;
        } else {
            var filesToUpload = this.files;
        }

        var formData = new FormData();

        formData.append('id', this.get('id'));
        formData.append('title', this.get('title'));
        formData.append('expires', this.get('expires'));

        for (var i=0; i < filesToUpload.length; i++) {
            if($.inArray(filesToUpload[i].name, filesToExclude) === -1) {
                formData.append(filesToUpload[i].name, filesToUpload[i]);
            }
        }

        for (var i=0; i < filesToExclude.length; i++) {
            formData.append('delete_list[]', filesToExclude[i]);
        }

        this.files = [];
        var that = this;

        $.ajax({
            url: _settings.siteURI+'upload/files/'+this.get('id'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            xhr: xhrCallback,
            success: function (data) {
                that.save();
                that.set({ uploading: false });

                if(data.status === 'error') {
                    errorCallback(data.message);
                }
            },
            error: function (data) {
                errorCallback(data.statusText);
            }
        });

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
        'click': 'open',
        'click .close': 'close',
        'click .save': 'save',
        'click .delete': 'delete',
        'click .select-more-files': 'openFileBrowser',
        'click .single-file': 'toggleFileSelect',
        'change .file-browser': 'handleFilesFromBrowser'
        // Makes clicking on '.save' directly from focused input unresponsive.
        // The attributes gets updated in save() and handleFilesFromBrowser()
        // instead for now...
        // 'blur input': 'updateInput'
    },

    spinner: new Spinner({
        lines: 17, // The number of lines to draw
        length: 0, // The length of each line
        width: 3, // The line thickness
        radius: 33, // The radius of the inner circle
        rotate: 0, // The rotation offset
        color: '#000', // #rgb or #rrggbb
        speed: 1, // Rounds per second
        trail: 60, // Afterglow percentage
        shadow: false, // Whether to render a shadow
        hwaccel: false, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        top: 'auto', // Top position relative to parent in px
        left: 'auto' // Left position relative to parent in px
    }),

    /**
     * Expects an EntryModel to be sent along on initialization.
     * 
     * @constructs
     */
    initialize: function () {
        this.model.bind('change', this.render, this);
        this.model.bind('destroy', this.onModelDestroy, this);

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
            if($.inArray(this.model.files[i].fileName, attrs.deleteList) != -1) {
                var toDelete = true;
            } else {
                var toDelete = false;
            }

            attrs.filesMarkup += this.fileTemplate({
                fileName : this.model.files[i].name,
                toBeDeleted: toDelete,
                uploaded: false
            });
        };
        
        for (var i=0; i < attrs.fileNames.length; i++) {
            if($.inArray(attrs.fileNames[i], attrs.deleteList) != -1) {
                var toDelete = true;
            } else {
                var toDelete = false;
            }

            attrs.filesMarkup += this.fileTemplate({
                fileName : attrs.fileNames[i],
                toBeDeleted: toDelete,
                uploaded: true
            });
        };

        $(this.el).html(this.template(attrs));

        return this;
    },

    /**
     * Callback for click event on view.
     * Open the entry.
     * 
     * @return {EntryView}
     */
    open: function (evt) {
        if( ! $(evt.target).hasClass('close')) {
            $('.list-entry').removeClass('active');
            $(this.el).addClass('active');
        }

        return this;
    },

    /**
     * Callback for click event on close.
     * Close the entry.
     * 
     * @return {EntryView}
     */
    close: function (evt) {
        $(this.el).removeClass('active').mouseleave();

        return this;
    },

    /**
     * Save the model.
     * 
     * @return {EntryView}
     */
    save: function () {
        this.spinner.spin(this.el);
        var that = this;

        var oldDeleteList = this.model.get('deleteList');

        this.model.save(
            {
                title: $('.title', this.el).val(),
                expires: $('.expires', this.el).val()
            },
            {
                success: function(model, response) {
                    that.model.uploadFiles(
                        function(err) {
                            new Error({
                                message: err
                            });
                        },
                        function() {
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function(evt){
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                    $('.date .content', that.el).html(percentComplete+'%');
                                }
                            }, false);

                            return xhr;
                        },
                        oldDeleteList
                    );
                },
                error: function (model, response) {
                    new Error({
                        message: response.responseText
                    });
                }
            }
        );

        return this;
    },

    /**
     * Delete the model.
     * 
     * @return {EntryView}
     */
    delete: function () {
        var that = this;

        this.model.destroy({
            success: function (model, response) {
            },
            error: function (model, response) {
            }
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
    updateInput: function (evt) {
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
     * Callback for change event on the file input for this entry.
     * 
     * @param {obj} evt The event object containg the target with files.
     * @return {EntryView}
     */
    handleFilesFromBrowser: function(evt) {
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
    toggleFileSelect: function (evt) {
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
     * Callbck for when model is destroyed.
     * Remove the view.
     * 
     * @return {EntryView}
     */
    onModelDestroy: function () {
        this.remove();

        return this;
    }
}); // End EntryView

/**
 * Entry collection.
 * 
 * @class
 */
EntryCollection = Backbone.Collection.extend({

    url: _settings.siteURI+'entry/',

    view: null,

    model: EntryModel,

    /**
     * @constructs
     */
    initialize: function (options) {

    },
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
                that.handleDrop(evt.originalEvent);
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

        newEntry.files = [];
        newEntry.addFiles(files);

        this.entries.add(newEntry);

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

        $('#list-entries').prepend(newEntryView.el);

        if(model.get('published') == '0%')
            $(newEntryView.el).click();

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
                    $('.append-more-entries', that.el).html('No more entries!');
            },
            error: function(c,r) {
                new Error({
                    message: r.responseText
                });
            }
        });

        return this;
    }
}); // End ListView

Error = Backbone.View.extend({
    
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