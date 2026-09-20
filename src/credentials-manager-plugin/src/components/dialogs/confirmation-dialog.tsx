/**
 * A generic, reusable Fluent UI 9 confirmation dialog — not specific to
 * any one entity or action. Callers own the open/closed state and the
 * copy; this component only renders the `Dialog`/`DialogSurface` chrome
 * and the Cancel/Confirm `Button`s, and calls back on either choice.
 *
 * `modalType="alert"` is deliberate: unlike a plain modal, it can't be
 * dismissed by clicking the dimmed backdrop, so a destructive action (the
 * first caller of this component is the Credentials list's Delete flow,
 * src/credentials-list.tsx) always requires an explicit Cancel or Confirm
 * click.
 */

import {
	Dialog,
	DialogSurface,
	DialogBody,
	DialogTitle,
	DialogContent,
	DialogActions,
	Button,
} from '@fluentui/react-components';
import type { ReactNode } from 'react';

export interface ConfirmationDialogProps {
	open: boolean;
	title: string;
	message: ReactNode;
	confirmLabel: string;
	cancelLabel: string;
	onConfirm: () => void;
	onCancel: () => void;
}

export function ConfirmationDialog( {
	open,
	title,
	message,
	confirmLabel,
	cancelLabel,
	onConfirm,
	onCancel,
}: ConfirmationDialogProps ) {
	return (
		<Dialog
			open={ open }
			modalType="alert"
			onOpenChange={ ( _ev, data ) => {
				if ( ! data.open ) {
					onCancel();
				}
			} }
		>
			<DialogSurface>
				<DialogBody>
					<DialogTitle>{ title }</DialogTitle>
					<DialogContent>{ message }</DialogContent>
					<DialogActions>
						<Button appearance="secondary" onClick={ onCancel }>
							{ cancelLabel }
						</Button>
						<Button appearance="primary" onClick={ onConfirm }>
							{ confirmLabel }
						</Button>
					</DialogActions>
				</DialogBody>
			</DialogSurface>
		</Dialog>
	);
}
