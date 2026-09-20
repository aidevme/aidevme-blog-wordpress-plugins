/**
 * A generic Fluent UI 9 table footer — not specific to any one entity or
 * table. Shows the total number of records and how many are currently
 * selected, both on the same line. Callers own counting; this component
 * only renders the two labels.
 */

import { sprintf, __ } from '@wordpress/i18n';
import { Text } from '@fluentui/react-components';
import { useTableFooterStyles } from '../../styles';

export interface TableFooterProps {
	recordCount: number;
	selectedCount: number;
}

export function TableFooter( { recordCount, selectedCount }: TableFooterProps ) {
	const styles = useTableFooterStyles();

	return (
		<div className={ styles.root }>
			<Text size={ 200 }>
				{ sprintf( __( 'Number of Records: %d', 'credentials-manager-plugin' ), recordCount ) }
			</Text>
			<Text size={ 200 }>
				{ sprintf( __( 'Number of Selected Records: %d', 'credentials-manager-plugin' ), selectedCount ) }
			</Text>
		</div>
	);
}
