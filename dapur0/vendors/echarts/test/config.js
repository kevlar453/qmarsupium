require.config({
    paths: {
        'geoJson': '../geoData/geoJson',
        'theme': '/dapur0/vendors/echarts/theme',
        'data': '/dapur0/vendors/echarts/test/data',
        'map': '/dapur0/vendors/echarts/map',
        'extension': '/dapur0/vendors/echarts/extension'
    },
    packages: [
        {
            main: '/dapur0/vendors/echarts',
            location: '../src',
            name: 'echarts'
        },
        {
            main: '/zrender',
            location: '/dapur0/vendors/zrender/src',
            name: 'zrender'
        }
    ]
    // urlArgs: '_v_=' + +new Date()
});
