import { makeStyles, tokens } from '@fluentui/react-components';

export const useMsCertificationsListStyles = makeStyles( {
	tableWrap: {
		overflowX: 'auto',
	},
	iconImg: {
		width: '32px',
		height: '32px',
		objectFit: 'contain',
		display: 'block',
	},
	noItems: {
		padding: tokens.spacingVerticalM,
	},
} );
