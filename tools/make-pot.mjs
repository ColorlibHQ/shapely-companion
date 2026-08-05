/**
 * Regenerate languages/shapely-companion.pot.
 *
 * The Gruntfile had no makepot task at all, so the bundled POT was last
 * generated in December 2016 and still referenced files that no longer exist.
 * It was also named shapely.pot, which does not match this plugin's
 * shapely-companion text domain.
 *
 * Uses WP-CLI's `wp i18n make-pot`, the tool WordPress.org itself uses.
 * WP-CLI is not an npm package, so it is invoked from PATH.
 * Install: https://wp-cli.org/#installing
 */
import { execFile } from 'node:child_process';
import { promisify } from 'node:util';
import { readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';
import { ROOT, TEXT_DOMAIN, pluginVersion, pluginHeader } from './plugin-meta.mjs';

const run = promisify(execFile);
const DEST = path.join(ROOT, 'languages', `${TEXT_DOMAIN}.pot`);

const version = await pluginVersion();
const name = await pluginHeader('Plugin Name');

try {
  await run('wp', ['--version']);
} catch {
  console.error(
    'WP-CLI not found on PATH.\n' +
    `languages/${TEXT_DOMAIN}.pot is generated with \`wp i18n make-pot\`.\n` +
    'Install WP-CLI: https://wp-cli.org/#installing'
  );
  process.exit(1);
}

const args = [
  'i18n', 'make-pot', ROOT, DEST,
  `--domain=${TEXT_DOMAIN}`,
  `--package-name=${name} ${version}`.trim(),
  '--exclude=node_modules,vendor,build,tools,.github',
  '--headers=' + JSON.stringify({
    'Report-Msgid-Bugs-To': 'https://www.colorlib.com/',
    'Last-Translator': 'Colorlib <office@colorlib.com>',
    'Language-Team': 'Colorlib <office@colorlib.com>',
  }),
  '--allow-root',
];

const { stdout, stderr } = await run('wp', args, { cwd: ROOT, maxBuffer: 32 * 1024 * 1024 });
if (stderr.trim()) console.error(stderr.trim());
if (stdout.trim()) console.log(stdout.trim());

const pot = await readFile(DEST, 'utf8');
if (pot.includes('\r\n')) await writeFile(DEST, pot.replace(/\r\n/g, '\n'), 'utf8');

const strings = (pot.match(/^msgid /gm) || []).length - 1; // minus the header entry
console.log(`languages/${TEXT_DOMAIN}.pot - ${strings} translatable strings (package: ${name} ${version})`);
