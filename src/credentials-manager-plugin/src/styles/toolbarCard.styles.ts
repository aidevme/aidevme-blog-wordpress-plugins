import { makeStyles, tokens } from '@fluentui/react-components';

export const useToolbarCardStyles = makeStyles( {
	toolbarCard: {
		marginBottom: tokens.spacingVerticalM,
		// Card's own default ("filled") appearance already provides the
		// rounded corners + shadow4 + background; nothing else to add here.
		// A block-level Card stretches to its container's width on its
		// own, matching the table below — no explicit width needed.
	},
} );
