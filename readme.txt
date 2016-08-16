=== GenTime ===
Contributors: Cybr
Tags: adminbar, admin, bar, generation, time, load, php, speed
Requires at least: 3.1.0
Tested up to: 4.6.0
Stable tag: 1.0.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

GenTime shows the page generation time in the WordPress admin bar.

== Description ==

= GenTime =

**This plugin simply shows you the time in seconds on how fast your page loads in 3 decimals.**

= Other notes =

> <strong>Check out the "Other Notes" tab for filters</strong>

== Installation ==

1. Install GenTime either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Either Network Activate this plugin or activate it on a single site.
1. That's it!

== Changelog ==

= 1.0.4 =
* Fixed: This plugin is now converted to UNIX line feed.
* Improved: Early sanitation of translation strings.
* Updated: POT file.
* Confirmed: WordPress 4.6 support.
* Other: The plugin license has been upgraded to GPLv3.
* Other: Cleaned up code.

= 1.0.3 =
* Fixed: The cache now works as intended.
* Fixed/Improved: Erroneous order of function checking. Which actually had no impact.
* Other: `gentime_minimum_role` filter now converts input to string.

= 1.0.2 =
* Added: POT translation file.
* Improved: Slightly improved performance (every Herz counts) by adding PHP runtime static cache earlier.
* Confirmed: WordPress 4.5+ compatibility.
* Cleaned up code.

= 1.0.1 =
* Changed: Minimum capability from edit_plugins to install_plugins so that the generation time is still shown when the Editor has been disabled.
* Added: PHP Staticvar caching for capability.
* Confirmed: 4.4.0+ support.
* Cleaned up PHP.

= 1.0.0 =
* Initial Release

== Other Notes ==

> This plugin currently has two filters.
> Add any of these filters to your theme's functions.php or a plugin to change how this plugin works.

== Filters ==

= Since 1.0.0 =

***Changes the minimum role for which the GenTime is shown:***
`add_filter( 'gentime_minimum_role', 'my_gentime_minimum_role' );
function my_gentime_minimum_role() {

    // See http://codex.wordpress.org/Roles_and_Capabilities for a list of role names
    $role = 'edit_pages'; // default: 'install_plugins'

    return $role;
}`

***Changes the number of decimals to output:***
`add_filter( 'gentime_decimals', 'my_gentime_decimals' );
function my_gentime_decimals() {
    $decimals = 4; // default: 3

    return $decimals;
}`
