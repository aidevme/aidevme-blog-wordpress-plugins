import { makeStyles, tokens } from '@fluentui/react-components';

export const useCredentialsManagerPageStyles = makeStyles( {
	sections: {
		display: 'flex',
		flexDirection: 'column',
		gap: tokens.spacingVerticalL,
		marginTop: tokens.spacingVerticalM,
	},
	section: {
		// A block-level Card already fills its container; stated explicitly
		// so the "full width" requirement doesn't depend on that default.
		width: '100%',
		boxSizing: 'border-box',
	},
	grid: {
		display: 'grid',
		// 280px is wide enough that "Microsoft Certifications" doesn't wrap;
		// min( …, 100% ) stops a very narrow container from overflowing.
		gridTemplateColumns: 'repeat( auto-fill, minmax( min( 280px, 100% ), 1fr ) )',
		gap: tokens.spacingHorizontalL,
	},
	empty: {
		color: tokens.colorNeutralForeground3,
	},
	card: {
		cursor: 'pointer',
		transitionProperty: 'transform, box-shadow',
		transitionDuration: tokens.durationNormal,
		transitionTimingFunction: tokens.curveEasyEase,
		':hover': {
			transform: 'translateY( -4px )',
			boxShadow: tokens.shadow16,
		},
		// Fluent draws a Card's border on its ::after pseudo-element, not on
		// the element itself, so that's what has to be recoloured on hover.
		':hover::after': {
			borderTopColor: tokens.colorBrandStroke1,
			borderRightColor: tokens.colorBrandStroke1,
			borderBottomColor: tokens.colorBrandStroke1,
			borderLeftColor: tokens.colorBrandStroke1,
		},
		'@media (prefers-reduced-motion: reduce)': {
			transitionDuration: '0.01ms',
			':hover': {
				transform: 'none',
			},
		},
	},
	icon: {
		fontSize: '32px',
		color: tokens.colorBrandForeground1,
	},
} );
