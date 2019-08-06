import Component from 'ShopUi/models/component';
import OverlayBlock from '../../atoms/overlay-block/overlay-block';

export default class NavigationMultilevel extends Component {
    readonly overlay: OverlayBlock;
    readonly triggers: HTMLElement[];
    readonly touchTriggers: HTMLElement[];
    readonly targets: HTMLElement[];

    constructor() {
        super();
        this.overlay = <OverlayBlock>document.querySelector(this.overlaySelector);
        this.triggers = <HTMLElement[]>Array.from(this.querySelectorAll(this.trigerSelector));
        this.touchTriggers = <HTMLElement[]>Array.from(this.querySelectorAll(this.touchSelector));
        this.targets = <HTMLElement[]>Array.from(document.querySelectorAll(this.targetSelector));
    }

    protected readyCallback(): void {
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.triggers.forEach((trigger: HTMLElement) => {
            trigger.addEventListener('mouseover', (event: Event) => this.onTriggerOver(event));
        });
        this.triggers.forEach((trigger: HTMLElement) => {
            trigger.addEventListener('mouseout', (event: Event) => this.onTriggerOut(event));
        });
        this.touchTriggers.forEach((trigger: HTMLElement) => {
            trigger.addEventListener('click', (event: Event) => this.onTriggerClick(event));
        });
    }

    protected onTriggerOver(event: Event): void {
        if (this.isWidthMoreThanAvailableBreakpoint()) {
            const trigger = <HTMLElement>event.currentTarget;
            event.preventDefault();
            this.overlay.showOverlay();
            this.addClass(trigger);
        }
    }

    protected onTriggerOut(event: Event): void {
        if (this.isWidthMoreThanAvailableBreakpoint()) {
            const trigger = <HTMLElement>event.currentTarget;
            event.preventDefault();
            this.overlay.hideOverlay();
            this.removeClass(trigger);
        }
    }

    protected addClass(trigger: HTMLElement): void {
        const dropItem = <HTMLElement>trigger.getElementsByClassName(this.multiLevelDropItemClass)[0];
        const reverseClass = this.isDropMenuReverse(trigger, dropItem) ? this.classToToggleReverse : '';

        trigger.classList.add(this.classToToggle, reverseClass);
    }

    protected removeClass(trigger: HTMLElement): void {
        trigger.classList.remove(this.classToToggle, this.classToToggleReverse);
    }

    protected onTriggerClick(event: Event): void {
        if (!this.isWidthMoreThanAvailableBreakpoint()) {
            const trigger = <HTMLElement>event.currentTarget;
            const contentToShowSelector = this.getDataAttribute(trigger, 'data-toggle-target');
            const contentToggleClass = this.getDataAttribute(trigger, 'data-class-to-toggle');
            const closestParentNode = trigger.closest(`.${this.jsName}__item`);
            const contentToShow = closestParentNode.querySelector(contentToShowSelector);

            contentToShow.classList.toggle(contentToggleClass);
            trigger.classList.toggle('is-active');
        }
    }

    protected isDropMenuReverse(trigger: HTMLElement, dropItem: HTMLElement): boolean {
        const leftPositionToTheMenuItem = trigger.offsetLeft;
        const windowWidth = window.innerWidth;
        const dropItemWidth = dropItem.offsetWidth;

        return windowWidth - leftPositionToTheMenuItem < dropItemWidth;
    }

    protected isWidthMoreThanAvailableBreakpoint(): boolean {
        return window.innerWidth >= this.availableBreakpoint;
    }

    protected getDataAttribute(block: HTMLElement, attr: string): string {
        return block.getAttribute(attr);
    }

    get targetSelector(): string {
        return this.getAttribute('target-selector');
    }

    get classToToggle(): string {
        return this.getAttribute('class-to-toggle');
    }

    get classToToggleReverse(): string {
        return `${this.classToToggle}--reverse`;
    }

    get availableBreakpoint(): number {
        return Number(this.getAttribute('available-breakpoint'));
    }

    get multiLevelDropItemClass(): string {
        return `${this.jsName}__wrapper`;
    }

    get overlaySelector(): string {
        return '.js-overlay-block';
    }

    get trigerSelector(): string {
        return `.${this.jsName}__trigger`;
    }

    get touchSelector(): string {
        return `.${this.jsName}__touch-trigger`;
    }
}
