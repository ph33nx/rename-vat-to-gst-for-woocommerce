const wordpress = require( '@wordpress/scripts/config/eslint.config.cjs' );

module.exports = [
	...wordpress,
	{
		// Node command line scripts: console is their output, and node:test needs no dependency.
		files: [ 'bin/*.mjs' ],
		rules: { 'no-console': 'off', 'vitest/no-import-node-test': 'off' },
	},
];
