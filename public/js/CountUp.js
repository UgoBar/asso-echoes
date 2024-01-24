export class CountUp {
    constructor(target, endVal, options) {
        this.version = '2.8.0';
        this.defaults = {
            startVal: 0,
            decimalPlaces: 0,
            duration: 2,
            useEasing: true,
            useGrouping: true,
            useIndianSeparators: false,
            smartEasingThreshold: 999,
            smartEasingAmount: 333,
            separator: ',',
            decimal: '.',
            prefix: '',
            suffix: '',
            enableScrollSpy: false,
            scrollSpyDelay: 200,
            scrollSpyOnce: false,
        };
        this.rAF = null;
        this.startTime = null;
        this.remaining = null;
        this.finalEndVal = null;
        this.useEasing = true;
        this.countDown = false;
        this.el = null;
        this.formattingFn = (num) => num.toFixed(this.options.decimalPlaces);
        this.easingFn = (t, b, c, d) => c * (-Math.pow(2, -10 * t / d) + 1) * 1024 / 1023 + b;
        this.error = '';
        this.startVal = 0;
        this.duration = 0;
        this.paused = true;
        this.frameVal = 0;
        this.once = false;

        this.options = { ...this.defaults, ...options };
        this.startVal = this.validateValue(this.options.startVal);
        this.frameVal = this.startVal;
        this.endVal = this.validateValue(endVal);
        this.options.decimalPlaces = Math.max(0 || this.options.decimalPlaces);
        this.resetDuration();
        this.options.separator = String(this.options.separator);
        this.useEasing = this.options.useEasing;
        if (this.options.separator === '') {
            this.options.useGrouping = false;
        }
        this.el = (typeof target === 'string') ? document.getElementById(target) : target;
        if (this.el) {
            this.printValue(this.startVal);
        } else {
            this.error = '[CountUp] target is null or undefined';
        }

        if (typeof window !== 'undefined' && this.options.enableScrollSpy) {
            if (!this.error) {
                window['onScrollFns'] = window['onScrollFns'] || [];
                window['onScrollFns'].push(() => this.handleScroll(this));
                window.onscroll = () => {
                    window['onScrollFns'].forEach((fn) => fn());
                };
                this.handleScroll(this);
            } else {
                console.error(this.error, target);
            }
        }
    }

    handleScroll(self) {
        if (!self || !window || self.once) return;
        const bottomOfScroll = window.innerHeight + window.scrollY;
        const rect = self.el.getBoundingClientRect();
        const topOfEl = rect.top + window.pageYOffset;
        const bottomOfEl = rect.top + rect.height + window.pageYOffset;
        if (bottomOfEl < bottomOfScroll && bottomOfEl > window.scrollY && self.paused) {
            self.paused = false;
            setTimeout(() => self.start(), self.options.scrollSpyDelay);
            if (self.options.scrollSpyOnce)
                self.once = true;
        } else if ((window.scrollY > bottomOfEl || topOfEl > bottomOfScroll) && !self.paused) {
            self.reset();
        }
    }

    determineDirectionAndSmartEasing() {
        const end = (this.finalEndVal) ? this.finalEndVal : this.endVal;
        this.countDown = (this.startVal > end);
        const animateAmount = end - this.startVal;
        if (Math.abs(animateAmount) > this.options.smartEasingThreshold && this.options.useEasing) {
            this.finalEndVal = end;
            const up = (this.countDown) ? 1 : -1;
            this.endVal = end + (up * this.options.smartEasingAmount);
            this.duration = this.duration / 2;
        } else {
            this.endVal = end;
            this.finalEndVal = null;
        }
        if (this.finalEndVal !== null) {
            this.useEasing = false;
        } else {
            this.useEasing = this.options.useEasing;
        }
    }

    start(callback) {
        if (this.error) {
            return;
        }
        if (this.options.onStartCallback) {
            this.options.onStartCallback();
        }
        if (callback) {
            this.options.onCompleteCallback = callback;
        }
        if (this.duration > 0) {
            this.determineDirectionAndSmartEasing();
            this.paused = false;
            this.rAF = requestAnimationFrame(this.count);
        } else {
            this.printValue(this.endVal);
        }
    }

    pauseResume() {
        if (!this.paused) {
            cancelAnimationFrame(this.rAF);
        } else {
            this.startTime = null;
            this.duration = this.remaining;
            this.startVal = this.frameVal;
            this.determineDirectionAndSmartEasing();
            this.rAF = requestAnimationFrame(this.count);
        }
        this.paused = !this.paused;
    }

    reset() {
        cancelAnimationFrame(this.rAF);
        this.paused = true;
        this.resetDuration();
        this.startVal = this.validateValue(this.options.startVal);
        this.frameVal = this.startVal;
        this.printValue(this.startVal);
    }

    update(newEndVal) {
        cancelAnimationFrame(this.rAF);
        this.startTime = null;
        this.endVal = this.validateValue(newEndVal);
        if (this.endVal === this.frameVal) {
            return;
        }
        this.startVal = this.frameVal;
        if (this.finalEndVal == null) {
            this.resetDuration();
        }
        this.finalEndVal = null;
        this.determineDirectionAndSmartEasing();
        this.rAF = requestAnimationFrame(this.count);
    }

    count = (timestamp) => {
        if (!this.startTime) { this.startTime = timestamp; }

        const progress = timestamp - this.startTime;
        this.remaining = this.duration - progress;

        if (this.useEasing) {
            if (this.countDown) {
                this.frameVal = this.startVal - this.easingFn(progress, 0, this.startVal - this.endVal, this.duration);
            } else {
                this.frameVal = this.easingFn(progress, this.startVal, this.endVal - this.startVal, this.duration);
            }
        } else {
            this.frameVal = this.startVal + (this.endVal - this.startVal) * (progress / this.duration);
        }

        const wentPast = this.countDown ? this.frameVal < this.endVal : this.frameVal > this.endVal;
        this.frameVal = wentPast ? this.endVal : this.frameVal;

        this.frameVal = Number(this.frameVal.toFixed(this.options.decimalPlaces));

        this.printValue(this.frameVal);

        if (progress < this.duration) {
            this.rAF = requestAnimationFrame(this.count);
        } else if (this.finalEndVal !== null) {
            this.update(this.finalEndVal);
        } else {
            if (this.options.onCompleteCallback) {
                this.options.onCompleteCallback();
            }
        }
    }

    printValue(val) {
        if (!this.el) return;
        const result = this.formattingFn(val);
        if (this.options.plugin?.render) {
            this.options.plugin.render(this.el, result);
            return;
        }
        if (this.el.tagName === 'INPUT') {
            const input = this.el;
            input.value = result;
        } else if (this.el.tagName === 'text' || this.el.tagName === 'tspan') {
            this.el.textContent = result;
        } else {
            this.el.innerHTML = result;
        }
    }

    ensureNumber(n) {
        return (typeof n === 'number' && !isNaN(n));
    }

    validateValue(value) {
        const newValue = Number(value);
        if (!this.ensureNumber(newValue)) {
            this.error = `[CountUp] invalid start or end value: ${value}`;
            return null;
        } else {
            return newValue;
        }
    }

    resetDuration() {
        this.startTime = null;
        this.duration = Number(this.options.duration) * 1000;
        this.remaining = this.duration;
    }
}
