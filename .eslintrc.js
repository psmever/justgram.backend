module.exports = {
	"env": {
		"browser": false,
		"commonjs": true,
		"es2021": true,
		"node": true,
	},
	"extends": [
		"eslint:recommended",
		"plugin:@typescript-eslint/recommended"
	],
	"parser": "@typescript-eslint/parser",
	"parserOptions": {
		"ecmaVersion": 12
	},
	"plugins": [
		"@typescript-eslint"
	],
	"rules": {
		"@typescript-eslint/explicit-function-return-type": "off",
		"@typescript-eslint/no-var-requires": 0,
		"indent": [
			"error",
			"tab"
		],
		"linebreak-style": [
			"error",
			"unix"
		],
		"quotes": [
			"error",
			"double"
		],
		"semi": [
			"error",
			"always"
		]
	}
};
