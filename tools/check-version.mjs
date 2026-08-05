/**
 * Fail the build when the version is not the same in all three places.
 *
 * package.json sat at 1.2.3 while the plugin shipped 1.2.10 -- eight releases
 * of drift, because nothing ever checked.
 */
import { readFile } from 'node:fs/promises';
import path from 'node:path';
import { ROOT, pluginVersion } from './plugin-meta.mjs';

const header = await pluginVersion();
const pkg = JSON.parse(await readFile(path.join(ROOT, 'package.json'), 'utf8')).version;
const readme = (await readFile(path.join(ROOT, 'readme.txt'), 'utf8'))
  .match(/^Stable tag:\s*(.+)$/m)?.[1].trim() ?? '';

const rows = [
  ['shapely-companion.php  Version', header],
  ['readme.txt             Stable tag', readme],
  ['package.json           version', pkg],
];
rows.forEach(([label, v]) => console.log(`  ${label.padEnd(36)} ${v || '(missing)'}`));

const unique = [...new Set(rows.map(([, v]) => v))];
if (unique.length !== 1 || !unique[0]) {
  console.error(`\n  version mismatch: ${unique.join(' / ')}`);
  process.exit(1);
}
console.log(`\n  versions agree: ${header}`);
