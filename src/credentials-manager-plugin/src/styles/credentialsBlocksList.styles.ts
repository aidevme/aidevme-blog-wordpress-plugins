import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialsBlocksListStyles = makeStyles( {
	descriptionCell: {
		display: 'block',
		maxWidth: '280px',
		overflow: 'hidden',
		whiteSpace: 'nowrap',
		textOverflow: 'ellipsis',
	},
	shortcodeInput: {
		width: '100%',
		minWidth: '160px',
		fontFamily: tokens.fontFamilyMonospace,
		fontSize: tokens.fontSizeBase200,
		padding: `${ tokens.spacingVerticalXS } ${ tokens.spacingHorizontalSNudge }`,
		boxSizing: 'border-box',
	},
} );
