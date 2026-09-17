# jQuery

Reference: <https://developer.wordpress.org/plugins/javascript/jquery/>

## Overview

This guide explains how to use jQuery in WordPress plugins. Your jQuery script runs on the user's browser after your WordPress webpage is received.

## Basic Structure

jQuery statements contain two essential components: a selector identifying which HTML elements to target, and an action or event determining what occurs. The fundamental syntax follows this pattern:

```javascript
jQuery.(selector).event(function);
```

When a specified event (such as a click) happens on selected elements, the associated function executes.

All the following code examples are based on this HTML page content. Assume it appears on your plugin's admin settings screen, defined by the file `myplugin_settings.php`. It is a simple table with radio buttons next to each title.

```html
<form id="radioform">
	<table>
		<tbody>
		<tr>
			<td><input class="pref" checked="checked" name="book" type="radio" value="Sycamore Row" />Sycamore Row</td>
			<td>John Grisham</td>
		</tr>
		<tr>
			<td><input class="pref" name="book" type="radio" value="Dark Witch" />Dark Witch</td>
			<td>Nora Roberts</td>
		</tr>
		</tbody>
	</table>
</form>
```

The output could look something like this on your settings page.

In the article on AJAX, we will build an AJAX exchange that saves the user selection in usermeta and adds the number of posts tagged with the selected title. Not a very practical application, but it illustrates all the important steps. jQuery code can either reside in an external file or be output to the page inside a `<script>` block. We will focus on the external file variation because passing values from PHP requires special attention. The same code can be output to the page if that seems more expedient to you.

## Selector and Event

Selectors use CSS format conventions like ".class" or "#id". There are many more forms available, but these two are most commonly used in practice.

Events similarly offer multiple options, with "change" being useful for capturing radio button selections. jQuery event naming sometimes differs from standard JavaScript conventions.

## Example Implementation

A basic jQuery statement with a class selector and change event looks like:

```javascript
$.(".pref").change(function(){
	/*do stuff*/
});
```

This executes actions whenever any element with the "pref" class changes.

## Production Considerations

This code snippet is for illustrating the use of AJAX. The code is not suitable for production environments without proper sanitization, security measures, error handling, and internationalization.
