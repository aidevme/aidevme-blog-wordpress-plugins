/**
 * React-based "Add New Microsoft Certification" / "Edit Microsoft
 * Certification" form, built with Fluent UI 9 (`@fluentui/react-components`)
 * controls throughout — same architecture as src/credential.tsx.
 *
 * Renders into #credpl-ms-certification-form-root (see
 * Credpl_Admin_Ms_Certifications::render_edit_page()) and submits as a
 * plain HTML form POST to admin-post.php — the `credpl_save_ms_certification`
 * handler (Credpl_Admin_Ms_Certifications::save()). Every field here is a
 * plain Fluent UI `Input`/`Textarea`, each forwarding its `name` prop
 * straight through to the native form control it renders (confirmed
 * already for Input/Textarea in credential.tsx) — unlike that form, this
 * one needs no `Dropdown`/`DatePicker` and therefore no paired hidden
 * inputs at all: `exams`/`levels`/`roles` are edited as one value per line
 * in a Textarea (PHP does the split/JSON-encode on save), `last_modified`
 * uses a native `<input type="datetime-local">` (via `Input`'s `type`
 * prop, same pattern as Credential Link's `type="url"`), and Subtitle/
 * Study Guide are plain Textareas carrying raw HTML/JSON text.
 *
 * Initial values come from `window.credplMsCertificationForm`, localized
 * by PHP — `exams`/`levels`/`roles` arrive pre-joined with `\n`, and
 * `studyGuide` pre-pretty-printed, so no client-side JSON handling is
 * needed here either.
 */

import { createRoot, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	FluentProvider,
	webLightTheme,
	Field,
	Input,
	Textarea,
	Button,
	type InputOnChangeData,
	type TextareaOnChangeData,
} from '@fluentui/react-components';
import { useMsCertificationStyles } from '../../../styles';

/**
 * The shape PHP's `wp_localize_script( 'credpl-ms-certification-form',
 * 'credplMsCertificationForm', […] )` call sends (see
 * Credpl_Admin_Ms_Certifications::enqueue_assets()). `id` is a top-level
 * scalar, which `wp_localize_script()` stringifies (see the note on this
 * in src/credential.tsx) — typed `string` here for the same reason.
 */
interface MsCertificationFormConfig {
	id: string;
	nonce: string;
	actionUrl: string;
	uid: string;
	title: string;
	subtitle: string;
	url: string;
	iconUrl: string;
	lastModified: string;
	type: string;
	certificationType: string;
	exams: string;
	levels: string;
	roles: string;
	studyGuide: string;
}

declare global {
	interface Window {
		credplMsCertificationForm?: MsCertificationFormConfig;
	}
}

const config: MsCertificationFormConfig = window.credplMsCertificationForm || ( {} as MsCertificationFormConfig );

/**
 * Same bug this guards against as toNumber() in credential.tsx: `id: 0`
 * arrives here as the string `"0"`, which is truthy.
 */
function toNumber( value: string | undefined ): number {
	return Number( value ) || 0;
}

const initialId = toNumber( config.id );

function MsCertificationForm() {
	const styles = useMsCertificationStyles();

	const [ uid, setUid ] = useState( config.uid || '' );
	const [ title, setTitle ] = useState( config.title || '' );
	const [ subtitle, setSubtitle ] = useState( config.subtitle || '' );
	const [ url, setUrl ] = useState( config.url || '' );
	const [ iconUrl, setIconUrl ] = useState( config.iconUrl || '' );
	const [ lastModified, setLastModified ] = useState( config.lastModified || '' );
	const [ type, setType ] = useState( config.type || '' );
	const [ certificationType, setCertificationType ] = useState( config.certificationType || '' );
	const [ exams, setExams ] = useState( config.exams || '' );
	const [ levels, setLevels ] = useState( config.levels || '' );
	const [ roles, setRoles ] = useState( config.roles || '' );
	const [ studyGuide, setStudyGuide ] = useState( config.studyGuide || '' );

	return (
		<FluentProvider theme={ webLightTheme }>
			<form method="post" action={ config.actionUrl } className={ styles.form }>
				<input type="hidden" name="action" value="credpl_save_ms_certification" />
				<input type="hidden" name="id" value={ initialId } />
				<input type="hidden" name="_wpnonce" value={ config.nonce } />

				<Field
					label={ __( 'UID', 'credentials-manager-plugin' ) }
					hint={ __( "A stable, unique identifier, e.g. \"certification.mcsa-windows-server-certification\".", 'credentials-manager-plugin' ) }
					required
				>
					<Input
						className={ styles.control }
						name="uid"
						value={ uid }
						onChange={ ( ev, data: InputOnChangeData ) => setUid( data.value ) }
						required
					/>
				</Field>

				<Field label={ __( 'Title', 'credentials-manager-plugin' ) } required>
					<Input
						className={ styles.control }
						name="title"
						value={ title }
						onChange={ ( ev, data: InputOnChangeData ) => setTitle( data.value ) }
						required
					/>
				</Field>

				<Field
					label={ __( 'Subtitle', 'credentials-manager-plugin' ) }
					hint={ __( 'HTML is allowed (sanitized to a safe subset on save, same as post content).', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="subtitle"
						rows={ 6 }
						value={ subtitle }
						onChange={ ( ev, data: TextareaOnChangeData ) => setSubtitle( data.value ) }
					/>
				</Field>

				<Field label={ __( 'URL', 'credentials-manager-plugin' ) }>
					<Input
						className={ styles.control }
						type="url"
						name="url"
						placeholder="https://"
						value={ url }
						onChange={ ( ev, data: InputOnChangeData ) => setUrl( data.value ) }
					/>
				</Field>

				<Field label={ __( 'Icon URL', 'credentials-manager-plugin' ) }>
					<Input
						className={ styles.control }
						type="url"
						name="icon_url"
						placeholder="https://"
						value={ iconUrl }
						onChange={ ( ev, data: InputOnChangeData ) => setIconUrl( data.value ) }
					/>
					{ iconUrl && <img src={ iconUrl } alt="" className={ styles.iconPreview } /> }
				</Field>

				<Field label={ __( 'Last Modified', 'credentials-manager-plugin' ) }>
					<Input
						className={ styles.control }
						type="datetime-local"
						name="last_modified"
						value={ lastModified }
						onChange={ ( ev, data: InputOnChangeData ) => setLastModified( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Type', 'credentials-manager-plugin' ) }
					hint={ __( 'e.g. "cert".', 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="type"
						value={ type }
						onChange={ ( ev, data: InputOnChangeData ) => setType( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Certification Type', 'credentials-manager-plugin' ) }
					hint={ __( 'e.g. "mcsa".', 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="certification_type"
						value={ certificationType }
						onChange={ ( ev, data: InputOnChangeData ) => setCertificationType( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Exams', 'credentials-manager-plugin' ) }
					hint={ __( 'One exam UID per line, e.g. exam.70-410.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="exams"
						rows={ 4 }
						value={ exams }
						onChange={ ( ev, data: TextareaOnChangeData ) => setExams( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Levels', 'credentials-manager-plugin' ) }
					hint={ __( 'One level per line, e.g. intermediate.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="levels"
						rows={ 3 }
						value={ levels }
						onChange={ ( ev, data: TextareaOnChangeData ) => setLevels( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Roles', 'credentials-manager-plugin' ) }
					hint={ __( 'One role per line, e.g. administrator.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="roles"
						rows={ 3 }
						value={ roles }
						onChange={ ( ev, data: TextareaOnChangeData ) => setRoles( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Study Guide (JSON)', 'credentials-manager-plugin' ) }
					hint={ __( 'Raw JSON, as provided by the source data. Left as [] if empty or invalid.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="study_guide"
						rows={ 4 }
						value={ studyGuide }
						onChange={ ( ev, data: TextareaOnChangeData ) => setStudyGuide( data.value ) }
					/>
				</Field>

				<div className={ styles.actions }>
					<Button appearance="primary" type="submit">
						{ initialId
							? __( 'Update Microsoft Certification', 'credentials-manager-plugin' )
							: __( 'Add Microsoft Certification', 'credentials-manager-plugin' ) }
					</Button>
				</div>
			</form>
		</FluentProvider>
	);
}

const root = document.getElementById( 'credpl-ms-certification-form-root' );

if ( root ) {
	createRoot( root ).render( <MsCertificationForm /> );
}
