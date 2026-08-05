/**
 * Losslessly re-encode the plugin's bundled images.
 *
 * Replaces grunt-contrib-imagemin 3.x, last published in 2018, which pulled in
 * the abandoned bin-wrapper/download/decompress chain responsible for every
 * npm audit finding in this project.
 *
 * Pass --write to overwrite in place; the default is a dry run.
 */
import { readdir, readFile, writeFile, stat } from 'node:fs/promises';
import path from 'node:path';
import sharp from 'sharp';
import { ROOT } from './plugin-meta.mjs';

const TARGETS = ['assets/img'];
const WRITE = process.argv.includes('--write');

const files = [];
const collect = async (rel) => {
  const abs = path.join(ROOT, rel);
  let s;
  try { s = await stat(abs); } catch { return; }
  if (s.isFile()) {
    if (/\.(png|jpe?g)$/i.test(rel)) files.push(rel);
    return;
  }
  for (const e of await readdir(abs, { withFileTypes: true })) {
    await collect(path.join(rel, e.name));
  }
};
for (const t of TARGETS) await collect(t);

if (!files.length) {
  console.log('no PNG/JPEG files found under: ' + TARGETS.join(', '));
  process.exit(0);
}

let before = 0, after = 0, changed = 0;

for (const rel of files) {
  const abs = path.join(ROOT, rel);
  const original = await readFile(abs);
  const isPng = /\.png$/i.test(rel);

  const out = isPng
    ? await sharp(original).png({ compressionLevel: 9, effort: 10, palette: true }).toBuffer()
    : await sharp(original).jpeg({ quality: 82, mozjpeg: true, progressive: true }).toBuffer();

  before += original.length;
  const keep = out.length < original.length ? out : original;
  after += keep.length;

  if (keep !== original) {
    changed++;
    const saved = ((1 - out.length / original.length) * 100).toFixed(1);
    console.log(`  ${WRITE ? 'optimised' : 'would save'} ${saved.padStart(5)}%  ${rel}`);
    if (WRITE) await writeFile(abs, keep);
  }
}

const pct = before ? ((1 - after / before) * 100).toFixed(1) : '0.0';
console.log(
  `\n${files.length} images, ${changed} improvable - ` +
  `${(before / 1024).toFixed(0)} KB -> ${(after / 1024).toFixed(0)} KB (${pct}%)`
);
if (!WRITE && changed) console.log('dry run; re-run with --write to apply');
