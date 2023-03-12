import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from "@alpinejs/intersect";
import Tooltip from "@ryangjchandler/alpine-tooltip";

Alpine.plugin(persist);
Alpine.plugin(intersect);
Alpine.plugin(Tooltip);
window.Alpine = Alpine;

Alpine.start();
