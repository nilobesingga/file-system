import './bootstrap';
import 'dropzone/dist/dropzone.css';
// import { pdfjsLib } from 'pdfjs-dist/build/pdf';
import Dropzone from 'dropzone';
import Alpine from 'alpinejs';
window.Dropzone = Dropzone;
window.Alpine = Alpine;
// window.pdfjsLib = pdfjsLib;
Alpine.start();
