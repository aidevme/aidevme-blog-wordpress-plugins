/**
 * React-based "Add New Credential" / "Edit Credential" form, built with
 * Fluent UI 9 (`@fluentui/react-components`) controls throughout, plus
 * `@fluentui/react-datepicker-compat`'s `DatePicker` for Earned On/Expires
 * On.
 *
 * Renders into #credpl-credential-form-root (see
 * Credpl_Admin_Credentials::render_edit_page()) and submits as a plain
 * HTML form POST to admin-post.php — the exact same
 * `credpl_save_credential` handler the earlier PHP-rendered form posted
 * to, so no backend changes were needed to introduce this. The only
 * "React" part is how the fields are rendered/controlled on the client
 * (state, the badge-image media picker, the date pickers); persistence is
 * still the existing PHP save handler.
 *
 * Initial values and the save endpoint come from `window.credplCredentialForm`,
 * localized by PHP.
 */

import { createRoot, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import type { MouseEvent } from 'react';
import {
	FluentProvider,
	webLightTheme,
	Field,
	Input,
	Textarea,
	Dropdown,
	Option,
	Button,
	type InputOnChangeData,
	type TextareaOnChangeData,
	type OptionOnSelectData,
} from '@fluentui/react-components';
import { DatePicker } from '@fluentui/react-datepicker-compat';
import { useCredentialStyles } from '../../../styles';

/**
 * The shape PHP's `wp_localize_script( 'credpl-credential-form',
 * 'credplCredentialForm', […] )` call actually sends (see
 * Credpl_Admin_Credentials::enqueue_assets()). Every field is typed as a
 * string, including the numeric-looking ones (`id`, `badgeMediaId`) —
 * `wp_localize_script()` casts every scalar value to a string before
 * handing it to JS (`WP_Scripts::localize()` runs `(string) $value` on
 * each), so `id: 0` really does arrive here as the string `"0"`, not the
 * number `0`. That's the source of a real bug fixed earlier in this file
 * (see `toNumber()` below) — typing this honestly as `string` keeps that
 * mistake from being reintroduced.
 */
interface CredentialFormConfig {
	id: string;
	nonce: string;
	actionUrl: string;
	title: string;
	credentialsType: string;
	credentialsTypeOptions: string[];
	status: string;
	statusOptions: string[];
	awardCategory: string;
	technologyArea: string;
	issuer: string;
	credentialLink: string;
	badgeMediaId: string;
	badgeMediaUrl: string;
	credentialId: string;
	certificationNumber: string;
	earnedOn: string;
	expiresOn: string;
	description: string;
}

/**
 * WordPress media library attachment JSON — only the fields this
 * component actually reads.
 */
interface MediaAttachment {
	id: number;
	url: string;
	sizes?: {
		thumbnail?: {
			url: string;
		};
	};
}

declare global {
	interface Window {
		credplCredentialForm?: CredentialFormConfig;
		wp: {
			media: ( options: {
				title: string;
				button: { text: string };
				multiple: boolean;
				library: { type: string };
			} ) => {
				open: () => void;
				on: ( event: 'select', callback: () => void ) => void;
				state: () => {
					get: ( key: 'selection' ) => {
						first: () => { toJSON: () => MediaAttachment };
					};
				};
			};
		};
	}
}

const config: CredentialFormConfig = window.credplCredentialForm || ( {} as CredentialFormConfig );

/**
 * `wp_localize_script()` stringifies every value (see the doc comment on
 * `CredentialFormConfig` above), so a numeric field like `id: 0` arrives
 * here as `"0"` — a non-empty string, which is truthy in JS. Normalize to
 * a real number once, here, rather than trusting raw truthiness of
 * `config.id`/`config.badgeMediaId` anywhere below (that was the original
 * bug: `"0"` always looked "set").
 */
function toNumber( value: string | undefined ): number {
	return Number( value ) || 0;
}

const initialId = toNumber( config.id );
const initialBadgeMediaId = toNumber( config.badgeMediaId );

/**
 * `YYYY-MM-DD` (what PHP sends/expects) -> local `Date` (what DatePicker
 * needs), or `null` for an empty/invalid value. Built by hand rather than
 * `new Date( value )`, which parses `YYYY-MM-DD` as UTC midnight and can
 * display as the *previous* day in timezones behind UTC.
 */
function parseDateValue( value: string | undefined ): Date | null {
	if ( ! value ) {
		return null;
	}

	const parts = value.split( '-' ).map( Number );

	if ( 3 !== parts.length || parts.some( ( part ) => Number.isNaN( part ) ) ) {
		return null;
	}

	const [ year, month, day ] = parts;

	return new Date( year, month - 1, day );
}

/**
 * Local `Date` -> `YYYY-MM-DD` for the hidden input PHP reads. Built from
 * local date parts (not `toISOString()`, which converts to UTC first and
 * has the same day-shift problem as above).
 */
function formatDateValue( date: Date | null ): string {
	if ( ! date ) {
		return '';
	}

	const year = date.getFullYear();
	const month = String( date.getMonth() + 1 ).padStart( 2, '0' );
	const day = String( date.getDate() ).padStart( 2, '0' );

	return `${ year }-${ month }-${ day }`;
}

function CredentialForm() {
	const styles = useCredentialStyles();

	const [ title, setTitle ] = useState( config.title || '' );
	const [ credentialsType, setCredentialsType ] = useState( config.credentialsType || '' );
	const [ status, setStatus ] = useState( config.status || '' );
	const [ awardCategory, setAwardCategory ] = useState( config.awardCategory || '' );
	const [ technologyArea, setTechnologyArea ] = useState( config.technologyArea || '' );
	const [ issuer, setIssuer ] = useState( config.issuer || '' );
	const [ credentialLink, setCredentialLink ] = useState( config.credentialLink || '' );
	const [ badgeMediaId, setBadgeMediaId ] = useState( initialBadgeMediaId );
	const [ badgeMediaUrl, setBadgeMediaUrl ] = useState( config.badgeMediaUrl || '' );
	const [ credentialId, setCredentialId ] = useState( config.credentialId || '' );
	const [ certificationNumber, setCertificationNumber ] = useState( config.certificationNumber || '' );
	const [ earnedOn, setEarnedOn ] = useState<Date | null>( () => parseDateValue( config.earnedOn ) );
	const [ expiresOn, setExpiresOn ] = useState<Date | null>( () => parseDateValue( config.expiresOn ) );
	const [ description, setDescription ] = useState( config.description || '' );

	let mediaFrame: ReturnType<Window[ 'wp' ][ 'media' ]> | null = null;

	function openMediaPicker( event: MouseEvent ) {
		event.preventDefault();

		if ( mediaFrame ) {
			mediaFrame.open();
			return;
		}

		mediaFrame = window.wp.media( {
			title: __( 'Select Badge Image', 'credentials-manager-plugin' ),
			button: { text: __( 'Use this image', 'credentials-manager-plugin' ) },
			multiple: false,
			library: { type: 'image' },
		} );

		mediaFrame.on( 'select', () => {
			const attachment = mediaFrame!.state().get( 'selection' ).first().toJSON();
			const imageUrl = attachment.sizes && attachment.sizes.thumbnail
				? attachment.sizes.thumbnail.url
				: attachment.url;

			setBadgeMediaId( attachment.id );
			setBadgeMediaUrl( imageUrl );
		} );

		mediaFrame.open();
	}

	function removeBadgeImage( event: MouseEvent ) {
		event.preventDefault();
		setBadgeMediaId( 0 );
		setBadgeMediaUrl( '' );
	}

	return (
		<FluentProvider theme={ webLightTheme }>
			<form method="post" action={ config.actionUrl } className={ styles.form }>
				<input type="hidden" name="action" value="credpl_save_credential" />
				<input type="hidden" name="id" value={ initialId } />
				<input type="hidden" name="_wpnonce" value={ config.nonce } />

				<Field label={ __( 'Title', 'credentials-manager-plugin' ) } required>
					<Input
						className={ styles.control }
						name="title"
						value={ title }
						onChange={ ( ev, data: InputOnChangeData ) => setTitle( data.value ) }
						required
					/>
				</Field>

				<Field label={ __( 'Credentials Type', 'credentials-manager-plugin' ) }>
					<Dropdown
						className={ styles.control }
						placeholder={ __( 'Select a type…', 'credentials-manager-plugin' ) }
						value={ credentialsType }
						selectedOptions={ credentialsType ? [ credentialsType ] : [] }
						onOptionSelect={ ( ev, data: OptionOnSelectData ) => setCredentialsType( data.optionValue || '' ) }
					>
						{ ( config.credentialsTypeOptions || [] ).map( ( option ) => (
							<Option key={ option } value={ option }>
								{ option }
							</Option>
						) ) }
					</Dropdown>
				</Field>
				<input type="hidden" name="credentials_type" value={ credentialsType } />

				<Field label={ __( 'Status', 'credentials-manager-plugin' ) }>
					<Dropdown
						className={ styles.control }
						placeholder={ __( 'Select a status…', 'credentials-manager-plugin' ) }
						value={ status }
						selectedOptions={ status ? [ status ] : [] }
						onOptionSelect={ ( ev, data: OptionOnSelectData ) => setStatus( data.optionValue || '' ) }
					>
						{ ( config.statusOptions || [] ).map( ( option ) => (
							<Option key={ option } value={ option }>
								{ option }
							</Option>
						) ) }
					</Dropdown>
				</Field>
				<input type="hidden" name="status" value={ status } />

				{ /* 'Awards' must match the literal in Credpl_Admin_Credentials::CREDENTIALS_TYPES (§6.2) — it's one of the values credentialsTypeOptions is populated from, not a separately localized constant. */ }
				{ 'Awards' === credentialsType && (
					<>
						<Field label={ __( 'Award Category', 'credentials-manager-plugin' ) }>
							<Input
								className={ styles.control }
								name="award_category"
								value={ awardCategory }
								onChange={ ( ev, data: InputOnChangeData ) => setAwardCategory( data.value ) }
							/>
						</Field>

						<Field label={ __( 'Technology Area', 'credentials-manager-plugin' ) }>
							<Input
								className={ styles.control }
								name="technology_area"
								value={ technologyArea }
								onChange={ ( ev, data: InputOnChangeData ) => setTechnologyArea( data.value ) }
							/>
						</Field>
					</>
				) }

				<Field
					label={ __( 'Issuer', 'credentials-manager-plugin' ) }
					hint={ __( 'Organization or authority that issued the credential.', 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="issuer"
						value={ issuer }
						onChange={ ( ev, data: InputOnChangeData ) => setIssuer( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Credential ID', 'credentials-manager-plugin' ) }
					hint={ __( "The issuing platform's own identifier for this specific issued credential (e.g. a Credly credential ID) — distinct from the certification number below.", 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						name="credential_id"
						value={ credentialId }
						onChange={ ( ev, data: InputOnChangeData ) => setCredentialId( data.value ) }
					/>
				</Field>

				<Field label={ __( 'Certification Number', 'credentials-manager-plugin' ) }>
					<Input
						className={ styles.control }
						name="certification_number"
						value={ certificationNumber }
						onChange={ ( ev, data: InputOnChangeData ) => setCertificationNumber( data.value ) }
					/>
				</Field>

				<Field
					label={ __( 'Credential Link', 'credentials-manager-plugin' ) }
					hint={ __( "URL to the credential's external verification/issuing page.", 'credentials-manager-plugin' ) }
				>
					<Input
						className={ styles.control }
						type="url"
						name="credential_link"
						placeholder="https://"
						value={ credentialLink }
						onChange={ ( ev, data: InputOnChangeData ) => setCredentialLink( data.value ) }
					/>
				</Field>

				<Field label={ __( 'Earned On', 'credentials-manager-plugin' ) }>
					<DatePicker
						className={ styles.control }
						placeholder={ __( 'Select a date…', 'credentials-manager-plugin' ) }
						value={ earnedOn }
						onSelectDate={ ( date ) => setEarnedOn( date || null ) }
					/>
				</Field>
				<input type="hidden" name="earned_on" value={ formatDateValue( earnedOn ) } />

				<Field
					label={ __( 'Expires On', 'credentials-manager-plugin' ) }
					hint={ __( 'Leave both dates blank if the credential has no earned/expiry date, or does not expire.', 'credentials-manager-plugin' ) }
				>
					<DatePicker
						className={ styles.control }
						placeholder={ __( 'Select a date…', 'credentials-manager-plugin' ) }
						value={ expiresOn }
						onSelectDate={ ( date ) => setExpiresOn( date || null ) }
					/>
				</Field>
				<input type="hidden" name="expires_on" value={ formatDateValue( expiresOn ) } />

				<Field label={ __( 'Description', 'credentials-manager-plugin' ) }>
					<Textarea
						className={ styles.control }
						name="description"
						rows={ 4 }
						value={ description }
						onChange={ ( ev, data: TextareaOnChangeData ) => setDescription( data.value ) }
					/>
				</Field>

				<Field label={ __( 'Badge Image', 'credentials-manager-plugin' ) }>
					<div className={ styles.badgeRow }>
						{ badgeMediaUrl && (
							<img src={ badgeMediaUrl } alt="" className={ styles.badgePreview } />
						) }
						<Button type="button" onClick={ openMediaPicker }>
							{ __( 'Select Badge Image', 'credentials-manager-plugin' ) }
						</Button>
						{ !! badgeMediaId && (
							<Button type="button" onClick={ removeBadgeImage }>
								{ __( 'Remove', 'credentials-manager-plugin' ) }
							</Button>
						) }
					</div>
				</Field>
				<input type="hidden" name="badge_media" value={ badgeMediaId } />

				<div className={ styles.actions }>
					<Button appearance="primary" type="submit">
						{ initialId
							? __( 'Update Credential', 'credentials-manager-plugin' )
							: __( 'Add Credential', 'credentials-manager-plugin' ) }
					</Button>
				</div>
			</form>
		</FluentProvider>
	);
}

const root = document.getElementById( 'credpl-credential-form-root' );

if ( root ) {
	createRoot( root ).render( <CredentialForm /> );
}
