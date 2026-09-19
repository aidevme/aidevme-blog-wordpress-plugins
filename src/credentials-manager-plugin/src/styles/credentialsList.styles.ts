import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialsListStyles = makeStyles( {
	toolbar: {
		marginBottom: tokens.spacingVerticalM,
	},
	tableWrap: {
		overflowX: 'auto',
	},
	badgeImg: {
		display: 'block',
		width: '40px',
		height: '40px',
		objectFit: 'contain',
	},
	descriptionCell: {
		display: 'block',
		maxWidth: '280px',
		overflow: 'hidden',
		whiteSpace: 'nowrap',
		textOverflow: 'ellipsis',
	},
	noItems: {
		padding: tokens.spacingVerticalM,
	},
} );
