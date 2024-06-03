import {mount} from '@vue/test-utils'
import {describe, expect, it} from "vitest";
import {nextTick} from "vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";

describe('Button ContextMenuButton', () => {
    const component = mount(ContextMenuButton, {
        props: {
            description: 'Button description',
            icon: 'icon',
            color: 'black',
            iconColor: 'black'
        },
        slots: {
            content: '<div>Menu content</div>'
        }
    })

    it('should render the button with right props and components', async () => {
        expect(component.html()).toMatchSnapshot();
        expect(component.props().description).toBe('Button description');
        expect(component.props().icon).toBe('icon');
        expect(component.props().color).toBe('black');
        expect(component.props().iconColor).toBe('black');

        expect(component.findComponent({name: 'FilterOutlineIcon'}).exists()).toBeTruthy();
    });

    it('should show menu when clicking on button', async () => {
        component.find('button').trigger('click')
        // Refresh component
        await nextTick()
        expect(component.html()).toContain('Menu content');
    });

});
