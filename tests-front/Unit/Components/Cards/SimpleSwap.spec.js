import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import SimpleSwap from "@/Components/Cards/SimpleSwap.vue";
import {nextTick} from "vue";

describe('Cards SimpleSwap', () => {
    const component = mount(SimpleSwap, {
        props: {
            swap: {
                name: 'Swap Name',
                image: 'swap-image.jpg',
            },
            actions: {
                actionOne: 'Action One',
                actionTwo: 'Action Two',
            }
        }
    });

    it('should render the component with right props', async () => {
        expect(component.props().swap.name).toBe('Swap Name');
        expect(component.props().swap.image).toBe('swap-image.jpg');
        expect(component.props().actions.actionOne).toBe('Action One');
        expect(component.props().actions.actionTwo).toBe('Action Two');
    });

    it('should emit an event when the first action is clicked', async () => {
        // Trigger the click event
        await component.trigger('click');
        nextTick();

        const actions = component.findAll('.action-swap');
        await actions[0].trigger('click');

        expect(component.emitted()).toHaveProperty('action');
        const [args] = component.emitted().action;
        expect(args).toEqual(['actionOne']);

    });


});
