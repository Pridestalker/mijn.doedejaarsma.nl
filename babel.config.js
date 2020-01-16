module.exports = function (api) {
	api.cache(true);

	const presets = [
			'@babel/preset-env'
	];

	const plugins = [
		'@babel/plugin-transform-typescript',
		[
			"@babel/plugin-proposal-decorators",
			{
					"legacy": true
			}
		],
		"@babel/plugin-proposal-class-properties"
	];

	return {
		presets,
		plugins
	};
}
