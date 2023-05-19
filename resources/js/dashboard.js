
import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'

Alpine.plugin(mask)

window.Alpine = Alpine;
Alpine.start();