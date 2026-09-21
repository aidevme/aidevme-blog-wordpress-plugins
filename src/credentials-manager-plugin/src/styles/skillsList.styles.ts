import { makeStyles } from '@fluentui/react-components';

export const useSkillsListStyles = makeStyles( {
	descriptionCell: {
		display: 'block',
		maxWidth: '420px',
		overflow: 'hidden',
		whiteSpace: 'nowrap',
		textOverflow: 'ellipsis',
	},
} );
