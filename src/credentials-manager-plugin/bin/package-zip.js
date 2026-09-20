#!/usr/bin/env node

/**
 * Rebuilds dist/credentials-manager-plugin.zip directly from whatever is
 * currently in this plugin's directory — the "redistributable build" file
 * set SPECIFICATION.md §9 describes: runtime PHP, the compiled build/
 * output, and documentation, but none of package.json/src/node_modules/
 * tsconfig.json/webpack.config.js/bin/. Wired in as a "postbuild" script
 * (see package.json), so it runs automatically after every successful
 * `npm run build` — including the one `build:release` runs internally —
 * without needing the manual PowerShell staging script this plugin used
 * before this file existed.
 *
 * Uses adm-zip (an explicit devDependency as of this file, previously
 * only pulled in transitively by @wordpress/scripts's own toolchain)
 * rather than shelling out to a zip binary or PowerShell's
 * Compress-Archive, so this runs identically on any OS.
 */

const fs = require( 'fs' );
const path = require( 'path' );
const AdmZip = require( 'adm-zip' );

const pluginRoot = path.resolve( __dirname, '..' );
const zipRoot = 'credentials-manager-plugin';

/**
 * The fixed set of top-level docs + runtime PHP this plugin ships — the
 * same list the old manual staging script copied, kept here as an
 * explicit allowlist (rather than "everything in the plugin root") so
 * dev-only files like package.json/tsconfig.json/webpack.config.js never
 * end up in the zip just because they exist alongside these.
 */
const rootFiles = [
	'ARCHITECTURE.md',
	'CHANGE_LOG.md',
	'credentials-manager-plugin.php',
	'DEVELOPER.md',
	'END-TO-END-TESTING.md',
	'REACT-DEVELOPER-GUIDE.md',
	'SPECIFICATION.md',
	'uninstall.php',
	'UNIT-TESTING.md',
];

const zip = new AdmZip();

for ( const name of rootFiles ) {
	const full = path.join( pluginRoot, name );

	if ( fs.existsSync( full ) ) {
		zip.addLocalFile( full, zipRoot );
	} else {
		console.warn( 'package-zip: skipping missing file ' + name );
	}
}

// Every PHP class file under includes/ — globbed, not hardcoded, so a new
// admin class doesn't also need this script edited to be shipped.
const includesDir = path.join( pluginRoot, 'includes' );
const includesFiles = fs.readdirSync( includesDir ).filter( ( f ) => f.endsWith( '.php' ) ).sort();

for ( const name of includesFiles ) {
	zip.addLocalFile( path.join( includesDir, name ), zipRoot + '/includes' );
}

// Every compiled build output — whatever webpack most recently produced,
// also globbed rather than hardcoded per entry (see CHANGE_LOG.md v60/v61
// for why the old hardcoded staging script needed editing every time a
// new webpack entry was added).
const buildDir = path.join( pluginRoot, 'build' );
const buildFiles = fs.existsSync( buildDir )
	? fs.readdirSync( buildDir ).filter( ( f ) => f.endsWith( '.js' ) || f.endsWith( '.asset.php' ) ).sort()
	: [];

if ( 0 === buildFiles.length ) {
	console.error( 'package-zip: no build/*.js or build/*.asset.php found — run `npm run build` first.' );
	process.exit( 1 );
}

for ( const name of buildFiles ) {
	zip.addLocalFile( path.join( buildDir, name ), zipRoot + '/build' );
}

// assets/ (currently just assets/css/credpl-credential-block.css),
// added recursively so a future assets/ subfolder needs no script change.
const assetsDir = path.join( pluginRoot, 'assets' );

if ( fs.existsSync( assetsDir ) ) {
	zip.addLocalFolder( assetsDir, zipRoot + '/assets' );
}

const outDir = path.join( pluginRoot, 'dist' );
fs.mkdirSync( outDir, { recursive: true } );
const outPath = path.join( outDir, 'credentials-manager-plugin.zip' );

zip.writeZip( outPath );

console.log( 'package-zip: wrote ' + path.relative( pluginRoot, outPath ) + ' (' + zip.getEntries().length + ' entries)' );
