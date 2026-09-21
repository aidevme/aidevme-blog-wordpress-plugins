import { makeStyles, tokens } from '@fluentui/react-components';

export const useSkillStyles = makeStyles( {
	form: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalM,
		maxWidth: '560px',
	},
	control: {
		maxWidth: '560px',
	},
	actions: {
		display: 'flex',
		gap: tokens.spacingHorizontalS,
		marginTop: tokens.spacingVerticalM,
	},
} );
