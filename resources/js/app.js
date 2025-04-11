import './bootstrap';
import 'dropzone/dist/dropzone.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
// import Choices from 'choices.js';
// import { pdfjsLib } from 'pdfjs-dist/build/pdf';
import Dropzone from 'dropzone';
import Alpine from 'alpinejs';
window.Dropzone = Dropzone;
window.Alpine = Alpine;
// window.pdfjsLib = pdfjsLib;
Alpine.start();



// // Initialize Choices.js on the month select
// document.addEventListener('DOMContentLoaded', () => {
//     const monthSelect = document.getElementById('month');
//     if (monthSelect) {
//         new Choices(monthSelect, {
//             removeItemButton: true,
//             placeholderValue: 'Select months',
//             noChoicesText: 'No months available',
//             shouldSort: false,
//         });
//     }
// });
