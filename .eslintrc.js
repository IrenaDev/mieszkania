module.exports = {
	root: true,
	extends: ['eslint:recommended'],
	parser: '@babel/eslint-parser',
	globals: {
		wp: true,
	},
	env: {
		node: true,
		es6: true,
		amd: true,
		browser: true,
		jquery: true,
	},
	parserOptions: {
		ecmaFeatures: {
			globalReturn: true,
			jsx: true,
		},
		ecmaVersion: 'latest',
		requireConfigFile: false,
		babelOptions: {
			babelrc: false,
			configFile: false,
			// your babel options
			presets: ['@babel/preset-env', '@babel/preset-react'],
		},
		sourceType: 'module',
	},
	plugins: ['jsx-a11y'],
	rules: {
		'no-console': 1,
		'no-var': 2,
		'no-undef': 2,
		'no-iterator': 2,
		'no-restricted-syntax': 2,
		'no-plusplus': 1,
		'no-multi-assign': 2,
		'no-mixed-operators': 2,
		'no-unneeded-ternary': 2,
		'no-nested-ternary': 2,
		'no-case-declarations': 2,
		'no-eval': 2,
		'no-new-func': 2,
		'no-param-reassign': 2,
		'no-useless-escape': 2,
		'no-loop-func': 2,
		'no-else-return': 1,
		'no-confusing-arrow': 2,
		'no-useless-constructor': 2,
		'no-dupe-class-members': 2,
		'no-duplicate-imports': 2,
		'no-new-object': 2,
		'no-array-constructor': 2,
		'id-length': 1,
		'semi': 2,
		'brace-style': 2,
		'dot-notation': 2,
		'object-shorthand': 2,
		'prefer-const': 2,
		'prefer-rest-params': 2,
		'prefer-arrow-callback': 2,
		'prefer-destructuring': 2,
		'prefer-spread': 2,
		'prefer-template': 2,
		'template-curly-spacing': 2,
		'arrow-parens': ['error', 'as-needed'],
		'arrow-spacing': 2,
		'camelcase': 2,
		'new-cap': 2,
		'space-infix-ops': 2,
		'space-before-blocks': 2,
		'space-before-function-paren': 2,
		'keyword-spacing': ['error', { 'before': true }],
		'quotes': ['error', 'single'],
		'operator-linebreak': ['error', 'none'],
		'nonblock-statement-body-position': ['error', 'beside'],
		'func-style': ['warn', 'expression'],
		'spaced-comment': ['error', 'always'],
		'one-var': ['error', 'never'],
		'object-curly-spacing': ['error', 'always'],
		'array-bracket-spacing': ['error', 'never'],
		'space-in-parens': ['error', 'never'],
		'padded-blocks': ['error', 'never'],
		'indent': ['error', 'tab'],
		'comma-dangle': [
			'error',
			{
				arrays: 'always-multiline',
				objects: 'always-multiline',
				imports: 'always-multiline',
				exports: 'always-multiline',
			},
		],
	},
};