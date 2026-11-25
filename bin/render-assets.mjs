#!/usr/bin/env node
/**
 * Renders the WordPress.org listing art from bin/assets into .wordpress-org:
 * the icon as SVG with its PNG fallbacks, and the banner at both sizes.
 * Uses the Chrome installed on the machine.
 */
import { copyFileSync, readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright-core';

const source = ( name ) =>
	fileURLToPath( new URL( `./assets/${ name }`, import.meta.url ) );
const out = ( name ) =>
	fileURLToPath( new URL( `../.wordpress-org/${ name }`, import.meta.url ) );

const icon = readFileSync( source( 'icon.svg' ), 'utf8' );
const banner = readFileSync( source( 'banner.html' ), 'utf8' ).replace(
	'{{icon}}',
	() => icon
);
const browser = await chromium.launch( { channel: 'chrome' } );

async function render( name, html, width, height, scale ) {
	const page = await browser.newPage( {
		viewport: { width, height },
		deviceScaleFactor: scale,
	} );
	await page.setContent( html );
	await page.screenshot( { path: out( name ), omitBackground: true } );
	await page.close();
}

const iconPage = `<style>body{margin:0}svg{display:block;width:128px;height:128px}</style>${ icon }`;
await render( 'icon-128x128.png', iconPage, 128, 128, 1 );
await render( 'icon-256x256.png', iconPage, 128, 128, 2 );
await render( 'banner-772x250.png', banner, 772, 250, 1 );
await render( 'banner-1544x500.png', banner, 772, 250, 2 );
copyFileSync( source( 'icon.svg' ), out( 'icon.svg' ) );
await browser.close();
