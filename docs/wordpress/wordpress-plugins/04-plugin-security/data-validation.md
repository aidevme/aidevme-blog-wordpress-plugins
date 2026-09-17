# Data Validation

Reference: <https://developer.wordpress.org/apis/security/data-validation/>

## Overview

Data validation is the process of testing information against predetermined patterns to determine whether it's valid or invalid. This security practice applies to all untrusted data sources — including user input, third-party content, and even database records.

Data validation should be performed as early as possible — meaning checking information before taking any actions based on it.

## Validation Approaches

### Safelist Method

Only accept data matching a finite set of known, trusted values. When implementing this approach, use strict type checking to prevent attackers from exploiting loose comparisons.

Code examples include:

- Direct comparison using `===` operators
- Using `in_array()` with strict mode enabled
- Employing `switch()` statements with explicit comparisons

### Alternative Methods

- **Blocklist** — rejecting known untrusted values (generally not recommended)
- **Format Detection** — testing whether data matches the correct format using functions like `ctype_alnum()` or regex patterns
- **Format Correction** — accepting data but removing or modifying potentially dangerous elements through type casting or sanitization

## Practical Examples

Validation can be applied to things like US zipcodes and database sort parameters, using multi-condition checks and comparing user input against approved lists.

## Helper Functions

WordPress provides built-in validation utilities including:

- `is_email()` — email validation
- `in_array()` — array membership checking
- `term_exists()` and `username_exists()` — database record verification
- `validate_file()` — file path validation
- String length and pattern-matching functions
