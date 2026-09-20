import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialsBlockStyles = makeStyles( {
	form: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalM,
	},
	control: {
		maxWidth: '480px',
	},
	hint: {
		display: 'block',
		color: tokens.colorNeutralForeground3,
		marginTop: tokens.spacingVerticalXS,
	},
	columns: {
		display: 'flex',
		gap: tokens.spacingHorizontalL,
		alignItems: 'flex-start',
		flexWrap: 'wrap',
		maxWidth: '760px',
	},
	column: {
		flex: '1 1 300px',
		minWidth: '260px',
	},
	columnTitle: {
		marginBottom: tokens.spacingVerticalS,
		display: 'block',
	},
	list: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalXS,
		minHeight: '80px',
		padding: tokens.spacingVerticalS,
		border: `1px dashed ${ tokens.colorNeutralStroke2 }`,
		borderRadius: tokens.borderRadiusMedium,
	},
	emptyHint: {
		color: tokens.colorNeutralForeground3,
		padding: tokens.spacingVerticalM,
		textAlign: 'center',
	},
	card: {
		cursor: 'grab',
	},
	actions: {
		marginTop: tokens.spacingVerticalM,
	},
} );
