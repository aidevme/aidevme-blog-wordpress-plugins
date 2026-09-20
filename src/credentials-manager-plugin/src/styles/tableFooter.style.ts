import { makeStyles, tokens } from '@fluentui/react-components';

export const useTableFooterStyles = makeStyles( {
	root: {
		display: 'flex',
		alignItems: 'center',
		gap: tokens.spacingHorizontalL,
		padding: `${ tokens.spacingVerticalS } 0`,
		color: tokens.colorNeutralForeground3,
	},
} );
