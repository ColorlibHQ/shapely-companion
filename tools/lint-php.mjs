/**
 * Syntax-check every PHP file with the local php binary.
 *
 * Kept in Node so `npm run lint:php` behaves the same everywhere and a failure
 * actually fails the script -- the old Travis pipeline swallowed the exit code.
 */
import { readdir } from 'node:fs/promises';
import { execFile } from 'node:child_process';
import { promisify } from 'node:util';
import path from 'node:path';
import { ROOT } from './plugin-meta.mjs';

const run = promisify(execFile);
const SKIP = /^(node_modules|vendor|build|\.git)(\/|$)/;

const files = [];
const walk = async (dir, base = '') => {
  for (const e of await readdir(dir, { withFileTypes: true })) {
    const rel = base ? `${base}/${e.name}` : e.name;
    if (SKIP.test(rel)) continue;
    const abs = path.join(dir, e.name);
    if (e.isDirectory()) await walk(abs, rel);
    else if (e.isFile() && e.name.endsWith('.php')) files.push([abs, rel]);
  }
};
await walk(ROOT);

let failed = 0;
await Promise.all(files.map(async ([abs, rel]) => {
  try {
    const { stdout, stderr } = await run('php', ['-d', 'error_reporting=E_ALL', '-l', abs]);
    const noise = (stdout + stderr).split('\n').filter((l) => l && !l.startsWith('No syntax errors'));
    if (noise.length) {
      failed++;
      console.error(`  x ${rel}`);
      noise.forEach((l) => console.error('      ' + l.trim()));
    }
  } catch (err) {
    failed++;
    console.error(`  x ${rel}\n      ${(err.stdout || err.message).trim()}`);
  }
}));

console.log(`php -l: ${files.length} files, ${failed} with problems`);
if (failed) process.exit(1);
