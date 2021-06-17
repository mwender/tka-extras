# SFG Medicare Extras #
**Contributors:** [TheWebist](https://profiles.wordpress.org/TheWebist)  
**Donate link:** https://mwender.com/  
**Tags:** shortcodes  
**Requires at least:** 5.7  
**Tested up to:** 5.7.2  
**Requires PHP:** 7.4  
**Stable tag:** 0.2.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Extras for the SFG Medicare website.

## Description ##

This plugin provides extra functionality for the SFG Medicare website.

# Webinar Registration Link Shortcode #

Add `[webinar_registration_link]` to any event post to link to the Webinar Registration page with the event date/time matching the event where you added the shortcode.

```
/**
 * Returns a link to the webinar registration page.
 *
 * @param      array  $atts {
 *   @type  string  $registration_link URL to the webinar registration page. Defaults to /webinar-registration/.
 * }
 *
 * @return     string  The webinar link.
 */
```

## Changelog ##

### 0.3.0 ###
* Adding event time to registration link.

### 0.2.0 ###
* Adding "Past Event" logic to `[webinar_registration_link]`.
* Adding Elementor button style for `[webinar_registration_link]`.

### 0.1.0 ###
* Initial implementation of the `[webinar_registration_link]` shortcode.
