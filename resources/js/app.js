import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery';
import * as bootstrap from 'bootstrap';


window.$ = window.jQuery = $; // เพื่อให้สามารถใช้ $ ใน Global Scope ได้
window.Alpine = Alpine;
Alpine.start();
