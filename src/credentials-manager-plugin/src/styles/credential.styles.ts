import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialStyles = makeStyles( {
	form: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalM,
		maxWidth: '480px',
	},
	control: {
		maxWidth: '480px',
	},
	badgeRow: {
		display: 'flex',
		alignItems: 'center',
		gap: tokens.spacingHorizontalS,
		flexWrap: 'wrap',
	},
	badgePreview: {
		maxWidth: '96px',
		maxHeight: '96px',
		objectFit: 'contain',
		display: 'block',
	},
	actions: {
		marginTop: tokens.spacingVerticalM,
	},
} );
