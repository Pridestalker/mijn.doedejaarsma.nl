module.exports = function (api) {
    api.cache(true);

    // const presets = [ ... ];
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
        // presets,
        plugins
    };
}
