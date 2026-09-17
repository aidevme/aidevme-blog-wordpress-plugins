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

## Selectors and Events

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
