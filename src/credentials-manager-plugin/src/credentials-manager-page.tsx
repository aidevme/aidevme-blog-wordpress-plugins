/**
 * React-based "Credentials Manager" landing page, built on Fluent UI 9 —
 * the top-level screen of the plugin's admin menu (§6.1, §6.8, §10 v72–v75, v77).
 * Renders into #credpl-credentials-manager-page-root (see
 * Credpl_Admin_Manager::render_page()).
 *
 * Four full-width section `Card`s — Main, Miscellaneous, Style,
 * Integrations — each holding the clickable navigation cards for that group
 * (see `sections` below for which card lives where; Style has none yet).
 * Destination URLs come pre-built from PHP via
 * `window.credplCredentialsManagerPage`; labels, icons, and the grouping
 * live here.
 *
 * Fluent's `Card` renders a plain `<div>`, so a click handler alone would
 * give keyboard, screen-reader, and open-in-new-tab users nothing to work
 * with. Each navigation card therefore carries a real `Link` (`<a href>`) as
 * its title, and the card-level `onClick` only adds "the whole surface is
 * clickable" on top of that — it ignores clicks that started on the anchor
 * itself, which already navigates natively. `focusMode="off"` keeps the
 * Card from also becoming its own tab stop next to that anchor. The section
 * cards themselves are plain containers — not clickable, no hover effect.
 *
 * A navigation card with no `urlKey` (none currently — Skills was the one
 * until §10 v81) has no destination yet, so it is rendered as a plain, non-interactive card: no
 * link, no click handler, and none of the pointer cursor / hover lift that
 * signal "clickable" — a card that reacted like a button but did nothing
 * would mislead. Giving it a destination later means adding its URL to the
 * localized config and setting `urlKey`; the card then becomes interactive.
 */

import { createRoot } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import type { MouseEvent } from 'react';
import { FluentProvider, webLightTheme, Card, CardHeader, Link, Text } from '@fluentui/react-components';
import {
	BoxMultipleRegular,
	RibbonRegular,
	CertificateRegular,
	ClipboardTaskListLtrRegular,
	PlugConnectedRegular,
	BrainCircuitRegular,
} from '@fluentui/react-icons';
import { useCredentialsManagerPageStyles } from './styles';

/**
 * The shape PHP's `wp_localize_script( 'credpl-credentials-manager-page',
 * 'credplCredentialsManagerPage', […] )` call sends (see
 * Credpl_Admin_Manager::enqueue_assets()).
 */
interface CredentialsManagerPageConfig {
	urls: {
		blocks: string;
		credentials: string;
		certifications: string;
		exams: string;
		skills: string;
		integrations: string;
	};
}

declare global {
	interface Window {
		credplCredentialsManagerPage?: CredentialsManagerPageConfig;
	}
}

const config: CredentialsManagerPageConfig = window.credplCredentialsManagerPage || ( {
	urls: { blocks: '', credentials: '', certifications: '', exams: '', skills: '', integrations: '' },
} as CredentialsManagerPageConfig );

interface NavCardDef {
	key: string;
	/** Which `config.urls` entry this card navigates to. Omit for a card with no destination yet. */
	urlKey?: keyof CredentialsManagerPageConfig['urls'];
	label: string;
	Icon: typeof BoxMultipleRegular;
}

interface SectionDef {
	key: string;
	title: string;
	cards: NavCardDef[];
}

const sections: SectionDef[] = [
	{
		key: 'main',
		title: __( 'Main', 'credentials-manager-plugin' ),
		cards: [
			{ key: 'blocks', urlKey: 'blocks', label: __( 'Credential Blocks', 'credentials-manager-plugin' ), Icon: BoxMultipleRegular },
			{ key: 'credentials', urlKey: 'credentials', label: __( 'Credentials', 'credentials-manager-plugin' ), Icon: RibbonRegular },
		],
	},
	{
		key: 'miscellaneous',
		title: __( 'Miscellaneous', 'credentials-manager-plugin' ),
		cards: [
			{ key: 'certifications', urlKey: 'certifications', label: __( 'Microsoft Certifications', 'credentials-manager-plugin' ), Icon: CertificateRegular },
			{ key: 'exams', urlKey: 'exams', label: __( 'Microsoft Exams', 'credentials-manager-plugin' ), Icon: ClipboardTaskListLtrRegular },
			{ key: 'skills', urlKey: 'skills', label: __( 'Skills', 'credentials-manager-plugin' ), Icon: BrainCircuitRegular },
		],
	},
	{
		key: 'style',
		title: __( 'Style', 'credentials-manager-plugin' ),
		cards: [],
	},
	{
		key: 'integrations',
		title: __( 'Integrations', 'credentials-manager-plugin' ),
		cards: [
			{ key: 'integrations', urlKey: 'integrations', label: __( 'Integrations', 'credentials-manager-plugin' ), Icon: PlugConnectedRegular },
		],
	},
];

function CredentialsManagerPage() {
	const styles = useCredentialsManagerPageStyles();

	const goTo = ( event: MouseEvent<HTMLElement>, url: string ) => {
		// A click on the title's own <a> already navigates natively (and
		// keeps ctrl/cmd/middle-click "open in new tab" working) — don't
		// navigate a second time from here.
		if ( ( event.target as HTMLElement ).closest( 'a' ) ) {
			return;
		}

		window.location.assign( url );
	};

	return (
		<div className={ styles.sections }>
			{ sections.map( ( section ) => {
				const headingId = `credpl-manager-section-${ section.key }`;

				return (
					<Card key={ section.key } className={ styles.section } aria-labelledby={ headingId }>
						<CardHeader
							header={
								<Text as="h2" id={ headingId } size={ 600 } weight="semibold">
									{ section.title }
								</Text>
							}
						/>
						{ section.cards.length > 0 ? (
							<div className={ styles.grid }>
								{ section.cards.map( ( { key, urlKey, label, Icon } ) => {
									if ( ! urlKey ) {
										return (
											<Card key={ key } appearance="outline" focusMode="off">
												<CardHeader
													image={ <Icon className={ styles.icon } aria-hidden="true" /> }
													header={ <Text size={ 500 } weight="semibold">{ label }</Text> }
												/>
											</Card>
										);
									}

									const url = config.urls[ urlKey ];

									return (
										<Card
											key={ key }
											className={ styles.card }
											appearance="outline"
											focusMode="off"
											onClick={ ( event ) => goTo( event, url ) }
										>
											<CardHeader
												image={ <Icon className={ styles.icon } aria-hidden="true" /> }
												header={
													<Link href={ url }>
														<Text size={ 500 } weight="semibold">{ label }</Text>
													</Link>
												}
											/>
										</Card>
									);
								} ) }
							</div>
						) : (
							<Text className={ styles.empty }>{ __( 'Nothing here yet.', 'credentials-manager-plugin' ) }</Text>
						) }
					</Card>
				);
			} ) }
		</div>
	);
}

const root = document.getElementById( 'credpl-credentials-manager-page-root' );

if ( root ) {
	createRoot( root ).render(
		<FluentProvider theme={ webLightTheme }>
			<CredentialsManagerPage />
		</FluentProvider>
	);
}
