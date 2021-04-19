import svelte from 'rollup-plugin-svelte';
import resolve from '@rollup/plugin-node-resolve';
import babel from 'rollup-plugin-babel';
import commonjs from '@rollup/plugin-commonjs';
import livereload from 'rollup-plugin-livereload';
import { terser } from 'rollup-plugin-terser';
import replace from '@rollup/plugin-replace';

import sveltePreprocess from 'svelte-preprocess'
import { sass, scss, postcss, globalStyle } from 'svelte-preprocess'

const production = (process.env.npm_lifecycle_event === 'prod') ? 'prod' : 'dev'; //process.env.ROLLUP_WATCH;

console.log('Build Command: ' + process.env.npm_lifecycle_event);
console.log('Build Production: ' + production);
console.log('process.env.ROLLUP_WATCH: ' + process.env.ROLLUP_WATCH);

export default {
	input: 'src/lib/js/main.js',
	output: {
		sourcemap: true,
		format: 'iife',
		name: 'app',
		file: 'public/lib/js/bundle.js'
	},
	plugins: [

		replace({
			preventAssignment: true,
			exclude: 'node_modules/**, .vscode, public',

			// 2 level deep object should be stringify
			process: JSON.stringify({
				env: {
					type: production,
					dev: {
						apiRoot: 'https://winery2home.com:8890'
					},
					prod: {
						apiRoot: 'https://winery2home.com'
					}
				}
			}),
		}),

		svelte({
			// enable run-time checks when not in production
			dev: !production,
			// we'll extract any component CSS out into
			// a separate file - better for performance
			css: css => {
				css.write('public/lib/css/bundle.css');
			},
			preprocess: [
				sveltePreprocess({ postcss: true }),
				sass(),
				scss({ sourceMap: true, }),
				postcss(),
				globalStyle(),
			]
		}),

		// If you have external dependencies installed from
		// npm, you'll most likely need these plugins. In
		// some cases you'll need additional configuration -
		// consult the documentation for details:
		// https://github.com/rollup/plugins/tree/master/packages/commonjs
		resolve({
			browser: true,
			dedupe: ['svelte']
		}),

		babel({
			exclude: 'node_modules/**, .vscode', // only transpile our source code,
			externalHelpers: true,
			runtimeHelpers: true 
		}),

		commonjs(),

		// In dev mode, call `npm run start` once
		// the bundle has been generated
		!production && serve(),

		// Watch the `public` directory and refresh the
		// browser on changes when not in production
		!production && livereload('public'),

		// If we're building for production (npm run build
		// instead of npm run dev), minify
		production && terser()

	],
	watch: {
		clearScreen: false
	}
};

function serve() {
	let started = false;

	return {
		writeBundle() {
			if (!started) {
				started = true;

				require('child_process').spawn('npm', ['run', 'start', '--', '--dev'], {
					stdio: ['ignore', 'inherit', 'inherit'],
					shell: true
				});
			}
		}
	};
}
