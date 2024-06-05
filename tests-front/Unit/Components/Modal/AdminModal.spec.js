import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import AdminModal from "@/Components/Modal/AdminModal.vue";
import {nextTick} from "vue";

describe('Modal AdminModal', () => {
    const component = mount(AdminModal, {
        props: {
            title: 'Title'
        }
    });
    it('should render the component with default props', () => {
        expect(component.props().title).toBe('Title');
        expect(component.html()).toContain('Title');
    });

    it('should emit close event when close button is clicked', async () => {
        const closeButton = component.find('.close-icon');
        await closeButton.trigger('click');
        expect(component.emitted()).toHaveProperty('close');
    });

    it('should emit close on keydown esc', async () => {
        const event = new KeyboardEvent('keydown', { key: 'Escape' });
        document.dispatchEvent(event);
        await nextTick();
        expect(component.emitted()).toHaveProperty('close');
    });
});
