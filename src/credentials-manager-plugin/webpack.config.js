/**
 * @wordpress/scripts's default webpack config only auto-discovers a single
 * entry, `src/index.js` (confirmed empirically: naming the sole source
 * file anything else made `wp-scripts build` report "No entry file
 * discovered"). This plugin has four independent React apps — the
 * Credential add/edit form (src/credential.tsx), the Credential Block
 * add/edit form (src/credentials-block.tsx, which also contains the
 * two-column drag-and-drop Credentials picker as an internal component —
 * see that file's own doc comment), the Microsoft Certification add/edit
 * form (src/ms-certification.tsx), and the Microsoft Exam add/edit form
 * (src/ms-exam.tsx) — so we extend the default config with an explicit
 * multi-entry map instead, with each entry key matching its source file's
 * basename (so its compiled output lands at build/<key>.js +
 * build/<key>.asset.php, e.g. build/credential.js). See
 * Credpl_Admin_Credentials::enqueue_assets(),
 * Credpl_Admin_Blocks::enqueue_assets(),
 * Credpl_Admin_Ms_Certifications::enqueue_assets(), and
 * Credpl_Admin_Ms_Exams::enqueue_assets() for where those four build/
 * outputs are enqueued. Everything else (Babel/TSX transpilation,
 * the dependency-extraction plugin that externalizes @wordpress/* imports
 * to wp.* globals and generates each entry's .asset.php) is inherited
 * unchanged from @wordpress/scripts, which handles `.tsx` sources out of
 * the box — TypeScript's *types* are stripped by Babel during this build,
 * not checked; run `npm run check-types` (tsc, per tsconfig.json)
 * separately for actual type checking.
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		credential: './src/credential.tsx',
		'credentials-list': './src/credentials-list.tsx',
		'credentials-block': './src/credentials-block.tsx',
		'ms-certification': './src/ms-certification.tsx',
		'ms-exam': './src/ms-exam.tsx',
	},
};
