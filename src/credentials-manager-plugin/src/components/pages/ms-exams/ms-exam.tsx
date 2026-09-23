/**
 * React-based "Add New Microsoft Exam" / "Edit Microsoft Exam" form, built
 * with Fluent UI 9 (`@fluentui/react-components`) controls throughout —
 * same architecture as src/ms-certification.tsx (itself modeled on
 * src/credential.tsx).
 *
 * Renders into #credpl-ms-exam-form-root (see
 * Credpl_Admin_Ms_Exams::render_edit_page()) and submits as a plain HTML
 * form POST to admin-post.php — the `credpl_save_ms_exam` handler
 * (Credpl_Admin_Ms_Exams::save()). Every field here is a plain Fluent UI
 * `Input`/`Textarea`, each forwarding its `name` prop straight through to
 * the native form control it renders — no `Dropdown`/`DatePicker` and
 * therefore no paired hidden inputs anywhere on this form:
 * `locales`/`courses`/`levels`/`roles`/`products`/`providers` are each
 * edited as one value per line in a Textarea (PHP does the
 * split/JSON-encode on save), `last_modified` uses a native
 * `<input type="datetime-local">`, and Subtitle/Study Guide are plain
 * Textareas carrying raw HTML/JSON text.
 *
 * Initial values come from `window.credplMsExamForm`, localized by PHP —
 * the array fields arrive pre-joined with `\n`, and `studyGuide`
 * pre-pretty-printed, so no client-side JSON handling is needed here
 * either.
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
import { useMsExamStyles } from './styles';

/**
 * The shape PHP's `wp_localize_script( 'credpl-ms-exam-form',
 * 'credplMsExamForm', […] )` call sends (see
 * Credpl_Admin_Ms_Exams::enqueue_assets()). `id` is a top-level scalar,
 * which `wp_localize_script()` stringifies (see the note on this in
 * src/credential.tsx) — typed `string` here for the same reason.
 */
interface MsExamFormConfig {
	id: string;
	nonce: string;
	actionUrl: string;
	uid: string;
	title: string;
	subtitle: string;
	displayName: string;
	url: string;
	iconUrl: string;
	locales: string;
	lastModified: string;
	type: string;
	courses: string;
	levels: string;
	roles: string;
	products: string;
	providers: string;
	studyGuide: string;
}

declare global {
	interface Window {
		credplMsExamForm?: MsExamFormConfig;
	}
}

const config: MsExamFormConfig = window.credplMsExamForm || ( {} as MsExamFormConfig );

/**
 * Same bug this guards against as toNumber() in credential.tsx: `id: 0`
 * arrives here as the string `"0"`, which is truthy.
 */
function toNumber( value: string | undefined ): number {
	return Number( value ) || 0;
}

const initialId = toNumber( config.id );

function MsExamForm() {
	const styles = useMsExamStyles();

	const [ uid, setUid ] = useState( config.uid || '' );
	const [ title, setTitle ] = useState( config.title || '' );
	const [ subtitle, setSubtitle ] = useState( config.subtitle || '' );
	const [ displayName, setDisplayName ] = useState( config.displayName || '' );
	const [ url, setUrl ] = useState( config.url || '' );
	const [ iconUrl, setIconUrl ] = useState( config.iconUrl || '' );
	const [ locales, setLocales ] = useState( config.locales || '' );
	const [ lastModified, setLastModified ] = useState( config.lastModified || '' );
	const [ type, setType ] = useState( config.type || '' );
	const [ courses, setCourses ] = useState( config.courses || '' );
	const [ levels, setLevels ] = useState( config.levels || '' );
	const [ roles, setRoles ] = useState( config.roles || '' );
	const [ products, setProducts ] = useState( config.products || '' );
	const [ providers, setProviders ] = useState( config.providers || '' );
	const [ studyGuide, setStudyGuide ] = useState( config.studyGuide || '' );

	return (
		<FluentProvider theme={ webLightTheme }>
			<form method="post" action={ config.actionUrl } className={ styles.form }>
				<input type="hidden" name="action" value="credpl_save_ms_exam" />
				<input type="hidden" name="id" value={ initialId } />
				<input type="hidden" name="_wpnonce" value={ config.nonce } />

				<Field
					label={ __( 'UID', 'credentials-manager-plugin' ) }
					hint={ __( 'A stable, unique identifier, e.g. "exam.mb-300".', 'credentials-manager-plugin' ) }
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
					label={ __( 'Display Name', 'credentials-manager-plugin' ) }
					hint={ __( 'Short exam code, e.g. "MB-300".', 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="display_name"
						value={ displayName }
						onChange={ ( ev, data: InputOnChangeData ) => setDisplayName( data.value ) }
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
					hint={ __( 'e.g. "exam".', 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="type"
						value={ type }
						onChange={ ( ev, data: InputOnChangeData ) => setType( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Locales', 'credentials-manager-plugin' ) }
					hint={ __( 'One locale per line, e.g. en-us.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="locales"
						rows={ 3 }
						value={ locales }
						onChange={ ( ev, data: TextareaOnChangeData ) => setLocales( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Courses', 'credentials-manager-plugin' ) }
					hint={ __( 'One course UID per line.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="courses"
						rows={ 3 }
						value={ courses }
						onChange={ ( ev, data: TextareaOnChangeData ) => setCourses( data.value ) }
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
					hint={ __( 'One role per line, e.g. functional-consultant.', 'credentials-manager-plugin' ) }
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
					label={ __( 'Products', 'credentials-manager-plugin' ) }
					hint={ __( 'One product per line, e.g. dynamics-365.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="products"
						rows={ 3 }
						value={ products }
						onChange={ ( ev, data: TextareaOnChangeData ) => setProducts( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Providers', 'credentials-manager-plugin' ) }
					hint={ __( 'One provider per line.', 'credentials-manager-plugin' ) }
				>
					<Textarea
						className={ styles.textarea }
						name="providers"
						rows={ 3 }
						value={ providers }
						onChange={ ( ev, data: TextareaOnChangeData ) => setProviders( data.value ) }
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
							? __( 'Update Microsoft Exam', 'credentials-manager-plugin' )
							: __( 'Add Microsoft Exam', 'credentials-manager-plugin' ) }
					</Button>
				</div>
			</form>
		</FluentProvider>
	);
}

const root = document.getElementById( 'credpl-ms-exam-form-root' );

if ( root ) {
	createRoot( root ).render( <MsExamForm /> );
}
