/**
 * React-based "Add New Credential Block" / "Edit Credential Block" form,
 * built with Fluent UI 9 (`@fluentui/react-components`) controls, plus a
 * two-column, drag-and-drop Credentials picker built with Fluent UI cards
 * and `@dnd-kit` — "Selected Credentials" (left) and "Available
 * Credentials" (right).
 *
 * Renders into #credpl-credential-block-form-root (see
 * Credpl_Admin_Blocks::render_edit_page()) and submits as a plain HTML
 * form POST to admin-post.php — the exact same `credpl_save_credential_block`
 * handler the earlier PHP-rendered form (Title field + checkbox list) posted
 * to, so no backend changes were needed to introduce this. On every render,
 * the picker emits hidden `credential_ids[]` inputs reflecting the current
 * selection and order, exactly as `Credpl_Admin_Blocks::save()` already
 * expects.
 *
 * Initial values (including the full credentials list the picker chooses
 * from) come from `window.credplCredentialBlockForm`, localized by PHP.
 */

import { createRoot, createInterpolateElement, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	FluentProvider,
	webLightTheme,
	Field,
	Input,
	Textarea,
	Button,
	Card,
	CardHeader,
	Text,
	Body1,
	Caption1,
	Link,
	type InputOnChangeData,
	type TextareaOnChangeData,
} from '@fluentui/react-components';
import {
	DndContext,
	closestCenter,
	PointerSensor,
	useSensor,
	useSensors,
	useDroppable,
	type DragOverEvent,
	type DragEndEvent,
	type UniqueIdentifier,
} from '@dnd-kit/core';
import {
	SortableContext,
	verticalListSortingStrategy,
	useSortable,
	arrayMove,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import type { Ref } from 'react';
import { useCredentialsBlockStyles } from '../../../styles';

/** One row from `Credpl_Admin_Blocks::prepare_credential_for_js()`. */
interface Credential {
	id: number;
	title?: string;
	issuer?: string;
	badgeMediaUrl?: string;
}

/**
 * The shape PHP's `wp_localize_script( 'credpl-credential-block-form',
 * 'credplCredentialBlockForm', […] )` call sends (see
 * Credpl_Admin_Blocks::enqueue_assets()). `id`/`nonce`/`actionUrl`/`title`/
 * `addCredentialUrl` are top-level scalars, which `wp_localize_script()`
 * stringifies (see the note on this in src/credential.tsx) — typed
 * `string` here for the same reason. `allCredentials`/`selectedIds` are
 * top-level *arrays*, which `WP_Scripts::localize()` skips over (its
 * stringify loop only touches scalar values), so their nested numeric
 * fields survive as real numbers once JSON-decoded — `selectedIds` is
 * still normalized defensively below, matching the same caution the
 * picker used before this file absorbed it.
 */
interface CredentialBlockFormConfig {
	id: string;
	nonce: string;
	actionUrl: string;
	title: string;
	description: string;
	addCredentialUrl: string;
	allCredentials: Credential[];
	selectedIds: Array<string | number>;
}

declare global {
	interface Window {
		credplCredentialBlockForm?: CredentialBlockFormConfig;
	}
}

const config: CredentialBlockFormConfig = window.credplCredentialBlockForm || {
	id: '',
	nonce: '',
	actionUrl: '',
	title: '',
	description: '',
	addCredentialUrl: '',
	allCredentials: [],
	selectedIds: [],
};

/**
 * `wp_localize_script()` stringifies every top-level scalar (see the doc
 * comment on `CredentialBlockFormConfig` above), so `id: 0` arrives as the
 * string `"0"` — truthy, unlike the number `0`. Normalize once, here,
 * rather than trusting raw truthiness of `config.id` anywhere below (the
 * same bug already fixed once in src/credential.tsx).
 */
function toNumber( value: string | undefined ): number {
	return Number( value ) || 0;
}

const initialId = toNumber( config.id );

const allCredentials = Array.isArray( config.allCredentials ) ? config.allCredentials : [];

const initialSelectedIds = Array.isArray( config.selectedIds )
	? config.selectedIds.map( ( id ) => Number( id ) )
	: [];

const credentialsById = new Map<number, Credential>(
	allCredentials.map( ( credential ) => [ Number( credential.id ), credential ] )
);

type ContainerId = 'selected' | 'available';
type Containers = Record<ContainerId, number[]>;

function CredentialCard( { id }: { id: number } ) {
	const credential = credentialsById.get( id );
	const styles = useCredentialsBlockStyles();
	const {
		attributes,
		listeners,
		setNodeRef,
		transform,
		transition,
		isDragging,
	} = useSortable( { id } );

	if ( ! credential ) {
		return null;
	}

	const style = {
		transform: CSS.Transform.toString( transform ),
		transition,
		opacity: isDragging ? 0.5 : 1,
	};

	return (
		<Card
			ref={ setNodeRef as Ref<HTMLDivElement> }
			style={ style }
			className={ styles.card }
			{ ...attributes }
			{ ...listeners }
		>
			<CardHeader
				image={
					credential.badgeMediaUrl ? (
						<img
							src={ credential.badgeMediaUrl }
							alt=""
							width={ 32 }
							height={ 32 }
							style={ { objectFit: 'contain' } }
						/>
					) : undefined
				}
				header={
					<Body1>
						<strong>{ credential.title || __( '(no title)', 'credentials-manager-plugin' ) }</strong>
					</Body1>
				}
				description={ credential.issuer ? <Caption1>{ credential.issuer }</Caption1> : undefined }
			/>
		</Card>
	);
}

function Column( { id, title, items }: { id: ContainerId; title: string; items: number[] } ) {
	const styles = useCredentialsBlockStyles();
	const { setNodeRef } = useDroppable( { id } );

	return (
		<div className={ styles.column }>
			<Text weight="semibold" size={ 400 } className={ styles.columnTitle }>
				{ title }
			</Text>
			<SortableContext id={ id } items={ items } strategy={ verticalListSortingStrategy }>
				<div ref={ setNodeRef } className={ styles.list }>
					{ 0 === items.length && (
						<div className={ styles.emptyHint }>
							{ __( 'Drag credentials here', 'credentials-manager-plugin' ) }
						</div>
					) }
					{ items.map( ( itemId ) => (
						<CredentialCard key={ itemId } id={ itemId } />
					) ) }
				</div>
			</SortableContext>
		</div>
	);
}

/**
 * Which container currently holds this id — `id` may itself be a
 * container id (when dragging over empty space) or an item id (a
 * credential's numeric id, carried by dnd-kit as a `UniqueIdentifier`).
 */
function findContainer( containers: Containers, id: UniqueIdentifier ): ContainerId | undefined {
	if ( 'selected' === id || 'available' === id ) {
		return id;
	}

	const numericId = Number( id );

	return ( Object.keys( containers ) as ContainerId[] ).find(
		( key ) => containers[ key ].includes( numericId )
	);
}

/**
 * The "Selected Credentials" / "Available Credentials" drag-and-drop
 * picker, plus the hidden `credential_ids[]` inputs that carry its
 * current selection/order into the surrounding form's POST.
 */
function CredentialsPicker() {
	const styles = useCredentialsBlockStyles();

	const [ containers, setContainers ] = useState<Containers>( () => {
		const availableIds = allCredentials
			.map( ( credential ) => Number( credential.id ) )
			.filter( ( id ) => ! initialSelectedIds.includes( id ) );

		return {
			selected: initialSelectedIds,
			available: availableIds,
		};
	} );

	const sensors = useSensors(
		useSensor( PointerSensor, { activationConstraint: { distance: 4 } } )
	);

	/**
	 * Live-move an item across columns while dragging, so hovering over
	 * the other column shows it there immediately.
	 */
	function handleDragOver( event: DragOverEvent ) {
		const { active, over } = event;

		if ( ! over ) {
			return;
		}

		const activeContainer = findContainer( containers, active.id );
		const overContainer = findContainer( containers, over.id );

		if ( ! activeContainer || ! overContainer || activeContainer === overContainer ) {
			return;
		}

		const activeId = Number( active.id );
		const overId = Number( over.id );

		setContainers( ( prev ) => {
			const activeItems = prev[ activeContainer ];
			const overItems = prev[ overContainer ];
			const overIndex = overItems.indexOf( overId );

			const insertAt = overIndex >= 0 ? overIndex : overItems.length;

			return {
				...prev,
				[ activeContainer ]: activeItems.filter( ( id ) => id !== activeId ),
				[ overContainer ]: [
					...overItems.slice( 0, insertAt ),
					activeId,
					...overItems.slice( insertAt ),
				],
			};
		} );
	}

	/**
	 * Finalize ordering within a column once the drag ends there.
	 */
	function handleDragEnd( event: DragEndEvent ) {
		const { active, over } = event;

		if ( ! over ) {
			return;
		}

		const activeContainer = findContainer( containers, active.id );
		const overContainer = findContainer( containers, over.id );

		if ( ! activeContainer || activeContainer !== overContainer ) {
			return;
		}

		const activeId = Number( active.id );
		const overId = Number( over.id );

		const items = containers[ activeContainer ];
		const activeIndex = items.indexOf( activeId );
		const overIndex = items.indexOf( overId );

		if ( -1 === activeIndex || -1 === overIndex || activeIndex === overIndex ) {
			return;
		}

		setContainers( ( prev ) => ( {
			...prev,
			[ activeContainer ]: arrayMove( items, activeIndex, overIndex ),
		} ) );
	}

	return (
		<>
			<DndContext
				sensors={ sensors }
				collisionDetection={ closestCenter }
				onDragOver={ handleDragOver }
				onDragEnd={ handleDragEnd }
			>
				<div className={ styles.columns }>
					<Column
						id="selected"
						title={ __( 'Selected Credentials', 'credentials-manager-plugin' ) }
						items={ containers.selected }
					/>
					<Column
						id="available"
						title={ __( 'Available Credentials', 'credentials-manager-plugin' ) }
						items={ containers.available }
					/>
				</div>
			</DndContext>

			{ containers.selected.map( ( id ) => (
				<input key={ id } type="hidden" name="credential_ids[]" value={ id } />
			) ) }

			<Text className={ styles.hint }>
				{ __( 'Drag credentials between the two lists to choose which appear in this block, and drag within "Selected Credentials" to set their order.', 'credentials-manager-plugin' ) }
			</Text>
		</>
	);
}

function CredentialBlockForm() {
	const styles = useCredentialsBlockStyles();

	const [ title, setTitle ] = useState( config.title || '' );
	const [ description, setDescription ] = useState( config.description || '' );

	return (
		<FluentProvider theme={ webLightTheme }>
			<form method="post" action={ config.actionUrl } className={ styles.form }>
				<input type="hidden" name="action" value="credpl_save_credential_block" />
				<input type="hidden" name="id" value={ initialId } />
				<input type="hidden" name="_wpnonce" value={ config.nonce } />

				<Field label={ __( 'Title', 'credentials-manager-plugin' ) } required>
					<Input
						className={ styles.control }
						name="title"
						value={ title }
						onChange={ ( ev, data: InputOnChangeData ) => setTitle( data.value ) }
						required
					/>
				</Field>

				<Field label={ __( 'Description', 'credentials-manager-plugin' ) }>
					<Textarea
						className={ styles.control }
						name="description"
						rows={ 4 }
						value={ description }
						onChange={ ( ev, data: TextareaOnChangeData ) => setDescription( data.value ) }
					/>
				</Field>

				<Field label={ __( 'Credentials', 'credentials-manager-plugin' ) }>
					{ 0 === allCredentials.length ? (
						<Text className={ styles.hint }>
							{ createInterpolateElement(
								__( 'No credentials exist yet. <a>Add one first.</a>', 'credentials-manager-plugin' ),
								{ a: <Link href={ config.addCredentialUrl } /> }
							) }
						</Text>
					) : (
						<CredentialsPicker />
					) }
				</Field>

				<div className={ styles.actions }>
					<Button appearance="primary" type="submit">
						{ initialId
							? __( 'Update Block', 'credentials-manager-plugin' )
							: __( 'Add Block', 'credentials-manager-plugin' ) }
					</Button>
				</div>
			</form>
		</FluentProvider>
	);
}

const root = document.getElementById( 'credpl-credential-block-form-root' );

if ( root ) {
	createRoot( root ).render( <CredentialBlockForm /> );
}
