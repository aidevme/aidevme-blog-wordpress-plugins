# Hooks

Reference: <https://developer.wordpress.org/plugins/hooks/>

## Overview

Hooks are a way for one piece of code to interact/modify another piece of code at specific, pre-defined spots.

There are two primary hook types:

**Actions** enable developers to insert data or alter WordPress behavior at designated execution points. Callback functions for actions can perform some kind of a task, like echoing output to the user or inserting something into the database. Action callbacks don't return values.

**Filters** allow modification of data during execution. Callback functions for filters accept a variable, modify it, and return it. These should operate independently without side effects.

## Key Distinction

The fundamental difference between these mechanisms:

- Actions perform operations and exit without returning modified data — they interrupt the code flow to do something, then return to the normal flow without modifying anything.
- Filters modify information and pass it back for subsequent use — they are used to modify something in a specific way so that the modification is then used by code later on.
