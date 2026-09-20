#!/usr/bin/env node

/**
 * Runs `php -l` (syntax-only lint, no execution) against every .php file in
 * this plugin, via a plain Node.js script rather than a shell one-liner so
 * `npm run lint-php` works the same way on Windows cmd.exe/PowerShell as on
 * a Unix shell — no `find`/`xargs`, which cmd.exe doesn't have.
 *
 * Requires a PHP CLI on PATH — see DEVELOPER.md for how to install one on
 * Windows. This exists because a real bug (CHANGE_LOG.md v62: an accidental
 * asterisk-slash inside a doc comment, closing it early and turning the
 * rest into a syntax error) reached a live site undetected, in an
 * environment with no PHP CLI available to catch it with a one-line
 * php -l before packaging. (Yes, this very comment has to be careful not
 * to spell that sequence out literally, for the same reason — see how
 * close this got.)
 */

const { spawnSync } = require( 'child_process' );
const fs = require( 'fs' );
const path = require( 'path' );

const root = path.resolve( __dirname, '..' );
const skipDirs = new Set( [ 'node_modules', 'build', 'dist', '.git' ] );

function findPhpFiles( dir, out = [] ) {
	for ( const entry of fs.readdirSync( dir, { withFileTypes: true } ) ) {
		if ( entry.isDirectory() ) {
			if ( ! skipDirs.has( entry.name ) ) {
				findPhpFiles( path.join( dir, entry.name ), out );
			}
			continue;
		}

		if ( entry.name.endsWith( '.php' ) ) {
			out.push( path.join( dir, entry.name ) );
		}
	}

	return out;
}

const files = findPhpFiles( root ).sort();

if ( 0 === files.length ) {
	console.log( 'No .php files found under ' + root );
	process.exit( 0 );
}

const probe = spawnSync( 'php', [ '-v' ], { encoding: 'utf8' } );

if ( probe.error ) {
	console.error( 'php CLI not found on PATH — see DEVELOPER.md ("Installing PHP CLI on Windows") for setup instructions.' );
	process.exit( 1 );
}

let failed = 0;

for ( const file of files ) {
	const relative = path.relative( root, file );
	const result = spawnSync( 'php', [ '-l', file ], { encoding: 'utf8' } );

	if ( 0 === result.status ) {
		console.log( 'OK   ' + relative );
	} else {
		failed++;
		console.log( 'FAIL ' + relative );
		console.log( ( result.stdout || result.stderr || '' ).trim().replace( /^/gm, '     ' ) );
	}
}

console.log( '' );

if ( failed > 0 ) {
	console.log( failed + ' of ' + files.length + ' file(s) failed to parse.' );
	process.exit( 1 );
}

console.log( 'All ' + files.length + ' PHP file(s) parsed without error.' );
