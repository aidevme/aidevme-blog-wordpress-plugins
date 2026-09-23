/**
 * @wordpress/scripts's default webpack config only auto-discovers a single
 * entry, `src/index.js` (confirmed empirically: naming the sole source
 * file anything else made `wp-scripts build` report "No entry file
 * discovered"). This plugin has eleven independent React apps — the four
 * Add/Edit forms (Credential: src/components/pages/credentials/credential.tsx;
 * Credential Block: src/components/pages/credentials-blocks/credentials-block.tsx,
 * which also contains the two-column drag-and-drop Credentials picker as an
 * internal component — see that file's own doc comment; Microsoft Certification:
 * src/components/pages/ms-certifications/ms-certification.tsx; Microsoft Exam:
 * src/components/pages/ms-exams/ms-exam.tsx), the four
 * list screens converted to this same React/Fluent UI pattern (Credentials:
 * src/components/pages/credentials/credentials-list.tsx, §10 v34; Credential Blocks:
 * src/components/pages/credentials-blocks/credentials-blocks-list.tsx, §10 v59; Microsoft Certifications:
 * src/components/pages/ms-certifications/ms-certifications-list.tsx, §10 v60; Microsoft Exams:
 * src/components/pages/ms-exams/ms-exams-list.tsx, §10 v61 — see REACT-DEVELOPER-GUIDE.md for the
 * pattern itself), the Skills form and list
 * (src/components/pages/skills/skill.tsx, src/components/pages/skills/skills-list.tsx, §10 v81),
 * and the empty top-level Credentials Manager landing
 * page (src/components/pages/credentials-manager/credentials-manager-page.tsx,
 * §10 v72) — so we extend the
 * default config with an explicit
 * multi-entry map instead, with each entry key matching its source file's
 * basename (so its compiled output lands at build/<key>.js +
 * build/<key>.asset.php, e.g. build/credential.js). See
 * Credpl_Admin_Credentials::enqueue_assets(),
 * Credpl_Admin_Blocks::enqueue_assets(),
 * Credpl_Admin_Ms_Certifications::enqueue_assets(),
 * Credpl_Admin_Ms_Exams::enqueue_assets(),
 * Credpl_Admin_Skills::enqueue_assets(), and
 * Credpl_Admin_Manager::enqueue_assets() for where each of those eleven
 * build/ outputs is enqueued. Everything else (Babel/TSX transpilation,
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
		credential: './src/components/pages/credentials/credential.tsx',
		'credentials-list': './src/components/pages/credentials/credentials-list.tsx',
		'credentials-block': './src/components/pages/credentials-blocks/credentials-block.tsx',
		'credentials-blocks-list': './src/components/pages/credentials-blocks/credentials-blocks-list.tsx',
		'ms-certification': './src/components/pages/ms-certifications/ms-certification.tsx',
		'ms-certifications-list': './src/components/pages/ms-certifications/ms-certifications-list.tsx',
		'ms-exam': './src/components/pages/ms-exams/ms-exam.tsx',
		'ms-exams-list': './src/components/pages/ms-exams/ms-exams-list.tsx',
		skill: './src/components/pages/skills/skill.tsx',
		'skills-list': './src/components/pages/skills/skills-list.tsx',
		'credentials-manager-page': './src/components/pages/credentials-manager/credentials-manager-page.tsx',
	},
};
