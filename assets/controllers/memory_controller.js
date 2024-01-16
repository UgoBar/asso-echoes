import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * memory_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/memory_controller.js';
        if (window.innerWidth < 900) {

            const svg = document.querySelector('.article-svg-animated svg');
            const sectionElement = document.querySelector(".article-svg-animated section p:last-of-type");

            sectionElement.insertBefore(svg, sectionElement.childNodes[0]);
        }
    }
}
