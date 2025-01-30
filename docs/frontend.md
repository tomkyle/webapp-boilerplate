
**[Back to Index](index.md)**

---

# Frontend development

## Gulp and Webpack

The `npx` command will use *local* or *global* Gulp CLI. Watch file changes and build assets like so:

```bash
$ npx gulp watch
$ NODE_ENV=production npx gulp watch
```

## Development builds

```bash
$ npm run dev
# Alias for
$ npx gulp && npx workbox-cli injectManifest
```

## Production builds

```bash
$ npm run build
# Alias for
$ NODE_ENV=production npx gulp && NODE_ENV=production npx workbox-cli injectManifest
```


## Building Favicons

This feature uses [svgexport](https://www.npmjs.com/package/svgexport) and [imagemagick's](https://www.npmjs.com/package/imagemagick) convert to create various PNG favicons and a traditional ICO file.

1. Put a new SVG favicon `favicon.svg` into the **public/favicons** directory
2. Run build script to create several **PNG favicons** as well as a **favicon.ico** file:

```bash
$ bin/favicons
```
