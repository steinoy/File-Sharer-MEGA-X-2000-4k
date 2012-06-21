_list = null;

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

        for (var i = _loadedEntries.length - 1; i >= 0; i--) {
            entries.push(new EntryModel(_loadedEntries[i]));
        };

        _list.entries.add(entries);
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

    files: [],

    uploading: false,

    /**
     * @constructs
     */
    initialize: function () {
        
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
     * Custom ajax call for uploading the files that has been added.
     * 
     * @return {mixed}
     */
    uploadFiles: function (xhrCallback) {
        if(_.isEmpty(this.files)) {
            return false;
        } else {
            var filesToUpload = this.files;
        }

        var formData = new FormData();

        formData.append('id', this.get('id'));
        formData.append('title', this.get('title'));
        formData.append('expires', this.get('expires'));

        var deleteList = this.get('deleteList');

        for (var i=0; i < filesToUpload.length; i++) {
            if($.inArray(filesToUpload[i].fileName, deleteList) === -1) {
                formData.append(filesToUpload[i].fileName, filesToUpload[i]);
            }
        }

        for (var i=0; i < deleteList.length; i++) {
            formData.append('delete_list[]', deleteList[i]);
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
                that.set({ uploading: false });
                that.save();

                if(data.status === 'error') {
                    throw data.message;
                }
            },
            error: function (data) {
                throw data.statusText;
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
        'change .file-browser': 'handleFilesFromBrowser',
        'blur input': 'updateInput'
    },

    /**
     * Expects a entry model to be sent along on initialization.
     * 
     * @constructs
     */
    initialize: function () {
        this.model.bind('change:fileNames', this.render, this);
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
            //attrs.fileNames.push(this.model.files[i].fileName);
            if($.inArray(this.model.files[i].fileName, attrs.deleteList) != -1) {
                var toDelete = true;
            } else {
                var toDelete = false;
            }

            attrs.filesMarkup += this.fileTemplate({
                fileName : this.model.files[i].fileName,
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
        var that = this;
        $('.date', this.el).append('<div class="spinner">');

        this.model.save(
            {
                title: $('.title', this.el).val(),
                expires: $('.expires', this.el).val()
            },
            {
                success: function(model, response) {
                    $('.spinner', that.el).remove();
                    that.render();

                    try {
                        that.model.uploadFiles(function() {
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function(evt){
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                    $('.date .content', that.el).html(percentComplete+'%');
                                }
                            }, false);

                            return xhr;
                        });
                    } catch(e) {
                        new Error('Something went wrong: '+e);
                    }
                },
                error: function (model, response) {
                    $('.spinner', that.el).remove();
                    new Error('Something went wrongs: '+response.responseText);
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
        $('.date', this.el).append('<div class="spinner">');

        this.model.destroy({
            success: function (model, response) {
                $('.spinner', that.el).remove();
            },
            error: function (model, response) {
                $('.spinner', that.el).remove();
                console.log('deleteError');
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
        'drop #dropbox': 'handleFilesFromDropbox'
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
    }
}); // End ListView

function Error(errorMsg) {
    $('#wrap').fadeOut(300, function() {
        $('#wrap').after(_.template($('#error-template').html(), { errorMessage: errorMsg }));
    });
}