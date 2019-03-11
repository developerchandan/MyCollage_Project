(function() {
    tinymce.PluginManager.add('radium_button', function( editor, url ) {

        var params = "&width=" + 800 +"&wp_root_path="+ RadiumShortcodes.wp_root_path;

        editor.addButton( 'radium_button', {
            icon: false,
            type: 'menubutton',
            icon: 'icon radium-shortcode-icon', // icon font

            menu: [
            { text: 'Buttons', id: 'button', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Columns',  id: 'columns', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Dividers', menu: [
                {
                    text: 'Horizontal Rule',
                    onclick: function() {
                        editor.insertContent('[hr]');
                    }
                },
                {
                    text: 'Horizontal Invisible',
                    onclick: function() {
                        editor.insertContent('[hr_invisible]');
                    }
                },
                {
                    text: 'Clear',
                    onclick: function() {
                        editor.insertContent('[clear]');
                    }
                },
                {
                    text: 'Clearfix',
                    onclick: function() {
                        editor.insertContent('[clearfix]');
                    }
                }
            ]},

            { text: 'Highlight', onclick: function() { editor.insertContent('[highlight]highlighted text[/highlight]'); } },
            { text: 'Icon Fonts',  id: 'icon-fonts', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Icon',  id: 'icon', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Lists',  id: 'lists', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Social Icons',  id: 'social_icons', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Radium Image',  id: 'radium_image', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Radium Video',  id: 'radium_video', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            //{ text: 'Tabs',  id: 'tabs', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },
            { text: 'Toggles',  id: 'toggle', onclick: function() { tb_show("Insert Shortcode", url + "/popup.php?popup=" + this._id + params); } },

        ],

        });

    });
})();