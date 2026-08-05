/**
 * Shared helpers: the plugin's slug, version and paths.
 *
 * shapely-companion.php is the single source of truth for the version -- it is
 * the only place WordPress reads it from. readme.txt's "Stable tag" and
 * package.json are mirrors, and check-version.mjs enforces that they agree.
 */
import { readFile } from 'node:fs/promises';
import path from 'node:path';

export const ROOT = path.resolve(import.meta.dirname, '..');
export const SLUG = 'shapely-companion';
export const TEXT_DOMAIN = 'shapely-companion';
export const MAIN_FILE = path.join(ROOT, `${SLUG}.php`);

/** Read a header field out of the main plugin file. */
export async function pluginHeader(field) {
  const src = await readFile(MAIN_FILE, 'utf8');
  const re = new RegExp(`^\\s*\\*\\s*${field}\\s*:\\s*(.+)$`, 'm');
  return src.match(re)?.[1].trim() ?? '';
}

export async function pluginVersion() {
  return pluginHeader('Version');
}
