import Alpine from 'alpinejs';
import { registerComponents } from './alpine/components';
import { registerTheme } from './theme';

registerTheme(Alpine);
registerComponents(Alpine);

window.Alpine = Alpine;

Alpine.start();
