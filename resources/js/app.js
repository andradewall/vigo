import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'
import $ from 'jquery';

window.$ = $;

window.Alpine = Alpine;

Alpine.plugin(mask);
Alpine.start();
