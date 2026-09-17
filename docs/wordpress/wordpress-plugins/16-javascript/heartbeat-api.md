# Heartbeat API

Reference: <https://developer.wordpress.org/plugins/javascript/heartbeat-api/>

## Overview

The Heartbeat API is a simple server polling API built in to WordPress, allowing near-real-time frontend updates. This built-in feature enables communication between client and server at regular intervals.

## How It Works

The system operates through a three-step cycle:

1. **Client Initialization** - When a page loads, JavaScript sets up recurring intervals (15-120 seconds) to trigger heartbeat "ticks".
2. **Server Processing** - An admin-ajax handler receives data, processes it, and returns JSON-formatted responses.
3. **Client Response** - JavaScript receives the response and fires completion events.

The typical workflow involves:

- Adding custom fields via the `heartbeat-send` event (JavaScript)
- Processing data through the `heartbeat_received` filter (PHP)
- Handling returned data with the `heartbeat-tick` event (JavaScript)

## Implementation Steps

**Sending data** requires attaching custom information to the heartbeat payload using jQuery event listeners. This can transmit any needed values or simple confirmation flags.

**Server-side processing** detects incoming data and constructs appropriate responses. A PHP handler can check for expected fields and return processed results.

**Frontend handling** involves listening for response events and acting on returned information accordingly.

## Key Takeaway

Not all use cases require all three components. Developers can implement only the steps necessary for their specific functionality needs.
