#Introduction#
Newscore is Wordpress theme designed for content heavy websites. Ones that need to present alot of content from many different
taxonomies to end users.

#Dependencies#

This theme requires Wordpress 3.9 but it will work with 3.6+.

#Customization#

Customization is encouraged when using this theme. We have provided a few ways
to help you change things like the colors and layout. You may need to go beyond just the colors however and in this case
we recommend that you use the child theme provided in the "Extras" folder of the
theme package to customize your site. Read more on child themes <a href="http://codex.wordpress.org/Child_Themes">http://codex.wordpress.org/Child_Themes</a>

This theme's stylesheets, javascript and language files are managed by grunt. The stylesheets are written in SCSS. We have automated generation of
css files, sprites, language files using grunt. There are two main tasks that you cna use.

*<code>grunt build</code> - This will generate css files, verify, compress and combine javascript files. Once compilation is complete <code>grunt watch</code> will monitor the files for any new changes and compile the files automatically.
*<code>grunt build-commit</code> - This will generate the images sprites and scan php files and generate .po/.mo files for language translation.


Read more on grunt here. [gruntjs]<a href="http://gruntjs.com/">http://gruntjs.com/</a>

The theme makes extensive use of WordPress actions and filters on almost all
functions. This makes customization and overrriding features very easy. Read more <a href="http://codex.wordpress.org/Plugin_API/Action_Reference">http://codex.wordpress.org/Plugin_API/Action_Reference</a> and  <a href="http://codex.wordpress.org/Plugin_API/Filter_Reference">http://codex.wordpress.org/Plugin_API/Filter_Reference</a>

##Developer Tools##
An excellent way of styling your theme is to use the developer tools that come
with most modern browsers.
The developers tools allow you to see what HTML elements need to be styled and allows
you to edit the styling of the theme within the browser window.
These changes are not permanent and nobody else sees them, it's just a great way of
adjusting the look of your site quickly. Here are some links to the developer tools for each of the major browsers:

* Google Chrome - <a href="https://developers.google.com/chrome-developer-tools/docs/elements-styles">Inspect Element Tool</a>
* Firefox - <a href="http://www.tutorial9.net/tutorials/web-tutorials/quick-easy-css-development-with-firebug/">Firebug Tool</a>
* Internet Explorer 9 - <a href="http://msdn.microsoft.com/en-us/library/ie/gg589507(v=vs.85).aspx">F12 Developer Tools</a>
