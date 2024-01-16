import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        if (window.innerWidth < 900) {

            const svg = document.querySelector('.article-svg-animated svg');
            const firstParagraph = document.querySelector(".article-svg-animated section p:first-of-type");

            firstParagraph.after(svg);
        }
    }
}
