import { makeStyles, tokens } from '@fluentui/react-components';

export const useTableStyles = makeStyles( {
	tableWrap: {
		overflowX: 'auto',
	},
	noItems: {
		padding: tokens.spacingVerticalM,
	},
} );
