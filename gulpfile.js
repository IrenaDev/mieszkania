/* eslint-disable no-console */
// ***
// Global Packages & Options
// ***
const glob = require('glob');
const getArguments = require('./env/getArguments');

require('dotenv').config();

getArguments.parse();

const dist = 'web';

const appArguments = getArguments();
const production = !!appArguments.production;

const requireNoCache = module => {
	delete require.cache[require.resolve(module)];
	return require(module);
};

// ***
// Gulp Styles Tasks
// ***
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const wait = require('gulp-wait');
const sourcemaps = require('gulp-sourcemaps');

const sassFunc = src => {
	return gulp.src(...src)
		.pipe(wait(100))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				outputStyle: production ? 'compressed' : 'expanded',
				includePaths: glob.sync(`./${dist}/app/themes/**/css/`),
			}).on('error', sass.logError)
		)
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./'));
};

// gulp.task(`sass:all`, () => {
//     const argsArr = [[`${dist}/app/themes/**/*.{sass,scss}`], {base: './'}];

//     return sassFunc(argsArr);
// });

// gulp.task(`sass:assets`, () => {
//     const argsArr = [[`${dist}/app/themes/*/assets/css/**/*.{sass,scss}`], {base: './'}];

//     return sassFunc(argsArr);
// });

// gulp.task('sass:all:watch', () => {
//     gulp.watch(`${dist}/app/themes/*/assets/css/**/*.{sass,scss}`, gulp.task('sass:assets'));

//     gulp.watch(`${dist}/app/themes/**/*.{sass,scss}`).on('change', function(path, stats) {
//         console.info(`change: ${path}`);
//         sassFunc([path]);
//     });
// });


// Default watch on all files:
gulp.task('sass:all', () => {
	const argsArr = [[`${dist}/app/themes/**/*.{sass,scss}`], { base: './' }];

	return sassFunc(argsArr);
});

gulp.task('sass:all:watch', () => {
	gulp.watch(`${dist}/app/themes/**/*.{sass,scss}`, gulp.task('sass:all'));
});

gulp.task('sass:prod', () => {
	return gulp.src([`${dist}/app/themes/**/*.{sass,scss}`], { base: './' })
		.pipe(wait(100)).pipe(
			sass({
				outputStyle: 'compressed',
				includePaths: glob.sync(`./${dist}/app/themes/**/css/`),
			}).on('error', sass.logError)
		)
		.pipe(gulp.dest('./'));
});

// ***
// Gulp & Webpack JS Tasks
// ***
const webpack = require('webpack');
const path = require('path');
const through = require('through2');
const fs = require('fs');

gulp.task('clean-bundles', () => {
	return gulp.src(`${dist}/app/themes/**/bundle*.js`).pipe(
		through.obj((chunk, enc, cb) => {
			fs.unlinkSync(chunk.path);
			cb(null, chunk);
		})
	);
});

const compileWebpack = (configName, name, cb, mode) => {
	if (!fs.existsSync(`${configName}.js`)) {
		cb();
		return;
	}
	const config = requireNoCache(configName);
	if (!config) {
		cb();
		return;
	}
	if (mode) {
		config.mode = 'production';
	}
	console.info(`\n[webpack][${name}]\n`);
	webpack(config, (err, stats) => {
		console.info(
			stats.toString({
				chunks: false,
				colors: true,
			})
		);
		cb();
	});
};

gulp.task('scripts:default', cb => {
	compileWebpack('./webpack.config', 'default', cb, production);
});
gulp.task('scripts:prod', cb => {
	compileWebpack('./webpack.config', 'default', cb, true);
});
gulp.task('scripts:gutenberg', cb => {
	compileWebpack('./webpack.config.gutenberg', 'gutenberg', cb);
});

gulp.task('scripts', gulp.series('scripts:default', 'scripts:gutenberg'));

const compileOnWatch = compiler => {
	const watchIsCompiling = cb => {
		compiler.run((_error, stats) => {
			console.info(
				stats.toString({
					colors: true,
				})
			);
			console.info();
			cb();
		});
	};

	return watchIsCompiling;
};

// ***
// Gulp Watch & BrowserSync Tasks
// ***
const browserSync = require('browser-sync');

gulp.task('scripts:watch:browsers', () => {
	const config = requireNoCache('./webpack.config.js');
	const compiler = webpack(config);
	return gulp.watch(`${dist}/app/themes/**/*.js`, compileOnWatch(compiler));
});

gulp.task('scripts:watch:gutenberg', () => {
	if (!fs.existsSync('webpack.config.gutenberg.js')) {
		return;
	}
	const config = requireNoCache('./webpack.config.gutenberg.js');
	if (!config) {
		return;
	}
	const compiler = webpack(config);
	return gulp.watch(`${dist}/app/themes/**/*.js`, compileOnWatch(compiler));
});

gulp.task(
	'scripts:watch',
	gulp.parallel('scripts:watch:browsers', 'scripts:watch:gutenberg')
);

gulp.task('browsersync', () => {
	return browserSync({
		files: [
			{
				match: `${dist}/**/*.*`,
			},
		],
		ignore: [`${dist}/app/uploads/*`],
		watchEvents: ['change', 'add'],
		codeSync: true,
		logFileChanges: false,
		proxy: process.env.APP_URL,
		snippetOptions: {
			ignorePaths: ['*/wp/wp-admin/**'],
		},
	});
});

gulp.task(
	'watch',
	gulp.parallel('sass:all:watch',  'scripts:watch', 'browsersync')
);

// ***
// Gulp Tasks
// ***
const zip = require('gulp-zip');
const wpcli = require('./env/wpcli');

gulp.task('build', gulp.series('sass:all', 'clean-bundles', 'scripts'));


gulp.task('pack', () => {
	return gulp.src([
		'web/app/**',
		'!web/app/mu-plugins/**',
		'!web/app/mu-plugins',
		'!web/app/uploads-test/**',
		'!web/app/uploads-test',
		'db/db.sql',
	], { 'allowEmpty': true }).pipe(zip('pack.zip')).pipe(gulp.dest(dist));
});

gulp.task('pack-auto', () => {
	return gulp.src([
		'web/app/**',
		'!web/app/mu-plugins/**',
		'!web/app/mu-plugins',
		'!web/app/uploads-test/**',
		'!web/app/uploads-test',
	]).pipe(gulp.dest('./dist'));
});

gulp.task('files', gulp.series('sass:prod', 'scripts:prod', 'pack'));

gulp.task('files-auto', gulp.series('sass:prod', 'scripts:prod', 'pack-auto'));

gulp.task('db:export', cb => {
	let exportName = appArguments.file || 'db';
	const dateSuffix = !!appArguments.timestamp;
	if (dateSuffix) {
		exportName = `${exportName}-${Date.now()}`;
	}
	const removeWp = !!appArguments['no-wp'];
	const replaceWith = appArguments.url || '<-- HOST_URL -->';
	const filePath = `db/${exportName}.sql`;
	if (removeWp) {
		const replace = `${process.env.APP_URL}(/wp)?`;
		wpcli('search-replace', [
			`"${replace}"`,
			`"${replaceWith}"`,
			`--export=${filePath}`,
			'--regex',
			'--all-tables',
			'--precise',
			'--report-changed-only',
		]);
	} else {
		const replace = process.env.APP_URL;
		wpcli('search-replace', [
			`"${replace}"`,
			`"${replaceWith}"`,
			`--export=${filePath}`,
			'--all-tables',
			'--precise',
			'--report-changed-only',
		]);
	}
	const sqlContent = fs.readFileSync(filePath);
	const prependSql = '/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\' */;';
	const appendSql = '/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;';
	fs.writeFileSync(filePath, `${prependSql}\n${sqlContent}\n${appendSql}`);
	cb();
});

gulp.task('db:import', cb => {
	const fileName = appArguments.file || 'db';
	if (!fs.existsSync(path.resolve(__dirname, `db/${fileName}.sql`))) {
		cb();
		return;
	}
	wpcli('db', ['import', `db/${fileName}.sql`]);
	wpcli('search-replace', [
		'"<-- HOST_URL -->"',
		`"${process.env.APP_URL}"`,
		'--all-tables',
		'--precise',
		'--report-changed-only',
	]);
	cb();
});

const installWordpress = cb => {
	wpcli('db', ['create']);
	wpcli('core', [
		'install',
		`--url="${process.env.APP_URL}"`,
		'--title="Theme Title"',
		'--admin_user=developers',
		'--admin_email="developers@example.com"',
		'--admin_password="zxc$%^#@!ewq"',
	]);
	wpcli('rewrite', ['flush']);
	cb();
};

gulp.task('wp-install', installWordpress);

gulp.task('wp-flush', cb => {
	wpcli('rewrite', ['flush', '--hard']);
	cb();
});

gulp.task('wp-regen', cb => {
	wpcli('media', ['regenerate', '--yes']);
	cb();
});

gulp.task('install', installWordpress);
gulp.task('default', gulp.series('build', 'watch'));

gulp.task('generate-post', cb => {
	wpcli('post', [
		'generate',
		'--prompt',
	]);
	cb();
});