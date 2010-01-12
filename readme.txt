=== Quoted Comments Widget ===
Contributors: frankieroberto
Tags: comments, widget
Requires at least: 2.8
Tested up to: 2.9.1
Stable tag: 0.2

This plugin makes a widget available which allows you to list the most recent comments to your blog, along with a short excerpt from the comment.

== Installation ==

Install this plugin in the usual way, by downloading and unzipping the folder into your plugins directory (/wp-content/plugins).

The plugin then needs to be activated before it can be used.

To use, simply drag the 'Quoted Recent Comments' widget into a sidebar. To use the widget, your theme must be widget-enabled.

== Frequently Asked Questions ==

= How do I style the list? =

You can style your list by adding the following code to the style.css file in your chosen theme:

    /* Styles for Quoted Recent Comments Widget */
    #sidebar .quoted_comments_widget ol {} /* Style for comments list */
    #sidebar .quoted_comments_widget ol li {} /* Style for comments list item */
    #sidebar .quoted_comments_widget ol li p {} /* Style for comment quote */
    #sidebar .quoted_comments_widget ol li div.comment-meta {} /* Style for comment meta */

== Screenshots ==

1. Widget settings interface.
2. How the widget appears in the default theme.

== Changelog ==

= 0.1 =
* Basic widget uploaded.

= 0.2 =
* Improved documentation.
* Plugin compatibility updated.