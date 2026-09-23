/**
 * The shared list-screen toolbar (§10 v88; previously hand-copied into
 * each of the five list screens — Credentials, Credential Blocks,
 * Microsoft Certifications, Microsoft Exams, Skills — see
 * `REACT-DEVELOPER-GUIDE.md` §7/§10). Renders the `Card`-wrapped `Toolbar`
 * with its fixed Back / New / Edit / Delete buttons, plus an optional
 * trailing Sync button for the two Microsoft catalog screens.
 *
 * **Back** is identical on every screen — same icon, same tooltip copy,
 * always enabled — so it takes only a `backUrl`, not a tooltip string.
 * **New**, **Edit**, and **Delete** vary their tooltip wording per entity
 * ("Create a new credential…" vs "Create a new skill…"), so those stay
 * screen-supplied strings; their *enablement*, however, is derived here
 * from what's passed in rather than taking a separate boolean per button:
 * New is disabled whenever `newDisabled` is true (the screen computes this
 * from its own selection state), and Edit is disabled whenever `editUrl`
 * is absent (i.e. no single row selected) rather than via a second prop
 * that could drift out of sync with it.
 *
 * **Delete** always opens the screen's own confirmation dialog rather than
 * deleting directly — same as before extraction — so it takes an
 * `onDelete` callback, not a URL.
 *
 * **Sync** (Microsoft Certifications/Exams only) is entirely optional —
 * omit the `sync` prop and no Sync button, divider, or icon import is
 * rendered. Like Delete, it opens a confirmation dialog rather than
 * navigating directly, so it takes a callback.
 */

import { __ } from '@wordpress/i18n';
import {
	Toolbar,
	ToolbarButton,
	ToolbarDivider,
	Card,
	Tooltip,
} from '@fluentui/react-components';
import { ArrowLeftRegular, AddRegular, EditRegular, DeleteRegular, ArrowSyncRegular } from '@fluentui/react-icons';
import { useToolbarCardStyles } from '../../styles';

export interface ListPagesToolbarSyncAction {
	/** Tooltip sentence for the Sync button, e.g. "Sync Certifications from the Microsoft Learn catalog now." */
	tooltip: string;
	/** Visible label next to the Sync icon, e.g. "Sync Certifications" — unlike the other buttons, Sync is not icon-only. */
	label: string;
	onClick: () => void;
}

export interface ListPagesToolbarProps {
	/** `Toolbar`'s own `aria-label`, e.g. "Credentials actions". */
	ariaLabel: string;
	backUrl: string;
	addNewUrl: string;
	addNewTooltip: string;
	/** Whether New is disabled — the screen computes this from its own selection state (`selectedIds.size > 0`). */
	addNewDisabled: boolean;
	editTooltip: string;
	/** The single selected row's edit URL, or `undefined` when zero or more than one row is selected — Edit is disabled whenever this is absent. */
	editUrl?: string;
	deleteTooltip: string;
	/** Whether Delete is disabled — the screen computes this from its own selection state (`0 === selectedIds.size`). */
	deleteDisabled: boolean;
	onDelete: () => void;
	/** Present only on the Microsoft Certifications/Exams screens; omit elsewhere. */
	sync?: ListPagesToolbarSyncAction;
}

export function ListPagesToolbar( {
	ariaLabel,
	backUrl,
	addNewUrl,
	addNewTooltip,
	addNewDisabled,
	editTooltip,
	editUrl,
	deleteTooltip,
	deleteDisabled,
	onDelete,
	sync,
}: ListPagesToolbarProps ) {
	const toolbarCardStyles = useToolbarCardStyles();

	return (
		<Card className={ toolbarCardStyles.toolbarCard }>
			<Toolbar aria-label={ ariaLabel }>
				<Tooltip
					content={ __( 'Go back to the Credentials Manager page.', 'credentials-manager-plugin' ) }
					relationship="label"
					withArrow
				>
					<ToolbarButton
						icon={ <ArrowLeftRegular /> }
						onClick={ () => {
							window.location.href = backUrl;
						} }
					/>
				</Tooltip>
				<ToolbarDivider />
				<Tooltip content={ addNewTooltip } relationship="label" withArrow>
					<ToolbarButton
						icon={ <AddRegular /> }
						disabledFocusable={ addNewDisabled }
						onClick={ () => {
							window.location.href = addNewUrl;
						} }
					/>
				</Tooltip>
				<Tooltip content={ editTooltip } relationship="label" withArrow>
					<ToolbarButton
						icon={ <EditRegular /> }
						disabledFocusable={ ! editUrl }
						onClick={ () => {
							if ( editUrl ) {
								window.location.href = editUrl;
							}
						} }
					/>
				</Tooltip>
				<ToolbarDivider />
				<Tooltip content={ deleteTooltip } relationship="label" withArrow>
					<ToolbarButton
						icon={ <DeleteRegular /> }
						disabledFocusable={ deleteDisabled }
						onClick={ onDelete }
					/>
				</Tooltip>
				{ sync && (
					<>
						<ToolbarDivider />
						<Tooltip content={ sync.tooltip } relationship="label" withArrow>
							<ToolbarButton icon={ <ArrowSyncRegular /> } onClick={ sync.onClick }>
								{ sync.label }
							</ToolbarButton>
						</Tooltip>
					</>
				) }
			</Toolbar>
		</Card>
	);
}
