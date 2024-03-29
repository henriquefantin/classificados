// TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com 
import {
    Validation,
    Input,
    Carousel,
    Ripple,
    Modal,
    initTE,
    // Collapse,
    // Dropdown,
    // initTEW,
} from "tw-elements";

initTE({ Carousel });
initTE({ Validation, Input });
initTE({ Modal, Ripple });
// initTWE({ Collapse, Dropdown });

import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();