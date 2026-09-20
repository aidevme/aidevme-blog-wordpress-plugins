#!/usr/bin/env node

/**
 * Bumps this plugin's patch version number (e.g. 0.0.70 -> 0.0.71) in both
 * package.json and credentials-manager-plugin.php, keeping the two in
 * sync the same way every manual release in this plugin's CHANGE_LOG.md
 * has. Wired in as a "prebuild" script (see package.json's lifecycle
 * hooks), so it runs automatically before `npm run build` — including
 * when `build:release` invokes `npm run build` internally, so the bump
 * happens exactly once per invocation either way, never twice.
 *
 * This does NOT bump CREDPL_DB_VERSION (that only changes on an actual
 * schema change, decided by hand) and does NOT write a CHANGE_LOG.md
 * entry (still a deliberate, hand-authored step) — it only keeps the two
 * version *numbers* from drifting apart.
 */

const fs = require( 'fs' );
const path = require( 'path' );

const pluginRoot = path.resolve( __dirname, '..' );
const packageJsonPath = path.join( pluginRoot, 'package.json' );
const mainPluginFilePath = path.join( pluginRoot, 'credentials-manager-plugin.php' );

const pkgRaw = fs.readFileSync( packageJsonPath, 'utf8' );
const pkg = JSON.parse( pkgRaw );
const currentVersion = pkg.version;
const versionMatch = /^(\d+)\.(\d+)\.(\d+)$/.exec( currentVersion );

if ( ! versionMatch ) {
	console.error( 'bump-version: could not parse package.json version "' + currentVersion + '" as X.Y.Z — leaving both files untouched.' );
	process.exit( 1 );
}

const [ , major, minor, patch ] = versionMatch;
const nextVersion = major + '.' + minor + '.' + ( Number( patch ) + 1 );
const escapedCurrentVersion = currentVersion.replace( /\./g, '\\.' );

const phpSource = fs.readFileSync( mainPluginFilePath, 'utf8' );
const docblockPattern = new RegExp( '(\\* Version:\\s+)' + escapedCurrentVersion );
const definePattern = new RegExp( "(define\\( 'CREDPL_VERSION', ')" + escapedCurrentVersion + "('\\s*\\))" );

if ( ! docblockPattern.test( phpSource ) || ! definePattern.test( phpSource ) ) {
	console.error(
		'bump-version: expected to find version ' + currentVersion + ' in both the docblock and the ' +
		"CREDPL_VERSION define() in credentials-manager-plugin.php, but didn't find one or both — " +
		'leaving package.json and credentials-manager-plugin.php untouched rather than writing a ' +
		'partial/inconsistent bump. Check whether the two files have already drifted out of sync.'
	);
	process.exit( 1 );
}

const nextPhpSource = phpSource
	.replace( docblockPattern, '$1' + nextVersion )
	.replace( definePattern, '$1' + nextVersion + '$2' );

fs.writeFileSync( mainPluginFilePath, nextPhpSource );

pkg.version = nextVersion;
fs.writeFileSync( packageJsonPath, JSON.stringify( pkg, null, 2 ) + '\n' );

console.log( 'bump-version: ' + currentVersion + ' -> ' + nextVersion + ' (package.json + credentials-manager-plugin.php)' );
