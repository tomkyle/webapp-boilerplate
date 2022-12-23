module.exports = {
    swSrc: 'scripts/serviceworker.js',

    swDest: 'public/assets/serviceworker.js',

	globDirectory: 'public/assets/',

	globPatterns: [
		'**/*.{mjs,txt,css,ico,jpg,png,svg,svgz,woff,woff2}',
        '../favicons/*.{mjs,txt,css,ico,jpg,png,svg,svgz,woff,woff2}'
	],

    additionalManifestEntries: [
        { url: '/manifest.webmanifest', revision: "hallo" },
        { url: '/favicon.ico', revision: "hallo" }
    ]
};
