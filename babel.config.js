module.exports = function (api) {
    api.cache(true);

    // const presets = [ ... ];
    const plugins = [
        '@babel/plugin-transform-typescript'
    ];

    return {
        // presets,
        plugins
    };
}
