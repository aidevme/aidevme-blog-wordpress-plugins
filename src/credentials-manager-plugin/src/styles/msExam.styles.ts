import { makeStyles, tokens } from '@fluentui/react-components';

export const useMsExamStyles = makeStyles( {
	form: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalM,
		maxWidth: '560px',
	},
	control: {
		maxWidth: '560px',
	},
	textarea: {
		maxWidth: '560px',
		fontFamily: tokens.fontFamilyMonospace,
	},
	iconPreview: {
		maxWidth: '48px',
		maxHeight: '48px',
		objectFit: 'contain',
		display: 'block',
		marginTop: tokens.spacingVerticalXS,
	},
	actions: {
		marginTop: tokens.spacingVerticalM,
	},
} );
