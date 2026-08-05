/**
 * Build the distributable plugin archive.
 *
 * Replaces the grunt clean -> copy -> compress -> clean chain, streaming
 * straight into the zip so there is no intermediate build/ directory to clean
 * up afterwards.
 *
 * Everything is denied by default: a file ships only if EXCLUDE does not match
 * it. The grunt copy task listed exclusions instead, and its list still named
 * "shapely.zip" -- this plugin builds shapely-companion.zip, so its own
 * previous artefact was never actually excluded.
 */
import { createWriteStream } from 'node:fs';
import { readdir, rm, stat } from 'node:fs/promises';
import path from 'node:path';
import { ZipArchive } from 'archiver';
import { ROOT, SLUG, pluginVersion } from './plugin-meta.mjs';

const EXCLUDE = [
  /^\.git(\/|$)/,
  /^\.github(\/|$)/,
  /^node_modules(\/|$)/,
  /^vendor(\/|$)/,
  /^build(\/|$)/,
  /^tools(\/|$)/,
  /^nbproject(\/|$)/,
  /(^|\/)\.DS_Store$/,
  /\.map$/,
  /\.zip$/,
  /(^|\/)package(-lock)?\.json$/,
  /(^|\/)composer\.(json|lock)$/,
  /(^|\/)Gruntfile\.js$/,
  /(^|\/)eslint\.config\.mjs$/,
  /(^|\/)\.stylelintrc\.json$/,
  /(^|\/)\.jshintrc$/,
  /(^|\/)\.jscsrc$/,
  /(^|\/)\.jshintignore$/,
  /(^|\/)\.editorconfig$/,
  /(^|\/)\.gitignore$/,
  /(^|\/)\.gitattributes$/,
  /(^|\/)\.travis\.yml$/,
  /(^|\/)\.nvmrc$/,
  /(^|\/)phpcs\.ruleset\.xml$/,
  /(^|\/)set_tags\.sh$/,
  /(^|\/)README\.md$/i,
  /(^|\/)CONTRIBUTING\.md$/i,
  /(^|\/)CLAUDE\.md$/,
];

const isExcluded = (rel) => EXCLUDE.some((re) => re.test(rel));

const version = await pluginVersion();
const outFile = path.join(ROOT, `${SLUG}.zip`);
await rm(outFile, { force: true });

const output = createWriteStream(outFile);
const archive = new ZipArchive({ zlib: { level: 9 } });

const closed = new Promise((resolve, reject) => {
  output.on('close', resolve);
  output.on('error', reject);
  archive.on('error', reject);
  archive.on('warning', (err) => {
    if (err.code === 'ENOENT') console.warn('  warning:', err.message);
    else reject(err);
  });
});

archive.pipe(output);

let files = 0;
const walk = async (dir, base = '') => {
  const entries = await readdir(dir, { withFileTypes: true });
  entries.sort((a, b) => a.name.localeCompare(b.name));
  for (const entry of entries) {
    const rel = base ? `${base}/${entry.name}` : entry.name;
    if (isExcluded(rel)) continue;
    const abs = path.join(dir, entry.name);
    if (entry.isDirectory()) await walk(abs, rel);
    else if (entry.isFile()) {
      // WordPress expects the plugin nested under a directory named for the slug.
      archive.file(abs, { name: `${SLUG}/${rel}` });
      files += 1;
    }
  }
};

await walk(ROOT);
await archive.finalize();
await closed;

const { size } = await stat(outFile);
console.log(`${SLUG}.zip - ${files} files, ${(size / 1024 / 1024).toFixed(2)} MB (plugin version ${version})`);
